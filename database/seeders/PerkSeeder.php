<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Perk;

class PerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/perks.json");
        $data = json_decode($json);
        foreach ($data as $record) {
            Perk::create([
                'name' => $record->name,
                'icon' => $record->icon
            ]);
        }
    }
}
