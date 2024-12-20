<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Faraimunashe',
            'email' => 'farai@gmail.com',
        ]);

        $user->addRole("admin");

        //$this->call(LaratrustSeeder::class);
    }
}
