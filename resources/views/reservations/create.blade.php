<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Book Consultation with {{ $expert->name }}</h1>
    
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="expert_profile_id" value="{{ $expert->id }}">
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Date and Time</label>
            <input type="datetime-local" name="scheduled_at" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Notes</label>
            <textarea name="notes" class="w-full p-2 border rounded" rows="4"></textarea>
        </div>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Confirm Reservation
        </button>
    </form>
</div>
