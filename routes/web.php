<?php

use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('flights',['flights'=>Flight::with(['tickets'])->get(), 'tickets'=>Ticket::with(['flights'])->get()] );
})->name('flights')->middleware('auth');

Route::get('flights/tickets/{flight:id}', 
    [FlightController::class, 'showTickets'])
->name('flights.tickets')->middleware('auth');

Route::get('flights/book/{flight:id}', 
    [FlightController::class, 'create'])
->name('flights.book')->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('ticket/submit', [TicketController::class, 'store'])->name('ticket.submit');

Route::put('ticket/board/{ticket:id}', [TicketController::class, 'board'])->name('ticket.board');

Route::delete('ticket/delete/{ticket:id}', [TicketController::class, 'delete'])->name('ticket.delete');
