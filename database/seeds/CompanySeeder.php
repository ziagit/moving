<?php

use Illuminate\Database\Seeder;
use App\Company;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();
        $companies =[
            'name' => 'Amu cloud tech services',
            'logo' => 'nolog yet',
            'description' => 'It is a tech company',
            'service_charge' => 10,
            'tax' => 5
        ];
        Company::insert($companies);

    }
}
