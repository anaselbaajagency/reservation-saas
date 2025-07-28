<?php
namespace App\Http\Controllers\Client;

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $specialties = Specialty::where('is_active', true)->get();
        
        $query = User::role('expert')
            ->whereHas('expertProfile') // Only require expert profile
            ->with(['expertProfile.specialties']);

        // Search filter
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Specialty filter
        if ($request->has('specialty')) {
            $query->whereHas('expertProfile.specialties', function($q) use ($request) {
                $q->where('specialties.id', $request->specialty);
            });
        }

        return view('dashboard', [
            'experts' => $query->paginate(10),
            'specialties' => $specialties,
            'search' => $request->search,
            'specialty' => $request->specialty
        ]);
    }

    public function showExpert($id)
    {
        $expert = User::role('expert')
            ->with(['expertProfile.specialties'])
            ->findOrFail($id);
            
        return view('dashboard', compact('expert'));
    }
}