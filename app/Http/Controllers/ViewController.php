<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function view(){
        return view('layouts.dashboard');
    }
    public function client(){
        return view('setting.profile');
    }
    public function dashboard(){
        return view('layouts.dashboard');
    }
    public function terms()
{
    return view('business.terms-and-conditions');
}

    public function create()
    {
        return view('clients.create');
    }
    public function repay()
    {
        return view('clients.repayments');
    }
    public function rephist()
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
    public function learn()
    {
        return view('partials.learn');
    }
}


