<?php

namespace App\Http\Controllers;

use App\Models\Ballot;
use Illuminate\Http\Request;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ballots = Ballot::all()->groupBy('primary');
        return [
            'primary' => $ballots[1],
            'sub' => $ballots[0]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function show(Ballot $ballot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ballot $ballot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ballot $ballot)
    {
        //
    }
}
