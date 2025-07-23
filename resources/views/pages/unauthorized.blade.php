<!-- resources/views/pages/unauthorized.blade.php -->
<x-guest1-layout>
    <div class="container py-4">
        <div class="alert alert-warning text-center">
            <h4>⚠️ Access Denied</h4>
            <p>You don't have permission to access this dashboard.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
        </div>
    </div>
</x-guest1-layout>
