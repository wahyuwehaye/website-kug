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
        $this->call(InitialContentSeeder::class);

        User::query()->updateOrCreate([
            'email' => 'admin@telkomuniversity.ac.id',
        ], [
            'name' => 'Administrator Direktorat Keuangan',
            'password' => bcrypt('Telkom#2025'),
        ]);
    }
}
