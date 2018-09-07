<?php

namespace App\Http\Controllers;

use App\Entrant;
use App\Http\Resources\EntrantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EntrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|max:9|unique_with:entrants,event_id',
            'event_id' => 'required'
        ],[
            'phone.unique_with' => 'You are already registered to this event'
        ]);

        $entrant = Entrant::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'event_id' => $request->event_id
        ]);



        return new jsonResponse(['id' => $entrant->id],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
