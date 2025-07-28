<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('superadmin.settings.index');
    }

    public function edit()
    {
        return view('superadmin.settings.edit');
    }

    public function update(Request $request)
    {
        // Add your settings update logic here
        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Settings updated successfully');
    }
}