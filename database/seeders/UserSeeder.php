<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
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
        $faker = Factory::create();
        $password = Hash::make('123456789Aa?');

        User::create([
            'name' => "Yasin Köse",
            'email' => "yasin@yasin.com",
            'password' => $password
        ]);


        for ($i = 0; $i < 10; ++$i) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
            ]);
        }

    }
}
