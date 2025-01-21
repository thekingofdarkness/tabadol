<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        // Redirect to the appropriate page after successful registration
        return redirect(route('dashboard'));
    }
    public function processLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // Assuming 'login' is either phone or email
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended(route('home')); // Redirect to dashboard or any other page
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'المعلومات التي أدخلتها غير صحيحة، حاول مجددا']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended(route('login'));
    }
}
