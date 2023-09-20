<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        if ($request->api_key=="LetsStart#123") {
            $user = User::create([
                'name' => $request->name,
                'role' => 0,
                'type' => $request->type,
                'company' => $request->company,
                'default_location' => $request->default_loc,
                'phone' => $request->phone,
                'password' => bcrypt($request->password)
            ]);
            return $user;
        }
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ],[
        'phone.required' => 'وارد کردن شماره موبایل اجباریست',
        'password.required' => 'وارد کردن رمزعبور اجباریست',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');

        }

        return back()->withErrors([
            'phone' => 'نام کاربری یا کلمه عبور اشتباه است',
        ])->onlyInput('phone');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
