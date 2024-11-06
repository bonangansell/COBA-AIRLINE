<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;

class FlightController extends Controller
{
    public function showTickets(Flight $flight)
    {
        $tickets = $flight->tickets;

        return view('flights.tickets', compact('flight', 'tickets'));
    }

    public function create(Flight $flight)
    {
        return view('flights.book', compact('flight'));
    }
}
