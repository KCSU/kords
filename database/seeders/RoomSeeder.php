<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Location;
use App\Models\Perk;
use App\Models\Ballot;
use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
        $bands = Band::all();
        $locations = Location::all();
        $ballots = Ballot::all();
        // Room::factory(50)->make()
        // ->each(function (Room $room) use ($bands, $locations, $ballots) {
        //     $room->location_id = $locations->random()->id;
        //     $room->ballot_id = $ballots->random()->id;
        //     $bands->random()->rooms()->save($room);
        // })
        // ->each(function (Room $room) use ($perks) {
        //     $room->perks()->attach(
        //         $perks->random(rand(2, 4))->pluck('id')->toArray()
        //     );
        // });
        $json = File::get("database/data/rooms.json");
        $data = collect(json_decode($json));
        $data->each(function ($room) use ($locations, $ballots, $bands, $perks) {
            $dbRoom = Room::create([
                "number" => $room->number,
                "location_id" => $locations->firstWhere('name', $room->location)->id,
                "band_id" => $bands->firstWhere('number', $room->band)->id,
                "ballot_id" => $ballots->firstWhere('name', 'Undergraduate')->id,
                "long_contract" => $room->long_contract,
                "floor" => $room->floor,
                "available" => true,
                "notes" => $room->notes
            ]);
            foreach($room->perks as $perk) {
                $dbRoom->perks()->attach($perks->firstWhere('name', $perk)->id);
            }
        });
    }
}
