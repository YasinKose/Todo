<?php

namespace Database\Seeders;

use App\Models\Jobs;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        User::all()->each(function ($user) use ($faker) {
            foreach (range(1, rand(5, 40)) as $i) {
                $user->jobs()->save(
                    new Jobs([
                        'name' => $faker->sentence,
                        'deadline_at' => $faker->date()
                    ])
                );
            }
        });

        $count = User::count();

        Jobs::all()->each(function ($job) use ($count) {
            $job->users()->attach(User::find(rand(1,$count)));
        });
    }
}
