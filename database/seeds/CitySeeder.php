<?php

use App\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        $cities = [
            [
                'name' => 'Vancouver',
                'state_id' => 1
            ],
            [
                'name' => 'Toronto',
                'state_id' => 2
            ]
        ];
        City::insert($cities);
    }
}
