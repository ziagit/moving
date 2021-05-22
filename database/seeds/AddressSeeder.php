<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::truncate();
        $address =  [
            [
                'street' => "Rattles Road",
                'street_number' => "123",
                'zip' => 'A0A4G0',
                'city' => 'Vancouver',
                'state' => 'BC',
                'formatted_address'=>'formatted address',
                'country' => 'Canada',
            ]
        ];
        Address::insert($address);
    }
}
