<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach ([
            'superadmin' => 'Superadmin GPA',
            'admin' => 'Administrator GPA',
            'editor' => 'Editor GPA',
        ] as $role => $name) {
            User::query()->updateOrCreate(
                ['email' => $role.'@gpa.local'],
                [
                    'name' => $name,
                    'password' => Hash::make($role),
                    'role' => $role,
                ],
            );
        }
    }
}
