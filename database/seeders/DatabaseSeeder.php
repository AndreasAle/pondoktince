<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin — CHANGE THESE CREDENTIALS after first login.
        // NB: the User model casts `password` as `hashed`, so we pass the plain
        // string here and let the cast hash it exactly once (avoids double-hash).
        User::updateOrCreate(
            ['email' => 'admin@pondoktince.com'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
                'role' => User::ROLE_SUPER_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        $this->call(ContentSeeder::class);
    }
}
