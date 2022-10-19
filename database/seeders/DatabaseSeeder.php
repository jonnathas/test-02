<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => env('FIRST_USER_NAME'),
            'email' => env('FIRST_USER_EMAIL'),
            'password' => bcrypt(env('FIRST_USER_PASSWORD')),
        ]);

        $this->call(ProductSeeder::class);
    }
}
