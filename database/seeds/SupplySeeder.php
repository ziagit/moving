<?php

use App\Supply;
use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supply::truncate();
        $suplies =[
            [
            'name' => 'Small box',
            'code' => 'smallbox',
            'number' => 0,
            'price' => 3,
            ],
            [
            'name' => 'Medium box',
            'code' => 'mediumbox',
            'number' => 0,
            'price' => 5,
            ],
            [
            'name' => 'Large box',
            'code' => 'largebox',
            'number' => 0,
            'price' => 10,
            ],
            [
            'name' => 'Tape',
            'code' => 'tape',
            'number' => 0,
            'price' => 5,
            ],
            [
            'name' => 'Stretch wrap',
            'code' => 'stretchwrap',
            'number' => 0,
            'price' => 20,
            ]
        ];
        Supply::insert($suplies);
    }
}
