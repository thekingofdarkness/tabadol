<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        $tokenData = DB::table('password_resets')->where('token', $token)->first();

        if (!$tokenData || Carbon::parse($tokenData->created_at)->addMinutes(config('auth.passwords.users.expire'))->isPast()) {
            return view('auth.passwords.invalid-token'); // Custom view for invalid token
        }

        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'token' => 'required'
        ]);

        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$tokenData || Carbon::parse($tokenData->created_at)->addMinutes(config('auth.passwords.users.expire'))->isPast()) {
            return back()->withErrors(['token' => 'Token is invalid or expired.']);
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $tokenData->email)->delete();

        return redirect()->route('login')->with('status', 'Password has been reset!');
    }
}
