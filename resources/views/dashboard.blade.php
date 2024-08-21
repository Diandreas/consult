<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Consultation Requests Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Consultation Requests</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $pendingRequests ?? 0 }}</p>
                                <p class="text-gray-600">Pending</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $acceptedRequests ?? 0 }}</p>
                                <p class="text-gray-600">Accepted</p>
                            </div>
                        </div>
                        <a href="{{ route('consultation_requests.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">View all requests</a>
                    </div>
                </div>

                <!-- Recent Activity -->
{{--                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                    <div class="p-6">--}}
{{--                        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>--}}
{{--                        <ul class="space-y-2">--}}
{{--                            @forelse($recentActivities ?? [] as $activity)--}}
{{--                                <li class="text-sm text-gray-600">{{ $activity }}</li>--}}
{{--                            @empty--}}
{{--                                <li class="text-sm text-gray-600">No recent activities</li>--}}
{{--                            @endforelse--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('consultation_requests.create') }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Create New Request
                            </a>
                            <a href="{{ route('users.index') }}" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                Manage Users
                            </a>
{{--                            <a href="#" class="block w-full text-center bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">--}}
{{--                                View Reports--}}
{{--                            </a>--}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Statistics -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">System Statistics</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $totalUsers ?? 0 }}</p>
                            <p class="text-gray-600">Total Users</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-pink-600">{{ $totalCategories ?? 0 }}</p>
                            <p class="text-gray-600">Categories</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $averageResponseTime ?? 'N/A' }}</p>
                            <p class="text-gray-600">Avg. Response Time</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $satisfactionRate ?? 0 }}%</p>
                            <p class="text-gray-600">Satisfaction Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
