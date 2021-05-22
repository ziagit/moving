<?php

use App\Movingsize;
use Illuminate\Database\Seeder;

class MovingsizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movingsize::truncate();

        $sizes =  [
            [
              'title' => 'Studio',
              'code' => 'studio',
              'hours_to_move'=>3,
              'recommended'=>'400-700 SF'
            ],
            [
              'title' => '1 Bedroom',
              'code' => '1bedroom',
              'hours_to_move'=>5,
              'recommended'=>'700-1000 SF'
            ],
            [
              'title' => '2 Bedrooms',
              'code' => '2bedrooms',
              'hours_to_move'=>7,
              'recommended'=>'1000-1500 SF'
            ],
            [
              'title' => '3 Bedrooms',
              'code' => '3bedrooms',
              'hours_to_move'=>8,
              'recommended'=>'1500-2000 SF'
            ],
            [
              'title' => '4 Bedrooms',
              'code' => '4bedrooms',
              'hours_to_move'=>5,
              'recommended'=>'2000 to 3000 SF'
            ]
          ];

          Movingsize::insert($sizes);
    }
}
