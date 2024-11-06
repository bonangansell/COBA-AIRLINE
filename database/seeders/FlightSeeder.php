<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("flights")->insert([
            'flight_code' => 'JT610',
            'origin' => 'SUB',
            'destination' => 'CGK',
            'departure_time' => '2024-10-15 08:00:00',
            'arrival_time' => '2024-10-15 10:00:00'
        ]);

        DB::table("flights")->insert([
            'flight_code' => 'MK510',
            'origin' => 'AUS',
            'destination' => 'GEM',
            'departure_time' => '2024-12-17 10:00:00',
            'arrival_time' => '2024-12-17 15:00:00'
        ]);

        DB::table("flights")->insert([
            'flight_code' => 'MY290',
            'origin' => 'JKT',
            'destination' => 'KLM',
            'departure_time' => '2024-09-11 11:00:00',
            'arrival_time' => '2024-09-11 12:00:00'
        ]);

        DB::table("flights")->insert([
            'flight_code' => 'KM210',
            'origin' => 'MAN',
            'destination' => 'ENG',
            'departure_time' => '2024-01-11 09:00:00',
            'arrival_time' => '2024-01-11 12:00:00'
        ]);

        DB::table("flights")->insert([
            'flight_code' => 'LM890',
            'origin' => 'UKA',
            'destination' => 'RUS',
            'departure_time' => '2024-09-11 11:00:00',
            'arrival_time' => '2024-09-11 12:00:00'
        ]);
    }
}
