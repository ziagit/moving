<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        $countries = [
            [
                'name' => 'Canada',
                'code' => 'CA'
            ],
            [
                'name' => 'United state',
                'code' => 'US'
            ]
        ];
        Country::insert($countries);
    }
}
