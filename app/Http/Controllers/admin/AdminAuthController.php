<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    protected $redirectTo = '/admin/dashboard';
    

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
       $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->intended($this->redirectTo);
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة.');
    }

        public function logout()
        {
            Auth::guard('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/admin/login');
        }

}
