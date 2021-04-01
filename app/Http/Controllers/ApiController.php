<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerkResource;
use App\Http\Resources\RoomResource;
use App\Models\Ballot;
use App\Models\Band;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Location;
use App\Models\Perk;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function bands() {
        return Band::orderBy('number')->get();
    }

    public function perks() {
        return PerkResource::collection(Perk::all());
    }

    public function rooms() {
        return RoomResource::collection(
            Room::with([
                'perks', 'band',
                'location', 'comments.user',
                'images'
            ])->orderBy('number')->get()
        );
    }

    public function ballots() {
        $ballots = Ballot::all()->groupBy('primary');
        return [
            'primary' => $ballots[1],
            'sub' => $ballots[0]
        ];
    }

    public function locations() {
        return Location::all();
    }

    public function storeComment(Request $request) {
        $request->validate([
            'text' => 'required|string|between:5,1000',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $comment = Comment::create([
            'text' => $request->text,
            'room_id' => $request->room_id,
            'user_id' => auth()->user()->id
        ]);

        $comment->load('user');

        return response()->json($comment);
    }

    public function storeImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:1000',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $path = $request->file('image')->store('images', 'public');
        
        $image = new Image;
        $image->filename = Storage::url($path);
        $image->room_id = $request->room_id;
        $image->save();

        return $image;
    }
}
