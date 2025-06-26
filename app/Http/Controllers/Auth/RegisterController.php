<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.signup');
    }


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
        ]);

        Auth::login($user);

        return redirect()->route('view.dash')->with('success', 'Account created successfully!');
    }
}
