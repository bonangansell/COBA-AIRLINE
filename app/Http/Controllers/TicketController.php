<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    public function store(Request $r)
    {
        // Validasi data yang dikirimkan
        $validated = $r->validate([
            'passenger_name' => 'required|string|max:100',
            'passenger_phone' => 'required|string|max:14',
            'seat_number' => 'required|string|max:5',
            'flight_id' => 'required|exists:flights,id', 
        ]);
    
        // Membuat dan menyimpan tiket baru
        $ticket = new Ticket;
        $ticket->flight_id = $validated['flight_id']; 
        $ticket->passenger_name = $validated['passenger_name'];
        $ticket->passenger_phone = $validated['passenger_phone'];
        $ticket->seat_number = $validated['seat_number'];
        $ticket->save();

    
        return redirect()->route('flights')->with('success', 'Tiket berhasil dipesan!');
    }


    public function board(Ticket $ticket)
    {
        if ($ticket->is_boarding) {
            return redirect()->route('flights')->with('error', 'Tiket sudah check-in.');
        }
    
        $ticket->is_boarding = true;
        $ticket->boarding_time = now(); 
        $ticket->save();
    
        return redirect()->route('flights', ['flight' => $ticket->flight_id])->with('success', 'Check-in berhasil.');
    }


    public function delete(Ticket $ticket)
    {
        if (!$ticket->is_boarding) {
            $ticket->delete();
            return redirect()->route('flights', ['flight' => $ticket->flight_id])->with('success', 'Tiket berhasil dihapus!');
        }

        // Jika sudah check-in, kembalikan pesan error
    return redirect()->route('flights', ['flight' => $ticket->flight_id])
    ->with('error', 'Tiket tidak dapat dihapus setelah check-in.');
    }
}
