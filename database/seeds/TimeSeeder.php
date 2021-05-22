<?php

use App\Time;
use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Time::truncate();
        $times = [
            [
                'from' => '8',
                'to' => '9',
                'date_id' => 1
            ],
            [
                'from' => '9',
                'to'=>'10',
                'date_id' => 1,
            ],
            [
                'from' => '10',
                'to'=>'11',
                'date_id' => 1,
            ],
            [
                'from' => '11',
                'to'=>'12',
                'date_id' => 1,
            ],
            [
                'from' => '12',
                'to'=>'13',
                'date_id' => 1,
            ],
            [
                'from' => '13',
                'to'=>'14',
                'date_id' => 1,
            ],
            [
                'from' => '14',
                'to'=>'15',
                'date_id' => 1,
            ],
            [
                'from' => '15',
                'to'=>'16',
                'date_id' => 1,
            ],
            [
                'from' => '16',
                'to'=>'17',
                'date_id' => 1,
            ]
        ];
        Time::insert($times);
    }
}
