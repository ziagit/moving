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
        $today = date('d-m-y h:i:s');;
        $users =  [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '+93786431743',
                'phone_verified_at' => $today,
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Customer A',
                'email' => 'customer@gmail.com',
                'phone' => '+9398627640',
                'phone_verified_at' => $today,
                'password' => Hash::make('123')
            ],
            [
                'name' => 'Mover A',
                'email' => 'mover@gmail.com',
                'phone' => '+93775059616',
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

    }
}
