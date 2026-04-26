<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiryRequest;
use App\Http\Requests\UpdateBeneficiryRequest;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {        
        $beneficiaries = Beneficiary::query()->filter(request()->only('search'));
        return view('admin.beneficiary.index', ['beneficiaries' => $beneficiaries->latest()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.beneficiary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeneficiryRequest $request)
    {
        
        $validatedDate = $request->validated();

        if ($request->hasFile('personal_photo')) {
            $validatedDate['personal_photo_path'] =
                $request->file('personal_photo')->store('personal_photos', 'public');
        }

        if ($request->hasFile('bank_statement_photo')) {
            $validatedDate['bank_statement_photo_path'] =
                $request->file('bank_statement_photo')->store('bank_statement_photos', 'public');
        }
        
        Beneficiary::create($validatedDate);

        return redirect()->route('beneficiary.index')->with('success', 'مستفيد جديد تم إضافته بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Beneficiary $beneficiary)
    {
        return view('admin.beneficiary.show', compact('beneficiary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficiary $beneficiary)
    {
        return view('admin.beneficiary.edit', compact('beneficiary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeneficiryRequest $request, Beneficiary $beneficiary)
    {
        $validatedDate = $request->validated();

        //
        if ($request->hasFile('personal_photo')) {

            if ($beneficiary->personal_photo_path) {
                Storage::disk('public')->delete($beneficiary->personal_photo_path);
            }

            $validatedDate['personal_photo_path'] =
                $request->file('personal_photo')->store('personal_photos', 'public');
        }

        //
        if ($request->hasFile('bank_statement_photo')) {

            if ($beneficiary->bank_statement_photo_path) {
                Storage::disk('public')->delete($beneficiary->bank_statement_photo_path);
            }

            $validatedDate['bank_statement_photo_path'] =
                $request->file('bank_statement_photo')->store('bank_statement_photos', 'public');
        }

        //
        $beneficiary->update($validatedDate);

        return redirect()->route('beneficiary.index')->with('success', 'مستفيد تم تحديثه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        if ($beneficiary->hasActiveCase()){
            return redirect()
                ->route('beneficiary.index')
                ->with('error', 'لا يمكن حذف المستفيد لوجود حالة تبرع نشطة.');
        }

        if ($beneficiary->hasBalance()) {
            return redirect()
                ->route('beneficiary.index')
                ->with('error', 'لا يمكن حذف المستفيد لوجود رصيد في المحفظة.');
        }

        if ($beneficiary->personal_photo_path) {
            Storage::disk('public')->delete($beneficiary->personal_photo_path);
        }
        if ($beneficiary->bank_statement_photo_path) {
            Storage::disk('public')->delete($beneficiary->bank_statement_photo_path);
        }
        
        $beneficiary->delete();
        
        return redirect()->route('beneficiary.index')->with('success', 'مستفيد تم حذفه بنجاح');
    }
}