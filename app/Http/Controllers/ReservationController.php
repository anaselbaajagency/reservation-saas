<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpertProfile; 
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function create(ExpertProfile $expert) 
    {
        return view('dashboard', compact('expert'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expert_profile_id' => 'required|exists:expert_profiles,id', 
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string'
        ]);
        
        $validated['user_id'] = auth()->id();
        
        Reservation::create($validated);
        
        return redirect()->route('client.dashboard')
            ->with('success', 'Reservation created successfully!');
    }
}