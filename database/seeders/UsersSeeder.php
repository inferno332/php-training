<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@d-soft.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => User::ROLE_ADMIN,
        ]);

        // Create manager users
        for ($i = 0; $i < 3; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => 'manager' . ($i + 1) . '@d-soft.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'role' => User::ROLE_MANAGER,
            ]);
        }

        // Create regular users with more varied data
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password123'),
                'email_verified_at' => $faker->randomElement([
                    $faker->dateTimeBetween('-6 months', 'now'),
                    null
                ]),
                'role' => User::ROLE_USER,
            ]);
        }
    }
}
