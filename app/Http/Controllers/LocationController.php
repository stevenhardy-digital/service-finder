<?php

namespace App\Http\Controllers;

use App\Category;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('add-location');
    }

    public function getLocations() {
        $locations = Location::with('categories')->get();

        return response()->json(['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = $request->all();
        
        $imageName = uniqid().'.'.$location['logo']->getClientOriginalExtension();
        $location['logo']->move(public_path('images'), $imageName);

        $loc = Location::create([
            'name' => $location['name'],
            'location' => $location['location'],
            'opening_hours' => json_encode($location['opening_hours']),
            'logo' => '/images/' . $imageName,
            'longitude' => '1',
            'latitude' => '1'
        ]);

        $category = Category::firstOrCreate(['name' => $location['category']]);

        $loc->categories()->attach($category);

        return response()->json(['success' => 'You have added a location, thank you!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
