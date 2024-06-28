<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
        // middleware checking the user to redirect to the right path
    }


    public function index() {
        return view('dashboard');
    }

    public function adminHome() {
        return view('dashboard-admin');
    }
}
