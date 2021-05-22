<?php

use App\Constant;
use Illuminate\Database\Seeder;

class ConstantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Constant::truncate();
        $locationtype =  [
            [
              'name' => 'Service charge',
              'code' => 'servicecharge',
              'value' => 10
            ],
            [
              'name' => 'Tax',
              'code' => 'tax',
              'value' => 5
            ],
            [
              'name' => 'Distance charge',
              'code' => 'distance',
              'value' => 1
            ],
            [
              'name' => 'Time one floor takes',
              'code' => 'floortime',
              'value' => 30
            ]
           
          ];
          Constant::insert($locationtype);
    }
}
