<?php

use Illuminate\Database\Seeder;
use App\Carrier;
class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrier::truncate();
        $carriers =[
            [
                'first_name' => 'C1 First name',
                'last_name' => 'C1 Last name',
                'company' => 'Amu CLoud 1',
                'year_established' => 2018,
                'employees' => 20,
                'vehicles' => 10,
                'business_license' => "undefined",
                'insurance_papers' => "undefined",
                'logo' => 'undefined',
                'website' => 'actech.af',
                'detail' => 'Amu Cloud 1 offers all-inclusive services for relocations like packing, loading, moving, unloading, unpacking, arranging of items to be shifted from one place to another.',
                'address_id'=> 1,
                'contact_id' => 1,
                'user_id' => 3,
            ]
        ];
        
        Carrier::insert($carriers);
    }
}
