@extends('base.base')

@section('content')

<div class="flex justify-center my-20">
    <div class="flex-1 mx-20 p-9 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

        <div class="flex justify-between">
            <h2 class="mb-4 dark:text-white text-2xl font-bold">Ticket Booking For :</h2>
            <h2 class="mb-4 dark:text-white text-2xl font-bold">{{ $flight->flight_code }}</h2>            
        </div>

        <hr class=" border-gray-200 my-3" />

        <div class="flex justify-between items-start">
            <div class="flex flex-row items-center">
                <p class="font-normal text-left text-gray-700 dark:text-white">{{ $flight->origin }} </p>
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
                <p class="font-normal text-left text-gray-700 dark:text-white">{{ $flight->destination }}</p>
            </div>

                <h2 class="mb-4 dark:text-white text-lg font-bold">Departure Time: {{ $flight->departure_time }}</h2>
                <h2 class="mb-4 dark:text-white text-lg font-bold">Arrival Time: {{ $flight->arrival_time }}</h2>
        </div>
        
        <form action="{{ route('ticket.submit') }}" method="POST">
            @csrf 
    
            <input type="hidden" name="flight_id" value="{{ $flight->id }}">

            <!-- Nama Pelanggan -->
            <div class="mb-6">
                <label for="passenger_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Passenger Name</label>
                <input type="text" id="passenger_name" name="passenger_name" required 
                    class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="passenger_phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Passenger Phone</label>
                <input type="text" id="passenger_phone" name="passenger_phone" required 
                    class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Nomor Kursi -->
            <div class="mb-6">
                <label for="seat_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seat Number</label>
                <input type="text" id="seat_number" name="seat_number" maxlength="5" required 
                    class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

                <div class="flex justify-end">
                    <a href="{{ route('flights') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-8 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Cancel</a>
                    <!-- Tombol Submit -->
                    <button type="submit" onclick="setBookingStatus()" class="focus:outline-none dark:text-black text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Pesan Tiket</button>            
                </div>
            </form>
    </div>
</div>

<script>
    function setBookingStatus() {
        sessionStorage.setItem('bookingStatus', 'success');
    }

    document.getElementById('seat_number').addEventListener('input', function(event) {
        if (event.target.value.length > 3) {
            alert('Seat number cannot be more than 3 characters.');
            event.target.value = '';
        }
    });

    document.getElementById('passenger_phone').addEventListener('input', function(event) {
        if (event.target.value.length > 14) {
            alert('Passenger phone cannot be more than 14 characters.');
            event.target.value = '';
        }
    });
</script>
@endsection
