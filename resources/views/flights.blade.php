@php
    use Carbon\Carbon;
@endphp

@extends('base.base')

@section('content')
<div class="grid grid-cols-3 gap-9 my-20 mx-7 ">
        @foreach ($flights as $row)
        
        <div class=" max-w-lg mx-2 p-6 bg-white border border-gray-200 rounded-lg-1 shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between content-center ">
                <h5 class="mb-2 text-2xl text-left font-bold tracking-tight text-gray-900 dark:text-white">{{ $row->flight_code }}</h5>

                <div class="flex flex-row items-center">
                    <p class="font-normal text-left text-gray-700 dark:text-gray-400">{{ $row->origin }} </p>
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                    <p class="font-normal text-left text-gray-700 dark:text-gray-400">{{ $row->destination }}</p>
                </div>
            </div>
            <p class="font-normal text-left text-gray-700 dark:text-gray-400">
                Departure
            </p>

            <p class="font-bold text-left text-white dark:text-white pb-5"> 
                {{ Carbon::parse($row->departure_time)->format('l, d F Y , H:i') }} 
            </p>

            <p class="font-normal text-left text-gray-700 dark:text-gray-400">
                Arrived
            </p>

            <p class="font-bold text-left text-white dark:text-white pb-10"> 
                {{ Carbon::parse($row->arrival_time)->format('l, d F Y , H:i') }} 
            </p>

            <div class="flex justify-between">
                <a href="{{ route('flights.book' , $row) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> Book Ticket </a>
                <a href="{{ route('flights.tickets', $row) }}" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-8 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (sessionStorage.getItem('bookingStatus') === 'success') {
            alert('Pemesanan tiket berhasil!');
            sessionStorage.removeItem('bookingStatus');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (sessionStorage.getItem('deleteStatus') === 'success') {
            alert('Delete tiket berhasil!');
            sessionStorage.removeItem('deleteStatus');
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        if (sessionStorage.getItem('boardingStatus') === 'success') {
            alert('Boarding flight berhasil!');
            sessionStorage.removeItem('boardingStatus');
        }
    });
</script>

@endsection
