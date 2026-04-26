<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationCaseRequest;
use App\Http\Requests\UpdateDonationCaseRequest;
use App\Models\DonationCase;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donationCases = DonationCase::query()->filter(request()->only('search'));
        return view('admin.donation_case.index', ['donationCases' => $donationCases->withTrashed()->latest()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $beneficiaries = Beneficiary::select('id', 'fullName')->orderBy('fullName')->get();
        return view('admin.donation_case.create', compact('beneficiaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationCaseRequest $request)
    {
        $validatedDate = $request->validated();

         if ($request->hasFile('img')) {
            $validatedDate['img_url'] =
                $request->file('img')->store('donation_cases', 'public');
        }

        DonationCase::create($validatedDate);

        return redirect()->route('donation_case.index')->with('success', 'حالة جديد تم إضافته بنجاح');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(DonationCase $donationCase)
    {
        return view('admin.donation_case.show', compact('donationCase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DonationCase $donationCase)
    {
        /* $beneficiaries = Beneficiary::select('id', 'fullName')->orderBy('fullName')->get(); */
        return view('admin.donation_case.edit', compact('donationCase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationCaseRequest $request, DonationCase $donationCase)
    {
        $validatedDate = $request->validated();

        if ($request->hasFile('img')) {

            if ($donationCase->img_url) {
                Storage::disk('public')->delete($donationCase->img_url);
            }
            $validatedDate['img_url'] =
                $request->file('img')->store('donation_cases', 'public');
        }

        $donationCase->update($validatedDate);

        return redirect()->route('donation_case.index')->with('success', 'حالة تم تحديثها بنجاح');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DonationCase $donationCase)
    {
        $donationCase->delete();
        return redirect()->route('donation_case.index')->with('success', 'حالة تم حذفها بنجاح');
    }

    public function restore($id)
    {
        $donationCase = DonationCase::withTrashed()->findOrFail($id);
        $donationCase->restore();
        return redirect()->route('donation_case.index')->with('success', 'حالة تم استعادتها بنجاح');
    }
}
