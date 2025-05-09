<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
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
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $role = Role::query()->create([
            'name' => 'admin',
        ]);

        $user->roles()->sync([$role->id]);

        $this->call(MovieSeeder::class);
    }
}
