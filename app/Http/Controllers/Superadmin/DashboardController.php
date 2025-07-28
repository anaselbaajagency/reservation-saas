<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ExpertProfile;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Review;
use App\Models\UserMessage;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Quick Overview (KPI Cards)
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::role('client')->count(),
            'total_experts' => User::role('expert')->count(),
            'total_reservations' => Reservation::count(),
            'today_reservations' => Reservation::whereDate('created_at', today())->count(),
            'month_reservations' => Reservation::whereMonth('created_at', now()->month)->count(),
            'total_revenue' => Payment::sum('amount'),
            'stripe_revenue' => Payment::where('payment_method', 'stripe')->sum('amount'),
            'cmi_revenue' => Payment::where('payment_method', 'cmi')->sum('amount'),
            'platform_revenue' => Payment::sum('amount'),
            'active_experts' => ExpertProfile::where('verified', 1)->count(),
            'cancelled_reservations' => Reservation::where('status', 'cancelled')->count(),
        ];

        // 2. Performance Charts
        $reservationsChart = $this->getReservationsChartData();
        $revenueChart = $this->getRevenueChartData();

        // 3. Recent Activity Table
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        $pendingExperts = ExpertProfile::where('verified', false)
            ->with(['user', 'specialties'])
            ->latest()
            ->limit(3)
            ->get();

        $userMessages = UserMessage::with('user')
            ->whereNull('admin_id')
            ->latest()
            ->limit(3)
            ->get();

        // 5. Top 5 Experts
        $topExpertsByBookings = ExpertProfile::with(['user', 'specialties'])
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->limit(5)
            ->get();

        $topExpertsByRevenue = ExpertProfile::query()
    ->select([
        'expert_profiles.id',
        'expert_profiles.user_id',
        'expert_profiles.hourly_rate',
        DB::raw('SUM(payments.amount) as total_revenue')
    ])
    ->with(['user', 'specialties'])
    ->leftJoin('appointments', 'appointments.expert_profile_id', '=', 'expert_profiles.id')
    ->leftJoin('payments', 'payments.appointment_id', '=', 'appointments.id')
    ->groupBy([
        'expert_profiles.id',
        'expert_profiles.user_id',
        'expert_profiles.hourly_rate'
    ])
    ->orderBy('total_revenue', 'desc')
    ->limit(5)
    ->get();

        $topExpertsByRating = ExpertProfile::with(['user', 'specialties'])
            ->selectRaw('expert_profiles.*, AVG(reviews.rating) as average_rating')
            ->leftJoin('reviews', 'reviews.expert_profile_id', '=', 'expert_profiles.id')
            ->groupBy('expert_profiles.id')
            ->orderBy('average_rating', 'desc')
            ->limit(5)
            ->get();

        // 7. Technical Alerts
        $technicalAlerts = $this->getTechnicalAlerts();

        return view('superadmin.dashboard', compact(
            'stats',
            'reservationsChart',
            'revenueChart',
            'recentActivities',
            'reportedReviews',
            'pendingExperts',
            'userMessages',
            'topExpertsByBookings',
            'topExpertsByRevenue',
            'topExpertsByRating',
            'technicalAlerts'
        ));
    }

    protected function getReservationsChartData()
    {
        // Last 30 days by default
        $labels = [];
        $data = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Reservation::whereDate('created_at', $date)->count();
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    protected function getRevenueChartData()
    {
        // Last 30 days by default
        $labels = [];
        $stripe = [];
        $cmi = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            $stripe[] = Payment::whereDate('created_at', $date)
                ->where('payment_method', 'stripe')
                ->sum('amount');
            $cmi[] = Payment::whereDate('created_at', $date)
                ->where('payment_method', 'cmi')
                ->sum('amount');
        }
        
        return [
            'labels' => $labels,
            'stripe' => $stripe,
            'cmi' => $cmi,
        ];
    }

    protected function getTechnicalAlerts()
    {
        $alerts = [];
        
        // Failed payments
        $failedPayments = Payment::where('status', 'failed')
            ->where('created_at', '>', now()->subDay())
            ->count();
            
        if ($failedPayments > 0) {
            $alerts[] = [
                'title' => 'Paiements échoués',
                'message' => "$failedPayments paiements ont échoué aujourd'hui",
                'time' => now()->diffForHumans(),
                'link' => route('superadmin.payments.index', ['status' => 'failed']),
            ];
        }
        
        // Experts without availability
        $expertsWithoutAvailability = ExpertProfile::whereDoesntHave('availabilitySlots')
            ->where('is_active', true)
            ->count();
            
        if ($expertsWithoutAvailability > 0) {
            $alerts[] = [
                'title' => 'Experts sans disponibilités',
                'message' => "$expertsWithoutAvailability experts actifs n'ont pas configuré leurs disponibilités",
                'time' => now()->diffForHumans(),
                'link' => route('superadmin.experts.index', ['has_availability' => 0]),
            ];
        }
        
        return $alerts;
    }
}