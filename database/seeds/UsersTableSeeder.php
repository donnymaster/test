<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        App\User::create([
            'nick' => "Donny",
            'email' => $faker->email,
            'password' => Hash::make("sasha123"),
            'avatar' => 'storage/avatars/men.png',
            'email_verified_at' => now("Europe/Kiev")
        ]);

        App\User::create([
            'nick' => "Donny",
            'role_id' => 2,
            'email' => $faker->email,
            'password' => Hash::make("sasha123"),
            'avatar' => 'storage/avatars/girl.png',
            'email_verified_at' => now("Europe/Kiev")
        ]);
    }

}
