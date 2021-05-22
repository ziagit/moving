<?php

use Illuminate\Database\Seeder;
use App\State;
class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
        $states = [
            [
                'name' => 'BC',
                'country_id' => 1
            ],
            [
                'name' => 'ON',
                'country_id' => 1
            ]
        ];
        State::insert($states);
    }
}
