<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Home delivery',
            'Click and Collect',
            'Take away',
            'Contact free',
            'Telephone Call'
        ];

        foreach($services as $service) {
            App\Service::create([
                'name' => $service
            ]);
        }
    }
}
