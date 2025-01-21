<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.passwords.email'); // Your custom view for the email form
    }

    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $token = Str::random(60);
        $email = $request->email;

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Send email
        Mail::send('auth.emails.password', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('status', 'تم إرسال رابط لاسترجاع حسابك إلى بريدك الالكتروني !');
    }
}
