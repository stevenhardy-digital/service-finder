<?php

use App\Location;
use App\OpeningTimes;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        factory(Location::class, 10)->create()->each(function (Location $location) use ($days) {

            foreach ($days as $day) {
                factory(OpeningTimes::class)->create(['location_id' => $location->id, 'day' => $day]);
            }
        });
    }
}
