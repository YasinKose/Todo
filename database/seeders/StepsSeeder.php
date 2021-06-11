<?php

namespace Database\Seeders;

use App\Models\Jobs;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $userCount = User::count();
        Jobs::all()->each(function ($job) use ($faker, $userCount) {
            foreach (range(1, rand(5, 30)) as $i) {
                $job->steps()->create([
                    'name' => $faker->sentence,
                    'status' => rand(0, 1),
                    'user_id' => rand(0, $userCount)
                ]);
            }
        });
    }
}
