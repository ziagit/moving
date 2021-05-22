<?php

use App\Shipper;
use Illuminate\Database\Seeder;

class ShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shipper::truncate();
        $shipper = [
            'first_name' => 'Ziak',
            'last_name' => 'KJiow',
            'address_id'=> 1,
            'contact_id' => 1,
            'user_id' => 2,
        ];
        Shipper::insert($shipper);
    }
}
