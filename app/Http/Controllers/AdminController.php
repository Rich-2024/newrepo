<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Loan;
    use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
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
    // dd($request->all());
    $user = auth()->user();

    if (!$user) {
        return redirect()->back()->with('error', 'You must be logged in to update your profile.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'current_password' => 'nullable|required_with:new_password|current_password',
        'new_password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    // Update name and email
    $user->name = $request->name;
    $user->email = $request->email;

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if it exists
        if ($user->profile_picture) {
            $oldPath = str_replace('/storage/', '', $user->profile_picture);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = '/storage/' . $path;
    }

    // Update password if provided
    if ($request->filled('new_password')) {
        $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
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

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP and user ID in session
        session(['otp' => $otp, 'otp_user_id' => Auth::id()]);

        // Send OTP to email
        Mail::to(Auth::user()->email)->send(new OtpMail($otp));

        // Logout immediately until verified
        Auth::logout();

        return redirect()->route('otp.verify.form')->with('success', 'OTP has been sent to your email.');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success',"You're loggedout ");
    }
   public function clientsIndex(Request $request)
{
    $search = $request->input('search');
    $userId = Auth::id();

    $loans = Loan::query()
        ->where('user_id', $userId)
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%");
        })
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('clients.clients_index', compact('loans'));
}

}


