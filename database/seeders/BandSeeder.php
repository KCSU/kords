<?php

namespace Database\Seeders;

use App\Models\Band;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/bands.json");
        $data = json_decode($json);
        foreach ($data as $record) {
            Band::create([
                'number' => $record->number,
                'short_rent' => $record->short_rent,
                'long_rent' => $record->long_rent
            ]);
        }
    }
}
