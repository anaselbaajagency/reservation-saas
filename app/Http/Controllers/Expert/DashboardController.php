<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the expert dashboard.
     */
    public function index()
    {
        return view('dashboard');
        // Add any expert-specific data you need to pass to the view
    }
}