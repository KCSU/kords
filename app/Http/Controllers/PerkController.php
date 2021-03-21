<?php

namespace App\Http\Controllers;

use App\Models\Perk;
use App\Http\Resources\PerkResource;
use Illuminate\Http\Request;

class PerkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PerkResource::collection(Perk::all());
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
     * @param  \App\Models\Perk  $perk
     * @return \Illuminate\Http\Response
     */
    public function show(Perk $perk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perk  $perk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perk $perk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perk  $perk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perk $perk)
    {
        //
    }
}
