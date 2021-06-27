<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $today = date('d-m-y h:i:s');
        $users =  [
            [
                'name' => 'Admin',
                'email' => 'admin@tingsapp.com',
                'phone' => '+12501000000',
                'phone_verified_at' => $today,
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Support A',
                'email' => 'support@tingsapp.com',
                'phone' => '+12502000000',
                'phone_verified_at' => $today,
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Mover A',
                'email' => 'mover@gmail.com',
                'phone' => '+12504000000',
                'phone_verified_at' => $today,
                'password' => Hash::make('123')
            ],
            [
                'name' => 'Customer A',
                'email' => 'customer@gmail.com',
                'phone' => '+12503000000',
                'phone_verified_at' => $today,
                'password' => Hash::make('123')
            ]
           
        ];

        User::insert($users);

        $role = Role::find(1);
        $user = User::find(1);
        $user->roles()->attach($role);
        $user->markEmailAsVerified();

        $role = Role::find(2);
        $user = User::find(2);
        $user->roles()->attach($role);
        $user->markEmailAsVerified();

        $role = Role::find(3);
        $user = User::find(3);
        $user->roles()->attach($role);
        $user->markEmailAsVerified();

        $role = Role::find(4);
        $user = User::find(4);
        $user->roles()->attach($role);
        $user->markEmailAsVerified();

    }
}
