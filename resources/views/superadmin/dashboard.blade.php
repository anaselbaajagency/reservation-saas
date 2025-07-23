{{-- resources/views/superadmin/dashboard.blade.php --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            {{-- Dashboard Header --}}
            <div class="p-6 bg-indigo-700 text-white">
                <h2 class="text-2xl font-bold">Super Admin Dashboard</h2>
                <p class="mt-2">Welcome back, {{ auth()->user()->name }}! You have full system access.</p>
            </div>

            {{-- Key Metrics --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6">
                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Total Users</h3>
                    <p class="text-2xl font-bold dark:text-white">1,248</p>
                    <p class="text-green-500 text-sm">↑ 12% from last month</p>
                </div>
                
                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Active Reservations</h3>
                    <p class="text-2xl font-bold dark:text-white">342</p>
                    <p class="text-green-500 text-sm">↑ 8% from yesterday</p>
                </div>
                
                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Revenue (30d)</h3>
                    <p class="text-2xl font-bold dark:text-white">$24,580</p>
                    <p class="text-green-500 text-sm">↑ 15% from last month</p>
                </div>
                
                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">System Health</h3>
                    <p class="text-2xl font-bold text-green-500">Operational</p>
                    <p class="text-gray-400 text-sm">All systems normal</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('superadmin.roles.index') }}" class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-user-shield text-indigo-600 dark:text-indigo-300 text-2xl mb-2"></i>
                        <p class="font-medium dark:text-white">Manage Roles</p>
                    </a>
                    <a href="{{ route('superadmin.reservations.create') }}" class="bg-green-100 dark:bg-green-900 p-4 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-calendar-plus text-green-600 dark:text-green-300 text-2xl mb-2"></i>
                        <p class="font-medium dark:text-white">Create Reservation</p>
                    </a>
                    <a href="#" class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-users-cog text-blue-600 dark:text-blue-300 text-2xl mb-2"></i>
                        <p class="font-medium dark:text-white">User Management</p>
                    </a>
                    <a href="#" class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-cog text-purple-600 dark:text-purple-300 text-2xl mb-2"></i>
                        <p class="font-medium dark:text-white">System Settings</p>
                    </a>
                </div>
            </div>

            {{-- Recent Activity & System Alerts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="font-medium text-gray-900 dark:text-white">Recent Activity</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-600">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
                                    <i class="fas fa-user-plus text-green-600 dark:text-green-300"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium dark:text-white">New user registered</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">John Doe (Client) - 2 hours ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                    <i class="fas fa-calendar-check text-blue-600 dark:text-blue-300"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium dark:text-white">Reservation completed</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Conference Room #3 - 5 hours ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="bg-yellow-100 dark:bg-yellow-900 p-2 rounded-full">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-300"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium dark:text-white">Payment issue detected</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Transaction #45821 failed - 1 day ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-700 rounded-lg shadow">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="font-medium text-gray-900 dark:text-white">System Alerts</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mt-1">
                                <i class="fas fa-check text-green-600 dark:text-green-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium dark:text-white">Database backup completed</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Last backup: Today 03:00 AM</p>
                            </div>
                        </div>
                        <div class="flex items-start mt-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full mt-1">
                                <i class="fas fa-sync-alt text-blue-600 dark:text-blue-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium dark:text-white">Scheduled maintenance</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Planned for Saturday, 2:00 AM - 4:00 AM</p>
                            </div>
                        </div>
                        <div class="flex items-start mt-4">
                            <div class="bg-red-100 dark:bg-red-900 p-2 rounded-full mt-1">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium dark:text-white">Storage reaching limit</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">85% of disk space used</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Users Table --}}
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recently Registered Users</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">John Doe</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">john@example.com</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Client</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">2 hours ago</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-200">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">Jane Smith</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">jane@example.com</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Expert</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">1 day ago</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-200">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-200">View all users →</a>
                </div>
            </div>
        </div>
    </div>
</div>