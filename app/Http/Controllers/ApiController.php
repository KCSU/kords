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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Img;

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
            'image' => 'required|image|max:10000',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::find($request->room_id)->number;

        // TODO: image deletion, select banner image, image detail view

        $img = Img::make($request->file('image'))->widen(500, function ($constraint) {
            $constraint->upsize();
        })->encode('jpg', 75);
        $path = 'images/' . $room . '/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($path, $img);
        
        $image = new Image;
        $image->filename = Storage::url($path);
        $image->room_id = $request->room_id;
        $image->save();

        return $image;
    }
}
