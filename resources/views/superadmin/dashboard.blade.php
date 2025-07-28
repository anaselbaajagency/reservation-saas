{{-- resources/views/superadmin/dashboard.blade.php --}}
@extends('layouts.superadmin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">📊 Dashboard Super Admin</h1>
    
    {{-- 1. Quick Overview (KPI Cards) --}}
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-light">👥 Utilisateurs inscrits</h6>
                            <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="small-box-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="small mt-2">
                        <span class="badge bg-light text-dark">{{ $stats['total_clients'] }} Clients</span>
                        <span class="badge bg-light text-dark ms-1">{{ $stats['total_experts'] }} Experts</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-light">📅 Réservations</h6>
                            <h3 class="mb-0">{{ $stats['total_reservations'] }}</h3>
                        </div>
                        <div class="small-box-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="small mt-2">
                        <span class="badge bg-light text-dark">{{ $stats['today_reservations'] }} Aujourd'hui</span>
                        <span class="badge bg-light text-dark ms-1">{{ $stats['month_reservations'] }} Ce mois</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-light">💰 Chiffre d'affaires</h6>
                            <h3 class="mb-0">{{ format_money($stats['total_revenue']) }}</h3>
                        </div>
                        <div class="small-box-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="small mt-2">
                        <span class="badge bg-light text-dark">{{ format_money($stats['stripe_revenue']) }} Stripe</span>
                        <span class="badge bg-light text-dark ms-1">{{ format_money($stats['cmi_revenue']) }} CMI</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-light">💸 Revenus plateforme</h6>
                            <h3 class="mb-0">{{ format_money($stats['platform_revenue']) }}</h3>
                        </div>
                        <div class="small-box-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                    <div class="small mt-2">
                        <span class="badge bg-light text-dark">{{ $stats['active_experts'] }} 🟢 Experts actifs</span>
                        <span class="badge bg-light text-dark ms-1">{{ $stats['cancelled_reservations'] }} 🔴 Annulées</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 2. Performance Charts --}}
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    📈 Réservations par période
                </div>
                <div class="card-body">
                    <canvas id="reservationsChart" width="100%" height="40"></canvas>
                </div>
                <div class="card-footer small text-muted">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active" data-period="day">Par jour</button>
                        <button class="btn btn-outline-secondary" data-period="week">Par semaine</button>
                        <button class="btn btn-outline-secondary" data-period="month">Par mois</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    💸 Revenus par canal
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="100%" height="40"></canvas>
                </div>
                <div class="card-footer small text-muted">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active" data-period="day">Par jour</button>
                        <button class="btn btn-outline-secondary" data-period="week">Par semaine</button>
                        <button class="btn btn-outline-secondary" data-period="month">Par mois</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 3. Recent Activity Table --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Dernières activités
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="recentActivityTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivities as $activity)
                        <tr>
                            <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($activity->type === 'new_user')
                                <span class="badge bg-primary">Nouveau compte</span>
                                @elseif($activity->type === 'reservation')
                                <span class="badge bg-success">Réservation</span>
                                @elseif($activity->type === 'profile_update')
                                <span class="badge bg-info">Modification profil</span>
                                @elseif($activity->type === 'payment')
                                <span class="badge bg-warning">Paiement</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.users.show', $activity->user_id) }}">
                                    {{ $activity->user->name }}
                                </a>
                            </td>
                            <td>{{ $activity->action }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $activity->details }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- 4. Quick Moderation --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-danger bg-opacity-10 mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    🚨 Avis signalés
                </div>
                <div class="card-body">
                    @forelse($reportedReviews as $review)
                    <div class="mb-3 p-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <small>{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="my-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $review->rating ? ' text-warning' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="mb-1">{{ Str::limit($review->comment, 50) }}</p>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm btn-outline-danger me-1">Supprimer</button>
                            <button class="btn btn-sm btn-outline-secondary">Ignorer</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        Aucun avis signalé
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card bg-warning bg-opacity-10 mb-4">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-user-clock me-1"></i>
                    ⛔ Experts à valider
                </div>
                <div class="card-body">
                    @forelse($pendingExperts as $expert)
                    <div class="mb-3 p-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $expert->user->name }}</strong>
                            <small>{{ $expert->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="my-1">
                            <span class="badge bg-secondary">{{ $expert->specialties->first()->name ?? 'Non spécifié' }}</span>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('superadmin.experts.show', $expert->id) }}" class="btn btn-sm btn-outline-primary me-1">Voir</a>
                            <button class="btn btn-sm btn-outline-success">Valider</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        Tous les experts sont validés
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card bg-primary bg-opacity-10 mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-comments me-1"></i>
                    📝 Messages des utilisateurs
                </div>
                <div class="card-body">
                    @forelse($userMessages as $message)
                    <div class="mb-3 p-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $message->user->name }}</strong>
                            <small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($message->content, 50) }}</p>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm btn-outline-primary">Répondre</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        Aucun nouveau message
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    {{-- 5. Top 5 Experts --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-trophy me-1"></i>
                    Top 5 Experts (Réservations)
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach($topExpertsByBookings as $expert)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $expert->user->name }}</div>
                                <small class="text-muted">{{ $expert->specialties->first()->name ?? '' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $expert->appointments_count }}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-money-bill-wave me-1"></i>
                    Top 5 Experts (Revenus)
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach($topExpertsByRevenue as $expert)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $expert->user->name }}</div>
                                <small class="text-muted">{{ $expert->specialties->first()->name ?? '' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ format_money($expert->total_revenue) }}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-star me-1"></i>
                    Top 5 Experts (Notes)
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach($topExpertsByRating as $expert)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $expert->user->name }}</div>
                                <small class="text-muted">{{ $expert->specialties->first()->name ?? '' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ number_format($expert->average_rating, 1) }}/5</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 6. Quick Action Buttons --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bolt me-1"></i>
            Actions rapides
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('superadmin.experts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Ajouter un expert
                </a>
                <a href="{{ route('superadmin.settings') }}" class="btn btn-secondary">
                    <i class="fas fa-cog me-1"></i> Paramètres plateforme
                </a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-file-export me-1"></i> Exporter données
                </button>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#broadcastModal">
                    <i class="fas fa-bullhorn me-1"></i> Envoyer message global
                </button>
            </div>
        </div>
    </div>
    
    {{-- 7. Technical Alerts --}}
    <div class="card border-danger mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-1"></i>
            Alertes techniques
        </div>
        <div class="card-body">
            @if(count($technicalAlerts) > 0)
            <div class="list-group">
                @foreach($technicalAlerts as $alert)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $alert['title'] }}</h5>
                        <small>{{ $alert['time'] }}</small>
                    </div>
                    <p class="mb-1">{{ $alert['message'] }}</p>
                    <small>
                        <a href="{{ $alert['link'] ?? '#' }}" class="text-danger">Voir détails</a>
                    </small>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center text-muted py-3">
                Aucune alerte technique
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Export Modal --}}
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <!-- Modal content for data export -->
</div>

{{-- Broadcast Modal --}}
<div class="modal fade" id="broadcastModal" tabindex="-1" aria-hidden="true">
    <!-- Modal content for broadcast message -->
</div>

@push('scripts')
<script>
    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Reservations Chart
        const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
        const reservationsChart = new Chart(reservationsCtx, {
            type: 'line',
            data: {
                labels: @json($reservationsChart['labels']),
                datasets: [{
                    label: 'Réservations',
                    data: @json($reservationsChart['data']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($revenueChart['labels']),
                datasets: [
                    {
                        label: 'Stripe',
                        data: @json($revenueChart['stripe']),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'CMI',
                        data: @json($revenueChart['cmi']),
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Period switchers
        document.querySelectorAll('[data-period]').forEach(btn => {
            btn.addEventListener('click', function() {
                const period = this.dataset.period;
                // Here you would typically make an AJAX call to get new data
                // For now we'll just toggle active class
                document.querySelectorAll('[data-period]').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endpush
@endsection