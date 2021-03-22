<?php

namespace Database\Seeders;

use App\Models\Ballot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BallotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ballots.json");
        $data = json_decode($json);
        foreach ($data as $record) {
            if (isset($record->icon)) {
                $ballot = [
                    'name' => $record->title,
                    'icon' => $record->icon,
                    'primary' => $record->primary
                ];
            } else {
                $ballot = [
                    'name' => $record->title,
                    'icon' => '',
                    'primary' => $record->primary
                ];
            }
            Ballot::create($ballot);
        }
    }
}
