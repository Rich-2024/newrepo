<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoanInquiryMail;

class LoanInquiryController extends Controller
{
    public function showForm()
    {
        return view('loan_inquiry');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'loan_type' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        Mail::to('aldarafoundation.org@gmail.com')->send(new LoanInquiryMail($validated));

        return back()->with('success', 'Your loan inquiry has been sent successfully!');
    }
}
