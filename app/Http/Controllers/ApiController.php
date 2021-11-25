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
    /**
     * List all rent bands.
     */
    public function bands() {
        return Band::orderBy('number')->get();
    }

    /**
     * List all possible room perks.
     */
    public function perks() {
        return PerkResource::collection(Perk::all());
    }

    /**
     * List all rooms in alphabetical order.
     */
    public function rooms() {
        return RoomResource::collection(
            Room::with([
                'perks', 'band',
                'location', 'comments.user',
                'images'
            ])->orderBy('number')->get()
        );
    }

    /**
     * List all room ballots grouped by position on the navbar.
     */
    public function ballots() {
        $ballots = Ballot::all()->groupBy('primary');
        return [
            'primary' => $ballots[1],
            'sub' => $ballots[0]
        ];
    }

    /**
     * List all possible room locations.
     */
    public function locations() {
        return Location::all();
    }

    /**
     * Save a comment on a room.
     */
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

    /**
     * Save an image of a room.
     */
    public function storeImage(Request $request) {
        $request->validate([
            'image' => 'required|image|max:10000',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::find($request->room_id)->number;

        // TODO: Allow selecting 'banner image'

        // Resize the image using Intervention\Image and save as a jpeg
        $img = Img::make($request->file('image'))->heighten(350, function ($constraint) {
            $constraint->upsize();
        })->encode('jpg', 75);
        $path = 'images/' . $room . '/' . Str::random(40) . '.jpg';
        // TODO: Make this disk-agnostic (it can use any storage driver)
        Storage::disk('public')->put($path, $img);
        
        $image = new Image;
        $image->filename = Storage::url($path);
        $image->room_id = $request->room_id;
        $image->user_id = auth()->user()->id;
        $image->save();

        return $image;
    }
}
