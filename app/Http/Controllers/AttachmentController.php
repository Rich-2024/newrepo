<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\CopyLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    // Show upload form
    public function create($loanId)
    {
        $loan = CopyLoan::where('id', $loanId)
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

        $loan = CopyLoan::where('id', $loanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $file = $request->file('attachment');
        $path = $file->store('attachments', 'public');

        $loan->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()->route('loans.clients.index')->with('success', 'Attachment uploaded.');
    }

    // View all attachments for a loan
    public function index($loanId)
    {
        $loan = CopyLoan::with('attachments')
            ->where('id', $loanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('attachments.view', compact('loan'));
    }

    // Download a file securely
    public function download($id)
    {
        $attachment = Attachment::with('copyLoan')
            ->where('id', $id)
            ->firstOrFail();

        if ($attachment->copyLoan->user_id !== Auth::id()) {
            abort(403);
        }

        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }

    // Delete an attachment
    public function destroy($id)
    {
        $attachment = Attachment::with('copyLoan')
            ->where('id', $id)
            ->firstOrFail();

        if ($attachment->copyLoan->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete the file from storage
        Storage::disk('public')->delete($attachment->file_path);

        // Delete the database record
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}
