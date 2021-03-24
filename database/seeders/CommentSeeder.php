<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all();
        $users = User::all();

        Comment::factory(20)->make()->each(function ($comment) use ($rooms, $users) {
            $comment->room_id = $rooms->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
