<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::query()->filter(request()->only('search'));
        return view('admin.users.index', ['users' => $users->latest()->paginate(15)]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required'
        ]);
        $user->update([
            'status' => $request->status
        ]);
        DB::table('users')->where('id', $user->id)->update(['remember_token' => null]);
        DB::table('sessions')->where('user_id', $user->id)->delete();

        return redirect()->route('user.index')->with('success', 'تم تحديث حالة المستخدم بنجاح');
    }

    public function logoutAllUsers(){
        DB::table('sessions')->delete();

        User::query()->update(['remember_token' => null]);
        
        return redirect()->back()->with('success', 'تم تسجيل خروج جميع المستخدمين');
    }

}
