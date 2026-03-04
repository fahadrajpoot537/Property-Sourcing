<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'webleads@propertysourcinggroup.co.uk')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'webleads@propertysourcinggroup.co.uk',
                'password' => bcrypt('password'),
            ]);
        }

        $this->call([
            PropertySeeder::class,
        ]);
    }
}
