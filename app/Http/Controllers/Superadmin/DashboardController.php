<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\{User, ExpertProfile, Reservation, Payment, Review, UserMessage, ActivityLog, AvailabilitySlot};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', $this->getDashboardData());
    }

    protected function getDashboardData(): array
    {
        return [
            'stats' => $this->getStatistics(),
            'reservationsChart' => $this->getReservationsChartData(),
            'revenueChart' => $this->getRevenueChartData(),
            'recentActivities' => $this->getRecentActivities(),
            'pendingExperts' => $this->getPendingExperts(),
            'userMessages' => $this->getUnreadMessages(),
            'topExpertsByBookings' => $this->getTopExpertsByBookings(),
            'topExpertsByRevenue' => $this->getTopExpertsByRevenue(),
            'topExpertsByRating' => $this->getTopExpertsByRating(),
            'availabilityAlerts' => $this->getAvailabilityAlerts(),
            'technicalAlerts' => $this->getTechnicalAlerts(),
        ];
    }

    protected function getStatistics(): array
    {
        $hasIsActive = Schema::hasColumn('expert_profiles', 'is_active');

        return [
            'total_users' => User::count(),
            'total_clients' => User::role('client')->count(),
            'total_experts' => User::role('expert')->count(),
            'active_experts' => $hasIsActive 
                ? ExpertProfile::active()->verified()->count()
                : ExpertProfile::verified()->count(),
            'experts_without_availability' => $hasIsActive
                ? ExpertProfile::active()
                    ->verified()
                    ->doesntHave('availabilitySlots')
                    ->count()
                : ExpertProfile::verified()
                    ->doesntHave('availabilitySlots')
                    ->count(),
            'total_reservations' => Reservation::count(),
            'today_reservations' => Reservation::whereDate('created_at', today())->count(),
            'month_reservations' => Reservation::whereMonth('created_at', now()->month)->count(),
            'total_revenue' => Payment::successful()->sum('amount'),
            'platform_revenue' => Payment::successful()->sum('amount'), // Add this line
            'stripe_revenue' => Payment::successful()
                ->where('payment_method', Payment::METHOD_STRIPE)
                ->sum('amount'),
            'cmi_revenue' => Payment::successful()
                ->where('payment_method', Payment::METHOD_CMI)
                ->sum('amount'),
            'cancelled_reservations' => Reservation::where('status', 'cancelled')->count(),

            'failed_payments_today' => Payment::failed()
                ->whereDate('created_at', today())
                ->count(),
        ];
    }

    protected function getTopExpertsByBookings()
    {
        return ExpertProfile::with(['user', 'specialties'])
            ->withCount(['appointments as appointments_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderByDesc('appointments_count')
            ->limit(5)
            ->get();
    }

    protected function getTopExpertsByRevenue()
    {
        return ExpertProfile::query()
            ->select([
                'expert_profiles.id',
                'expert_profiles.user_id',
                'expert_profiles.hourly_rate',
                DB::raw('COALESCE(SUM(payments.amount), 0) as total_revenue')
            ])
            ->with(['user', 'specialties'])
            ->leftJoin('appointments', 'appointments.expert_profile_id', '=', 'expert_profiles.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.appointment_id', '=', 'appointments.id')
                    ->where('payments.status', Payment::STATUS_COMPLETED);
            })
            ->groupBy(['expert_profiles.id', 'expert_profiles.user_id', 'expert_profiles.hourly_rate'])
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();
    }

    protected function getTopExpertsByRating()
    {
        return ExpertProfile::with(['user', 'specialties'])
            ->select(['expert_profiles.*'])
            ->withAvg('reviews', 'rating')
            ->having('reviews_avg_rating', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->limit(5)
            ->get();
    }

    protected function getAvailabilityAlerts()
    {
        $alerts = [];
        
        $hasIsActive = Schema::hasColumn('expert_profiles', 'is_active');
        $noAvailability = $hasIsActive
            ? ExpertProfile::active()->verified()->doesntHave('availabilitySlots')->count()
            : ExpertProfile::verified()->doesntHave('availabilitySlots')->count();
            
        if ($noAvailability > 0) {
            $alerts[] = [
                'title' => 'Experts Without Availability',
                'message' => "{$noAvailability} active experts have no availability slots",
                'severity' => 'warning',
                'link' => route('superadmin.experts.index', ['has_availability' => 0]),
            ];
        }
        
        $expiringSlots = AvailabilitySlot::where('start_datetime', '<', now()->addDays(3))
            ->where('status', AvailabilitySlot::STATUS_AVAILABLE)
            ->count();
            
        if ($expiringSlots > 0) {
            $alerts[] = [
                'title' => 'Expiring Availability Slots',
                'message' => "{$expiringSlots} availability slots will expire soon",
                'severity' => 'info',
                'link' => route('superadmin.availability.index'),
            ];
        }
        
        return $alerts;
    }

    protected function getTechnicalAlerts()
    {
        $alerts = [];
        
        $failedPayments = Payment::failed()
            ->where('created_at', '>', now()->subDay())
            ->count();
            
        if ($failedPayments > 0) {
            $alerts[] = [
                'title' => 'Failed Payments',
                'message' => "{$failedPayments} payments failed today",
                'severity' => 'danger',
                'link' => route('superadmin.payments.index', ['status' => Payment::STATUS_FAILED]),
            ];
        }
        
        return $alerts;
    }

    protected function getReservationsChartData()
    {
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
        $labels = [];
        $stripe = [];
        $cmi = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            $stripe[] = Payment::successful()
                ->where('payment_method', Payment::METHOD_STRIPE)
                ->whereDate('created_at', $date)
                ->sum('amount');
            $cmi[] = Payment::successful()
                ->where('payment_method', Payment::METHOD_CMI)
                ->whereDate('created_at', $date)
                ->sum('amount');
        }
        
        return [
            'labels' => $labels,
            'stripe' => $stripe,
            'cmi' => $cmi,
        ];
    }

    protected function getRecentActivities()
    {
        return ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();
    }

    protected function getPendingExperts()
    {
        return ExpertProfile::where('verified', false)
            ->with(['user', 'specialties'])
            ->latest()
            ->limit(3)
            ->get();
    }

    protected function getUnreadMessages()
    {
        return UserMessage::with('user')
            ->whereNull('admin_id')
            ->latest()
            ->limit(3)
            ->get();
    }
}