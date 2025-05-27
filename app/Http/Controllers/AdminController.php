<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
        public function welcome(){
        return view('welcome');
    }
    public function create()
    {
        return view('admin.create');
    }
    public function repay()
    {
        return view('clients.repayments');
    }
    public function rephis()
    {
        return view('clients.history');
    }
    public function defaulter()
    {
        return view('clients.defaulters');
    }
    public function yearly()
    {
        return view('clients.reports');
    }
    public function month()
    {
        return view('clients.reports');
    }
    public function interest()
    {
        return view('setting.interest');
    }
    public function profile()
    {
        return view('setting.profile');
    }


public function update(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->back()->with('error', 'You must be logged in to update your profile.');
    }

    // Proceed as before
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_picture' => 'nullable|image|max:2048',
        'current_password' => 'nullable|required_with:new_password|current_password',
        'new_password' => ['nullable', 'confirmed', Password::defaults()],
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = '/storage/' . $path;
    }

    if ($request->filled('new_password')) {
        $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}


    public function showLoginForm()
    {
        return view('admin.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/view')->with('success','login successful'); 
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match system records 🙈.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success',"You're loggedout ");
    }
}


