<?php

use App\Movernumber;
use Illuminate\Database\Seeder;

class MovernumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movernumber::truncate();

        $numbers =  [
            [
              'number' => "1 Mover + You",
              'recommended' => 'You need to sweat',
              'code'=>'1mover'
            ],
            [
              'number' => "2 Movers",
              'recommended' => 'Studio, 1-2 Bedroom, small office',
              'code'=>'2movers'
            ],
            [
              'number' => "3 Movers",
              'recommended' => '3 Bedroom, medium office',
              'code'=>'3movers'
            ]
          ];

          Movernumber::insert($numbers);
    }
}
