<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRegisteredNotification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // public function showRegistrationForm()
    // {
    //     return view('admin.signup');
    // }


    // public function register(Request $request)
    // {

    //  $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //         'contact' => ['required', 'string', 'max:20'],
    //         'admin_name' => ['required', 'string', 'max:255'],
    //     ]);
    //  $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'contact' => $request->contact,
    //         'admin_name' => $request->admin_name,
    //     ]);

    //     Auth::login($user);

    //     return redirect()->route('view.dash')->with('success', 'Account created successfully!');
    // }
    public function showRegistrationForm()
{
    return view('admin.signup'); // Or whatever Blade file you're using
}

//     public function register(Request $request)
// {
//     $request->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
//         'password' => ['required', 'string', 'min:6', 'confirmed'],
//         'contact' => ['required', 'string', 'max:20'],
//         'admin_name' => ['required', 'string', 'max:255'],
//     ]);

//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'contact' => $request->contact,
//         'admin_name' => $request->admin_name,
//     ]);

//     Auth::login($user);

//     // ✅ Send email to you with user info
//     Mail::to('richardogwal97@gmail.com')->send(new AdminRegisteredNotification($user));

//     return redirect()->route('view.dash')->with('success', 'Account created successfully!');
// }
public function register(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
        'contact' => ['required', 'string', 'max:20'],
        'admin_name' => ['required', 'string', 'max:255'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'contact' => $request->contact,
        'admin_name' => $request->admin_name,
        'trial_start_date' => Carbon::now(),          // Set trial start date
        'is_trial_active' => true,                    // Mark trial active
    ]);

    Auth::login($user);

    // ✅ Notify admin
    Mail::to('richardogwal97@gmail.com')->send(new AdminRegisteredNotification($user));

    return redirect()->route('view.dash')->with('success', 'Account created successfully! You have 2 months free access.');
}
}
