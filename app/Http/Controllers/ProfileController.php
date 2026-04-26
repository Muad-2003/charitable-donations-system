<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        return view('profile.index');
    }


    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $validatedDate = $request->validated();

        $user->update([
            'fullName' => $validatedDate['fullName'],
            'phone_number' => $validatedDate['phone_number'],
            'address' => $validatedDate['address'],
        ]);

        
        if ($request->filled('password')) {

            // Must enter the current password
            if (!$request->filled('current_password')) {
                return redirect()->back()->with('error', 'يجب إدخال كلمة المرور الحالية لتغيير كلمة المرور.');
            }

            
            // Verify the validity of the current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة.');
            }

            // Update the password
            $user->update([
                'password' => Hash::make($validatedDate['password']),
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

}
