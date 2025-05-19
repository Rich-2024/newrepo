<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
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
}

