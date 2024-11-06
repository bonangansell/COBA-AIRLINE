@php
    use Carbon\Carbon;
@endphp

@extends('base.base')

@section('content')

    <div class="container mx-auto mb-20">

        <div class="flex justify-between mt-10 ">
            <h2 class="mb-4 dark:text-white text-2xl font-bold">Ticket Details For {{ $flight->flight_code }}</h2>
            <h2 class="mb-4 dark:text-white text-2xl font-bold">({{ $tickets->count() }}  Passengers , {{ $tickets->where('is_boarding', true)->count() }} boardings )</h2>            
        </div>

        <hr class=" border-gray-200 my-3" />

        <div class="flex justify-between items-start mb-20">
            <div class="flex flex-row items-center">
                <p class="font-normal text-left text-gray-700 dark:text-white">{{ $flight->origin }} </p>
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
                <p class="font-normal text-left text-gray-700 dark:text-white">{{ $flight->destination }}</p>
            </div>

                <h2 class="mb-4 dark:text-white text-lg font-bold">Departure  {{ Carbon::parse($flight->departure_time)->format('l, d F Y , H:i') }} </h2>
                <h2 class="mb-4 dark:text-white text-lg font-bold">Arrival  {{ Carbon::parse($flight->arrival_time)->format('l, d F Y , H:i') }} </h2>
        </div>
        
        @if($tickets->isEmpty())
            <p class="text-center text-3xl mb-10">No tickets available for this flight.</p>
        @else
        
            <div class="flex">
                <table class="flex-1 bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Passenger Name</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Passenger Phone</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Seat Number</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Boarding Status</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    {{ $loop->iteration}}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    {{ $ticket->passenger_name }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    {{ $ticket->passenger_phone }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    {{ $ticket->seat_number }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    @if($ticket->is_boarding)
                                        <span class="inline-flex items-center py-2 text-sm font-medium text-center text-gray-700 dark:text-gray-400">
                                            {{ Carbon::parse($ticket->boarding_time)->format('d F Y , H:i') }}
                                        </span>
                                    @else
                                        <form action="{{ route('ticket.board', $ticket) }}"  method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" onclick="boardingTicket()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Board Now
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300 text-gray-900 dark:text-white">
                                    <form action="{{ route('ticket.delete', $ticket) }}" onclick="deleteTicket()" onsubmit="return confirmDelete(event, {{ $ticket->is_boarding }})" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900
                                            @if($ticket->is_boarding) opacity-50 cursor-not-allowed @endif"
                                            @if($ticket->is_boarding) disabled @endif>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
</div>

        @endif
    </div>
    <script>
        function confirmDelete(event, isBoarding) {
            if (isBoarding) {
                alert('Tiket ini tidak bisa dihapus karena sudah boarding.');
                event.preventDefault();
                return false;
            }
            return confirm('Hapus Tiket ini?');
        }

        function deleteTicket() {
            sessionStorage.setItem('deleteStatus', 'success');
        }


        function boardingTicket() {
            sessionStorage.setItem('boardingStatus', 'success');
        }
    </script>
@endsection
