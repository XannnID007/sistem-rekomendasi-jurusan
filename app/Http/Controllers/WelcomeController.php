<?php
// app/Http/Controllers/WelcomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page
     */
    public function index()
    {
        return view('welcome');
    }
}
