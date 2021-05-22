<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

        //if you get error; NameSeeder does not exist
        // run this
        //composer dump-autoload
        //php artisan optimize
        //php artisan db:seed
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TimeSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(LocationtypeSeeder::class);
        $this->call(MovingtypeSeeder::class);
        $this->call(MovingsizeSeeder::class);
        $this->call(MovernumberSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(SupplySeeder::class);
        $this->call(OfficesizeSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ConstantSeeder::class);
        $this->call(RateSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(ShipperSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(AboutSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CarrierFaqSeeder::class);
        $this->call(ShipperFaqSeeder::class);
        $this->call(TermsSeeder::class);
        $this->call(PrivacySeeder::class);
        $this->call(CarrierPageSeeder::class);
        $this->call(ShipperPageSeeder::class);
    }
}
