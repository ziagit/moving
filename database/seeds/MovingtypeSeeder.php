<?php

use App\Movingtype;
use Illuminate\Database\Seeder;

class MovingtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movingtype::truncate();

        $types =  [
            [
              'title' => 'Apartment',
              'code' => 'apartment'
            ],
            [
              'title' => 'Office',
              'code' => 'office'
            ],
            [
              'title' => 'A few items',
              'code' => 'few_items'
            ],
            [
              'title' => 'Junk removal',
              'code' => 'junk_removal'
            ]
          ];

          Movingtype::insert($types);
    }
}
