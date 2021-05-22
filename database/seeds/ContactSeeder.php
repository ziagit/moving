<?php

use Illuminate\Database\Seeder;
use App\Contact;
class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::truncate();
        $contacts = [
            [
                'name'=> 'Zia',
                'phone' => '0775059616',
                'email'=> 'zia@shipbay.ca',
            ]
        ];
        Contact::insert($contacts);
    }
}
