<?php

use App\Officesize;
use Illuminate\Database\Seeder;

class OfficesizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Officesize::truncate();

        $sizes =  [
            [
              'title' => 'Small Office',
              'employees'=>'Up to 100 SF',
              'code' => 'small',
              'hours_to_move'=>5
            ],
            [
              'title' => 'Midium Office',
              'employees'=>'1000 - 2000 SF',
              'code' => 'midium',
              'hours_to_move'=>8
            ],
            [
              'title' => 'Large Office',
              'employees' => '2000 - 3000 SF',
              'code' => 'large',
              'hours_to_move'=>10
            ]
          ];

          Officesize::insert($sizes);
    }
}
