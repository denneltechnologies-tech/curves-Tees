<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => env('ADMIN_EMAIL', 'admin@curvesandtees.com')]);
        $admin->name = 'Curves & Tees Admin';
        $admin->phone = '0571038444';
        $admin->password = bcrypt(env('ADMIN_PASSWORD', 'password'));
        $admin->role = User::ROLE_SUPER_ADMIN;
        $admin->status = User::STATUS_ACTIVE;
        $admin->save();

        // Also ensure legacy admin@streetman.com works with name Curves & Tees Admin for convenience
        User::where('email', 'admin@streetman.com')->update([
            'name' => 'Curves & Tees Admin',
        ]);
    }
}
