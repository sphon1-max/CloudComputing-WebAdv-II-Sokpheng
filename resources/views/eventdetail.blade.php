<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LEFT: Organizer and Event Details -->
        <div class="space-y-4">
            <div>
                <label class="block text-gray-600 font-semibold">Event ID</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['id'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Organizer Name</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['organizer']['name'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Organizer Email</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['organizer']['email'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Organizer Phone</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['organizer']['phone_number'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Event Name</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['event_name'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Category</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event['category']['category_name'] ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Seats</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $maxSeats ?? 'N/A' }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Location</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="City: {{ $event['city']['name'] ?? 'N/A' }}, Address: {{ $event['address'] ?? 'N/A' }}" readonly>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-gray-600 font-semibold">Start</label>
                    <input class="w-full bg-yellow-100 rounded p-2" value="{{ isset($event['start_date']) ? \Carbon\Carbon::parse($event['start_date'])->format('Y-m-d H:i') : 'N/A' }}" readonly>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold">End</label>
                    <input class="w-full bg-yellow-100 rounded p-2" value="{{ isset($event['end_date']) ? \Carbon\Carbon::parse($event['end_date'])->format('Y-m-d H:i') : 'N/A' }}" readonly>
                </div>
            </div>
        </div>

        <!-- RIGHT: Description, Images, Tickets, Status -->
        <div class="space-y-6">
            <!-- Description -->
            <div>
                <label class="block text-gray-600 font-semibold">Description</label>
                <textarea class="w-full bg-yellow-100 rounded p-2 h-32 resize-none" readonly>{{ $event['description'] ?? 'No description available' }}</textarea>
            </div>

            <!-- Horizontal Scroll Image -->
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Event Images</label>
                <div class="flex overflow-x-auto gap-4 scrollbar-hide">
                    @if(isset($event['eventimage']) && is_array($event['eventimage']))
                    @foreach ($event['eventimage'] as $img)
                    <div class="flex-shrink-0 w-full max-w-md h-70 rounded-lg overflow-hidden border border-gray-300">
                        <img src="{{ asset('storage/event_images/' . ($img['url'] ?? '')) }}"
                            alt="Event Image"
                            class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/400x200/cccccc/333333?text=No+Image';">
                    </div>
                    @endforeach
                    @else
                    <p class="text-sm text-gray-500">No images available.</p>
                    @endif
                </div>
            </div>

            <!-- Tickets -->
            <div>
                <label class="block text-gray-600 font-semibold">Ticket Prices</label>
                <div class="space-y-2 mt-2">
                    @if(isset($event['tickets']) && is_array($event['tickets']) && count($event['tickets']) > 0)
                    @foreach ($event['tickets'] as $ticket)
                    <div class="flex gap-2">
                        <input class="w-1/3 bg-yellow-100 rounded p-2" value="{{ $ticket['ticket_type'] ?? 'General' }}" readonly>
                        <input class="w-2/3 bg-yellow-100 rounded p-2" value="${{ number_format($ticket['price'] ?? 0, 2) }}" readonly>
                    </div>
                    @endforeach
                    @else
                    <p class="text-sm text-gray-500">No ticket information available.</p>
                    @endif
                </div>
            </div>

            <!-- Status Buttons -->
            <div class="flex gap-4">
                @if (($event['status'] ?? '') === 'pending')
                <form action="{{ route('events.accept', $event['id'] ?? '') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full">
                        Accept
                    </button>
                </form>
                @else
                <button class="px-6 py-2 bg-green-500 text-white rounded-full">Accepted</button>
                @endif

                <form action="{{ route('events.destroy', $event['id'] ?? '') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-6 py-2 bg-red-500 text-white rounded-full">Delete</button>
                </form>

            </div>

            <!-- Back Button -->
            <div class="text-right">
                <a href="/dashboard" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded">
                    Back
                </a>
            </div>
        </div>
    </div>
</body>

</html>