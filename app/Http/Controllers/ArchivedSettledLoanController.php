<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivedSettledLoan;

class ArchivedSettledLoanController extends Controller
{
    public function index()
    {
        $archivedLoans = ArchivedSettledLoan::latest()->get();
        return view('business.arhieve', compact('archivedLoans'));
    }

    public function destroy($id)
    {
        $loan = ArchivedSettledLoan::findOrFail($id);
        $loan->delete();

        return redirect()->route('archived_settled_loans.index')->with('success', 'Archived loan deleted.');
    }
}
