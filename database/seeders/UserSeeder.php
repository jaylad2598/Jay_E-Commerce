<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,50) as $index)
        {
            DB::table('users')->insert([
                'name' => $faker->name(8),
                'email' => $faker->email(15),
                'is_admin' => 0,
                'password' => bcrypt('12345678'),
                'status' => 'Active'
            ]);
        }
    }
}