<?php

namespace App\Http\Controllers;

use App\Models\PrepaidCard;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use App\Models\DonationCase;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    private WalletService $service;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
    }
    
    
    public function index()
    {
        $user = auth()->user();
        $transctions = WalletTransaction::where('wallet_id', $user->wallet->id)->latest()->get();
        return view('wallet.index', compact('transctions'));
    }

    
    public function top_up(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:8',
        ]);
        $user = auth()->user();
        $code = $request->input('code');

        try {
            DB::transaction(function () use ($code, $user) {
                // fetch the prepaid card with a row lock to avoid races
                $card = PrepaidCard::where('code', $code)->lockForUpdate()->first();

                if (!$card) {
                    throw new \RuntimeException('كود البطاقة غير صحيح');
                }

                if ($card->is_used) {
                    throw new \RuntimeException('البطاقة مستخدمة من قبل');
                }

                // mark the card as used and perform the deposit in the same transaction
                $card->update(['is_used' => true]);

                $this->service->deposit($user, $card->amount, 'شحن محفظه');
            });

            return redirect()->back()->with('success', 'تم شحن المحفظه بنجاح');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'حدث خطأ خلال العملية');
        }
        
    }


    // Withdraw funds from beneficiary wallet
    public function withdraw(Request $request, Beneficiary $beneficiary)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            $amount = $request->amount;


            // Execute the withdraw
            $this->service->withdraw(
                $beneficiary,
                $amount,
                'سحب رصيد مستفيد #' . $beneficiary->fullName
            );

            return back()->with('success', 'تم سحب المبلغ بنجاح');

        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }




    
    public function donate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'donation_case_id' => 'required|exists:donation_cases,id',
        ]);
        try {
            $amount = $request->amount;
            $user = auth()->user();

            DB::transaction(function () use ($request, $amount, $user) {

                //fetch donation case with lock
                $donationCase = DonationCase::lockForUpdate()
                    ->findOrFail($request->donation_case_id);

                //get the beneficiary related to the donation case
                $beneficiary = Beneficiary::findOrFail($donationCase->beneficiary_id);

                // Execute the transfe
                $this->service->transfer(
                    $user,
                    $beneficiary,
                    $amount,
                    'تبرع لحالة ' . $donationCase->title,
                    $donationCase->id
                );

                //update the current amount in the donation case
                $donationCase->current_amount += $amount;

                //check if the donation case is completed
                if ($donationCase->current_amount >= $donationCase->target_amount) {
                    $donationCase->current_amount = $donationCase->target_amount; // to ensure that the amount does not exceed the target
                    $donationCase->status = 'completed';
                }

                //save the changes
                $donationCase->save();
            });

            return redirect()->back()->with('success', 'تم التبرع بنجاح');
            
        }catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        
    }

    
}