<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        $roles = [
            ['name' => 'admin'],
            ['name' => 'customer'],
            ['name' => 'mover'],
            ['name' => 'support'],
        ];
        Role::insert($roles);
    }
}
