<div class="container mx-auto px-4 py-8 bg-white">
    <!-- Dashboard Header -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Dashboard Super Admin</h1>
    <!-- 1. Quick Overview (KPI Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">👥 Utilisateurs inscrits</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">{{ $stats['total_clients'] }} Clients</span>
                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">{{ $stats['total_experts'] }} Experts</span>
            </div>
        </div>
        
        <!-- Reservations Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">📅 Réservations</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_reservations'] }}</h3>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">{{ $stats['today_reservations'] }} Aujourd'hui</span>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">{{ $stats['month_reservations'] }} Ce mois</span>
            </div>
        </div>
        
        <!-- Revenue Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">💰 Chiffre d'affaires</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ format_money($stats['total_revenue']) }}</h3>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">{{ format_money($stats['stripe_revenue']) }} Stripe</span>
                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">{{ format_money($stats['cmi_revenue']) }} CMI</span>
            </div>
        </div>
        
        <!-- Platform Revenue Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-600">💸 Revenus plateforme</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ format_money($stats['platform_revenue']) }}</h3>
                </div>
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded">{{ $stats['active_experts'] }} 🟢 Experts actifs</span>
                <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded">{{ $stats['cancelled_reservations'] }} 🔴 Annulées</span>
            </div>
        </div>
    </div>
    
    <!-- 2. Performance Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Reservations Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">📈 Réservations par période</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded active">Par jour</button>
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded">Par semaine</button>
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded">Par mois</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="reservationsChart" width="100%" height="100%"></canvas>
            </div>
        </div>
        
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">💸 Revenus par canal</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded active">Par jour</button>
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded">Par semaine</button>
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded">Par mois</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="revenueChart" width="100%" height="100%"></canvas>
            </div>
        </div>
    </div>
    
    <!-- 3. Recent Activity Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Dernières activités</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentActivities as $activity)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activity->type === 'new_user')
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Nouveau compte</span>
                            @elseif($activity->type === 'reservation')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Réservation</span>
                            @elseif($activity->type === 'profile_update')
                            <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded">Modification profil</span>
                            @elseif($activity->type === 'payment')
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Paiement</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            <a href="{{ route('superadmin.users.show', $activity->user_id) }}">
                                {{ $activity->user->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->action }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $activity->details }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- 4. Quick Moderation -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Pending Experts -->
        <div class="bg-white rounded-lg shadow border border-yellow-200">
            <div class="px-6 py-4 border-b border-yellow-200 bg-yellow-50">
                <h2 class="text-lg font-semibold text-yellow-800">⛔ Experts à valider</h2>
            </div>
            <div class="p-6">
                @forelse($pendingExperts as $expert)
                <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                    <div class="flex justify-between">
                        <strong class="text-gray-800">{{ $expert->user->name }}</strong>
                        <small class="text-gray-500">{{ $expert->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="my-2">
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">{{ $expert->specialties->first()->name ?? 'Non spécifié' }}</span>
                    </div>
                    <div class="flex justify-end mt-2 space-x-2">
                        <a href="{{ route('superadmin.experts.show', $expert->id) }}" class="px-3 py-1 text-sm bg-white border border-blue-300 text-blue-700 rounded hover:bg-blue-50">Voir</a>
                        <button class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200">Valider</button>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    Tous les experts sont validés
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- User Messages -->
        <div class="bg-white rounded-lg shadow border border-blue-200">
            <div class="px-6 py-4 border-b border-blue-200 bg-blue-50">
                <h2 class="text-lg font-semibold text-blue-800">📝 Messages des utilisateurs</h2>
            </div>
            <div class="p-6">
                @forelse($userMessages as $message)
                <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                    <div class="flex justify-between">
                        <strong class="text-gray-800">{{ $message->user->name }}</strong>
                        <small class="text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="my-2 text-gray-600 text-sm">{{ Str::limit($message->content, 50) }}</p>
                    <div class="flex justify-end">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Répondre</button>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    Aucun nouveau message
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Top Experts -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">🏆 Top Experts</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">📊 Par réservations</h3>
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach($topExpertsByBookings as $expert)
                            <li class="text-gray-800">
                                <span class="font-medium">{{ $expert->user->name }}</span>
                                <span class="float-right bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">{{ $expert->appointments_count }}</span>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">💰 Par revenus</h3>
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach($topExpertsByRevenue as $expert)
                            <li class="text-gray-800">
                                <span class="font-medium">{{ $expert->user->name }}</span>
                                <span class="float-right bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">{{ format_money($expert->total_revenue) }}</span>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">⭐ Par notes</h3>
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach($topExpertsByRating as $expert)
                            <li class="text-gray-800">
                                <span class="font-medium">{{ $expert->user->name }}</span>
                                <span class="float-right bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">{{ number_format($expert->average_rating, 1) }}/5</span>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 5. Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">⚡ Actions rapides</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('superadmin.experts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i> Ajouter un expert
            </a>
            <a href="{{ route('superadmin.settings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition flex items-center">
                <i class="fas fa-cog mr-2"></i> Paramètres plateforme
            </a>
            <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-file-export mr-2"></i> Exporter données
            </button>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition flex items-center" data-bs-toggle="modal" data-bs-target="#broadcastModal">
                <i class="fas fa-bullhorn mr-2"></i> Envoyer message global
            </button>
        </div>
    </div>
    
    <!-- 6. Technical Alerts -->
    @if(count($technicalAlerts) > 0)
    <div class="bg-white rounded-lg shadow border border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h2 class="text-lg font-semibold text-red-800">⚠️ Alertes techniques</h2>
        </div>
        <div class="divide-y divide-red-100">
            @foreach($technicalAlerts as $alert)
            <div class="p-6 hover:bg-red-50">
                <div class="flex justify-between">
                    <h3 class="font-medium text-red-800">{{ $alert['title'] }}</h3>
                    <small class="text-red-500">{{ $alert['time'] }}</small>
                </div>
                <p class="mt-1 text-gray-600">{{ $alert['message'] }}</p>
                <a href="{{ $alert['link'] ?? '#' }}" class="mt-2 inline-block text-sm text-red-600 hover:text-red-800">Voir détails</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modals would go here -->