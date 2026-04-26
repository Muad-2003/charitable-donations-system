<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{



    /* ================= LOGIN ================= */

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return back()->with('error', 'بيانات الدخول غير صحيحة.');
        }

        if (! auth()->user()->status) {
            Auth::logout();
            return back()->with('error', 'حسابك موقوف، الرجاء التواصل مع الإدارة.');
        }

        return redirect()->intended('/');
    }







    /* ================= REGISTER ================= */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullName'      => ['required'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'confirmed', 'min:8'],
            'phone_number'  => ['required', 'digits:10'],
            'address'       => ['required'],
        ]);

        // generate OTP and store registration payload in session
        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $sessionPayload = [
            'data' => [
                'fullName'     => $validated['fullName'],
                'email'        => $validated['email'],
                'password'     => Hash::make($validated['password']),
                'phone_number' => $validated['phone_number'],
                'address'      => $validated['address'],
            ],
            'otp'             => Hash::make($otp),
            'otp_purpose'     => 'register',
            'otp_attempts'    => 0,
            'otp_expires_at'  => now()->addMinutes(10),
        ];

        session(['register_otp' => $sessionPayload]);

        Mail::to($validated['email'])->send(new SendOtpMail($otp));

        return redirect()->route('otp.verify');
    }










    
    /* ================= OTP VERIFY ================= */

    public function showOtpVerifyForm()
    {
        // guard: only allow access if there's a pending registration or password reset
        if (! session()->has('register_otp') && ! session()->has('password_reset_user_id')) {
            return redirect()->route('login')->with('error', 'لا يوجد إجراء قائم يتطلب التحقق');
        }

        return view('auth.otp_verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:4']]);

        // If registration flow is active
        if (session()->has('register_otp')) {
            $reg = session('register_otp');

            if (
                !$reg ||
                !isset($reg['otp']) ||
                $reg['otp_purpose'] !== 'register' ||
                Carbon::parse($reg['otp_expires_at'])->isPast()
            ) {
                session()->forget('register_otp');
                return back()->withErrors(['otp' => 'الرمز منتهي أو غير صالح']);
            }

            if ($reg['otp_attempts'] >= 5) {
                return back()->withErrors(['otp' => 'تم تجاوز عدد المحاولات المسموح بها']);
            }

            if (! Hash::check($request->otp, $reg['otp'])) {
                $reg['otp_attempts']++;
                session(['register_otp' => $reg]);
                return back()->withErrors(['otp' => 'رمز التحقق غير صحيح']);
            }

            // Double-check email uniqueness to avoid race condition
            if (User::where('email', $reg['data']['email'])->exists()) {
                session()->forget('register_otp');
                return redirect()->route('login')->with('error', 'البريد الإلكتروني مستخدم بالفعل، الرجاء تسجيل الدخول أو استعادة كلمة المرور');
            }

            // create the user and mark email as verified
            User::create(attributes: [
                'fullName'         => $reg['data']['fullName'],
                'email'            => $reg['data']['email'],
                'password'         => $reg['data']['password'],
                'phone_number'     => $reg['data']['phone_number'],
                'address'          => $reg['data']['address'],
                'email_verified_at'=> now(),
            ]);

            session()->forget('register_otp');

            return redirect()->route('login')->with('success', 'تم تأكيد البريد الإلكتروني بنجاح');
        }

        // If no registration flow, fallback to login
        return redirect()->route('login');
    }



    public function resendOtp()
    {
        // If registration flow is active
        if (session()->has('register_otp')) {
            $reg = session('register_otp');

            $cacheKey = 'otp_resend_register_'.$reg['data']['email'];
            if (cache()->has($cacheKey)) {
                return back()->withErrors(['otp' => 'انتظر دقيقة قبل إعادة الإرسال']);
            }

            $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            $reg['otp'] = Hash::make($otp);
            $reg['otp_attempts'] = 0;
            $reg['otp_expires_at'] = now()->addMinutes(10);

            session(['register_otp' => $reg]);

            cache()->put($cacheKey, true, now()->addMinute());

            Mail::to($reg['data']['email'])->send(new SendOtpMail($otp));

            return back()->with('success', 'تم إعادة إرسال رمز التحقق');
        }

        // If password reset flow is active
        $user = User::find(session('password_reset_user_id'));

        if (! $user) {
            return redirect()->route('login');
        }

        if (cache()->has('otp_resend_'.$user->id)) {
            return back()->withErrors(['otp' => 'انتظر دقيقة قبل إعادة الإرسال']);
        }

        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $user->update([
            'otp'            => Hash::make($otp),
            'otp_attempts'   => 0,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        cache()->put('otp_resend_'.$user->id, true, now()->addMinute());

        Mail::to($user->email)->send(new SendOtpMail($otp));

        return back()->with('success', 'تم إعادة إرسال رمز التحقق');
    }








    /* ================= FORGOT PASSWORD ================= */

    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function sendForgotOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user->status) {
            return redirect()->route('login')
                ->with('error', 'حسابك موقوف ولا يمكنك تغيير كلمة المرور');
        }

        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $user->update([
            'otp'            => Hash::make($otp),
            'otp_purpose'    => 'reset_password',
            'otp_attempts'   => 0,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new SendOtpMail($otp));

        session(['password_reset_user_id' => $user->id]);

        return redirect()->route('password.reset')
            ->with('success', 'تم إرسال رمز التحقق');
    }




    public function showResetPasswordForm()
    {
        
        if (! session()->has('password_reset_user_id')) {
            return redirect()->route('password.request')
                ->withErrors('انتهت الجلسة، حاول مرة أخرى');
        }

        return view('auth.reset_password');
    }



    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp'      => ['required', 'digits:4'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::find(session('password_reset_user_id'));

        if (
            !$user ||
            $user->otp_purpose !== 'reset_password' ||
            $user->otp_expires_at->isPast()
        ) {
            return back()->withErrors(['otp' => 'الرمز منتهي أو غير صالح']);
        }

        if ($user->otp_attempts >= 5) {
            return back()->withErrors(['otp' => 'تم تجاوز عدد المحاولات']);
        }

        if (! Hash::check($request->otp, $user->otp)) {
            $user->increment('otp_attempts');
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح']);
        }

        $user->update([
            'password'        => Hash::make($request->password),
            'otp'             => null,
            'otp_attempts'    => 0,
            'otp_purpose'     => null,
            'otp_expires_at'  => null,
        ]);

        session()->forget('password_reset_user_id');

        return redirect()->route('login')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }









    
    /* ================= LOGOUT ================= */

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
