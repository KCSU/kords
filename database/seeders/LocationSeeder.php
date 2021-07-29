<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/rooms.json");
        $data = collect(json_decode($json));
        Location::insert(
            $data->pluck('location')->unique()
            ->map(function ($location) {
                return ["name" => $location];
            })->toArray()
        );
    }
}
