<?php

namespace Database\Seeders;

use App\Models\Projects;
use App\Models\Tasks;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->has(
                Projects::factory(1)
                    ->has(Tasks::factory(5), 'tasks'),
                'projects'
            )
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('test1234')
            ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
