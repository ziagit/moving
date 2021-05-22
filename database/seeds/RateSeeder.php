<?php

use App\Rate;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rate::truncate();
        $rates =  [
            [
              'price' => 90,
              'carrier_id'=>1
            ]
          ];
          Rate::insert($rates);
    }
}
