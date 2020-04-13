<?php

namespace App\Http\Controllers;

use App\Service;
use App\Category;
use App\Location;
use App\OpeningTimes;
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
        $locations = Location::with(['categories', 'services', 'opening_times'])->get();

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

        $loc = Location::create([
            'name' => $location['name'],
            'location' => $location['location'],
            'logo' => $location['logo'],
            'longitude' => $location['longitude'],
            'latitude' => $location['latitude'],
            'description' => $location['description'],
            'phone' => $location['phone'],
            'email' => $location['email']
        ]);

        $category = Category::firstOrCreate(['name' => $location['category']]);

        $loc->categories()->attach($category);

        $services = $location['services'];
        
        foreach($services as $service => $value) {
            $serv = Service::where('name', $service)->first();
            $loc->services()->attach($serv->id);
        }

        $days = $location['opening_times'];

        foreach($days as $day => $value) {
            $times = OpeningTimes::create([
                'location_id' => $loc->id,
                'day' => $value['day'],
                'open_time' => $value['open_time'],
                'close_time' => $value['close_time']
            ]);
        }

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
