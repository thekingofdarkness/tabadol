<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
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
    public function update(Request $request)
    {
        // Get the current user
        $user = auth()->user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        try {
            // Update user data
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->save();

            // Set a success message
            return redirect()->back()->with('success', 'تم تحديث حسابك بنجاح.');
        } catch (\Exception $e) {
            // Handle exception and set an error message
            return redirect()->back()->with('error', 'There was an error updating your profile. Please try again.');
        }
    }

    public function updatePassword(Request $request)
    {
        // Define validation rules, messages, and custom attributes
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed', // confirmed ensures new_password_confirmation field matches
        ];

        $messages = [
            'current_password.required' => 'كلمة السر القديمة مطلوبة',
            'new_password.required' => 'أدخل كلمة السر الجديدة',
            'new_password.min' => 'يجب أن تتضمن كلمة السر :min رمزا.',
            'new_password.confirmed' => 'تأكيد كلمة السر الجديدة غير متطابق.',
        ];

        $attributes = [
            'current_password' => 'كلمة السر القديمة',
            'new_password' => 'كلمة السر الجديدة',
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->route('hashed.update.password.user')
                ->withErrors($validator)
                ->withInput();
        }

        // Get the authenticated user
        $user = auth()->user();

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('hashed.update.password.user')
                ->with('errorPass', 'كلمة السر الحالية خاطئة.');
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect with success message
        return redirect()->route('hashed.update.password.user')
            ->with('successPass', 'تم تحيين كلمة السر الخاصة بكم بنجاح.');
    }
}
