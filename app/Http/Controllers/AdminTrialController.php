<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Mail;
use App\Mail\TrialRenewedMail;

class AdminTrialController extends Controller{

  public function showRenewalForm()
{
   
    $users = User::all();
    return view('admin.renew-trial', compact('users'));
}


  
 public function renewTrial(Request $request)
{
    
    $request->validate([
        'user_id' => 'required|exists:users,id', 
        'months' => 'required|integer|min:1',    
    ]);


    $user = User::find($request->user_id);

    if ($user) {
        // Convert the months to an integer to avoid any type issues
        $months = (int) $request->months; 

      
        $newTrialEndDate = Carbon::parse($user->trial_start_date)->addMonths($months);


        $user->trial_start_date = Carbon::now();  

      
        $user->trial_end_date = $newTrialEndDate; 

       
        $user->trial_duration_months = $months; 

      
        $user->is_trial_active = true; 

    
        $user->save();

        Mail::to($user->email)->send(new TrialRenewedMail($user, $newTrialEndDate));

        
        return redirect()->route('admin.renew-trial')->with('success', "User's trial has been extended by {$months} months.");
    }

 
    return back()->withErrors(['error' => 'User not found.']);
}

}