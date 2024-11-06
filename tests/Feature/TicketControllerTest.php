<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Flight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\FlightSeeder;
use Illuminate\Support\Carbon;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FlightSeeder::class);
    }

    public function test_store_creates_ticket_successfully()
    {
        $flight = DB::table('flights')->first();

        $data = [
            'passenger_name' => 'John Doe',
            'passenger_phone' => '081234567890',
            'seat_number' => 'A1',
            'flight_id' => $flight->id,
        ];

        $response = $this->post(route('ticket.submit'), $data);

        $response->assertRedirect(route('flights'));
        $response->assertSessionHas('success', 'Tiket berhasil dipesan!');

        $this->assertDatabaseHas('tickets', [
            'passenger_name' => 'John Doe',
            'passenger_phone' => '081234567890',
            'seat_number' => 'A1',
            'flight_id' => $flight->id,
        ]);
    }

    public function test_board_checks_in_ticket_successfully()
{
    // Ambil flight pertama dari database
    $flight = DB::table('flights')->first();


    // Pastikan flight_id disertakan saat membuat tiket
    $ticket = Ticket::create([
        'flight_id' => $flight->id,  // Pastikan field ini diisi
        'passenger_name' => 'John Doe',
        'passenger_phone' => '081234567890',
        'seat_number' => 'A1',
        'is_boarding' => false,
    ]);

    // Lakukan permintaan untuk check-in
    $response = $this->put(route('ticket.board', $ticket->id));

    // Periksa apakah berhasil melakukan check-in
    $response->assertRedirect(route('flights', ['flight' => $flight->id]));
    $response->assertSessionHas('success', 'Check-in berhasil.');

    // Cek apakah tiket diupdate dengan is_boarding true
    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'is_boarding' => true,
    ]);

    // Cek apakah boarding_time diatur dengan waktu yang benar
    $this->assertTrue(Carbon::parse($ticket->fresh()->boarding_time)->isSameMinute(Carbon::now()));
}


    public function test_delete_removes_ticket_successfully()
    {
        $flight = DB::table('flights')->first();

        $ticket = Ticket::create([
            'flight_id' => $flight->id,
            'passenger_name' => 'John Doe',
            'passenger_phone' => '081234567890',
            'seat_number' => 'A1',
            'is_boarding' => false,
        ]);

        $response = $this->delete(route('ticket.delete', $ticket->id));

        $response->assertRedirect(route('flights', ['flight' => $flight->id]));
        $response->assertSessionHas('success', 'Tiket berhasil dihapus!');

        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }

    public function test_delete_does_not_remove_checked_in_ticket()
    {
        $flight = DB::table('flights')->first();

        $ticket = Ticket::create([
            'flight_id' => $flight->id,
            'passenger_name' => 'John Doe',
            'passenger_phone' => '081234567890',
            'seat_number' => 'A1',
            'is_boarding' => true,
        ]);

        $response = $this->delete(route('ticket.delete', $ticket->id));

        // Cek apakah tiket tidak dihapus jika sudah check-in
        $response->assertRedirect(route('flights', ['flight' => $flight->id]));
        $response->assertSessionHas('error', 'Tiket tidak dapat dihapus setelah check-in.');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
        ]);
    }


    public function test_store_fails_with_invalid_input_length()
{
    $flight = DB::table('flights')->first();

    // Data dengan panjang karakter yang lebih dari batas maksimal
    $data = [
        'passenger_name' => str_repeat('a', 101), // Lebih dari 100 karakter
        'passenger_phone' => str_repeat('0', 15), // Lebih dari 14 karakter
        'seat_number' => str_repeat('A', 6), // Lebih dari 5 karakter
        'flight_id' => $flight->id,
    ];

    $response = $this->post(route('ticket.submit'), $data);

    // Periksa apakah ada error validation
    $response->assertSessionHasErrors([
        'passenger_name',
        'passenger_phone',
        'seat_number',
    ]);
}

public function test_store_fails_with_missing_input_length()
{
    $flight = DB::table('flights')->first();

    // Data dengan panjang karakter kurang dari batas minimal
    $data = [
        'passenger_name' => '', // Nama penumpang kosong
        'passenger_phone' => '', // Nomor telepon kosong
        'seat_number' => '', // Nomor kursi kosong
        'flight_id' => $flight->id,
    ];

    $response = $this->post(route('ticket.submit'), $data);

    // Periksa apakah ada error validation
    $response->assertSessionHasErrors([
        'passenger_name',
        'passenger_phone',
        'seat_number',
    ]);
}

}
