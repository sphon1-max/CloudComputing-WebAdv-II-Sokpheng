<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/mylogo.png') }}">
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LEFT: Organizer and Event Details -->
        <div class="space-y-4">
            <div>
                <label class="block text-gray-600 font-semibold">Event ID</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event->id }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Organizer Name</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event->organizer->name }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Organizer Email</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event->organizer->email }}" readonly>
            </div>

            <div>
                <label class="block text-gray-600 font-semibold">Event Name</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event->title }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Category</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $event->category->name }}" readonly>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Seats</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="{{ $maxSeats }}" readonly>


            </div>
            <div>
                <label class="block text-gray-600 font-semibold">Location</label>
                <input class="w-full bg-yellow-100 rounded p-2" value="City: {{ $event->city->name }}, Venue: {{ $event->venue }}" readonly>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-gray-600 font-semibold">Start</label>
                    <input class="w-full bg-yellow-100 rounded p-2" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d H:i') }}" readonly>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold">End</label>
                    <input class="w-full bg-yellow-100 rounded p-2" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d H:i') }}" readonly>
                </div>
            </div>
        </div>

        <!-- RIGHT: Description, Images, Tickets, Status -->
        <div class="space-y-6">
            <!-- Description -->
            <div>
                <label class="block text-gray-600 font-semibold">Description</label>
                <textarea class="w-full bg-yellow-100 rounded p-2 h-32 resize-none" readonly>{{ $event->description }}</textarea>
            </div>

            <!-- Horizontal Scroll Image -->
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Event Images</label>
                <div class="flex overflow-x-auto gap-4 scrollbar-hide">
                    @foreach ($event->eventimage as $img)
                    <div class="flex-shrink-0 w-full max-w-md" style="height: 280px; max-width: 400px; min-width: 300px;">
                        <div class="h-full w-full rounded-lg overflow-hidden border border-gray-300" style="height: 100%; width: 100%;">
                            <img src="http://localhost:8000/storage/{{$img->image_path}}"
                                alt="Event Image"
                                style="width: 100%; height: 100%; object-fit: cover; min-width: 300px; max-width: 400px; min-height: 200px; max-height: 280px;"
                                onerror="this.src='https://placehold.co/400x200/cccccc/333333?text=No+Image';">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tickets -->
            <div>
                <label class="block text-gray-600 font-semibold">Ticket Prices</label>
                <div class="space-y-2 mt-2">
                    @forelse ($event->tickets as $ticket)
                    <div class="flex gap-2">
                        <input class="w-1/3 bg-yellow-100 rounded p-2" value="{{ $ticket->type }}" readonly>
                        <input class="w-2/3 bg-yellow-100 rounded p-2" value="${{ number_format($ticket->price, 2) }}" readonly>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">No ticket information available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Status Buttons -->
            <div class="flex gap-4">
                @if ($event->status === 'draft')
                <form action="{{ route('events.accept', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full">
                        Accept
                    </button>
                </form>
                @else
                <button class="px-6 py-2 bg-green-500 text-white rounded-full">Accepted</button>
                @endif

                <form action="{{ route('events.destroy', $event->id) }}" method="POST">
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