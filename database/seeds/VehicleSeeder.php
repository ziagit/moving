<?php

use App\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::truncate();
        $vehicles =[
            [
            'name' => 'Mini van',
            'code' => 'minivan',
            'base_fare' => 30,
            'recommended' => 'Studio and a few items',
            ],
            [
            'name' => 'Cargo Van',
            'code' => 'cargovan',
            'base_fare' => 40,
            'recommended' => '1-2 Bedroom Apt, small office',
            ],
            [
            'name' => 'Box Truck',
            'code' => 'boxtruck',
            'base_fare' => 50,
            'recommended' => '3 Bedroom, medium office',
            ]
        ];
        Vehicle::insert($vehicles);
    }
}
