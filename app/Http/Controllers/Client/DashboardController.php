<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialty; // Add this import
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    $specialties = Specialty::where('is_active', true)->get();
    
    $query = User::role('expert')
        ->whereHas('expertProfile.specialties')
        ->with(['expertProfile.specialties']);

    if ($request->has('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }

    if ($request->has('specialty')) {
        $query->whereHas('expertProfile.specialties', function($q) use ($request) {
            $q->where('specialties.id', $request->specialty);
        });
    }

    return view('dashboard', [
        'experts' => $query->paginate(10),
        'specialties' => $specialties, // Make sure this matches what you use in the view
        'search' => $request->search,
        'specialty' => $request->specialty
    ]);
}
}