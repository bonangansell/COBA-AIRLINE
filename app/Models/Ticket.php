<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $guarded = ['id'];

    // protected $fillable = [
    //     'passenger_name', 'passenger_phone','seat_number'
    // ];

    public function flights()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'id');
    }
}
