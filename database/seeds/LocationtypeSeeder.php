<?php

use Illuminate\Database\Seeder;
use App\Locationtype;
class LocationtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locationtype::truncate();

        $locationtype =  [
            [
              'title' => 'Apartment',
              'code' => 'apartment'
            ],
            [
              'title' => 'House',
              'code' => 'house'
            ],
            [
              'title' => 'Storage',
              'code' => 'storage'
            ]
          ];

          Locationtype::insert($locationtype);
    }
}
