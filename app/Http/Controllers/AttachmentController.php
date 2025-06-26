<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttachmentController extends Controller
{
    // Show upload form
    public function create($loanId)
    {
        $loan = Loan::where('id', $loanId)
            ->where('user_id', Auth::id()) 
            ->firstOrFail();

        return view('attachments.upload', compact('loan'));
    }

    // Store uploaded file
    public function store(Request $request, $loanId)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $loan = Loan::where('id', $loanId)
            ->where('user_id', Auth::id()) // ✅ Restrict access
            ->firstOrFail();

        $file = $request->file('attachment');
        $path = $file->store('attachments', 'public');

        $loan->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()->route('loans.clients.index')->with('success', 'Attachment uploaded.');
    }

    // View attachments for a loan
    public function index($loanId)
    {
        $loan = Loan::with('attachments')
            ->where('id', $loanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('attachments.view', compact('loan'));
    }
}
