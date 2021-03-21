<?php

namespace Database\Seeders;

use App\Models\Perk;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perks = Perk::all();
        Room::factory(10)->create()->each(function (Room $room) use ($perks) {
            $room->perks()->attach(
                $perks->random(rand(2, 4))->pluck('id')->toArray()
            );
        });
    }
}
