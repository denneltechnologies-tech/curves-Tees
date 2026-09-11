<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Primary boutique admin
        $admin = User::firstOrNew(['email' => 'admin@curvesandtees.com']);
        $admin->name = 'Curves & Tees Admin';
        $admin->phone = '0571038444';
        $admin->password = bcrypt(env('ADMIN_PASSWORD', 'password'));
        $admin->role = User::ROLE_SUPER_ADMIN;
        $admin->status = User::STATUS_ACTIVE;
        $admin->save();

        // 2. Owner / Super Admin (Dennis)
        $owner = User::firstOrNew(['email' => 'otooaggreydennis@gmail.com']);
        $owner->name = 'Dennis Aggrey Otoo';
        $owner->phone = '0571038444';
        $owner->password = bcrypt('Ghana2026!!!');
        $owner->role = User::ROLE_SUPER_ADMIN;
        $owner->status = User::STATUS_ACTIVE;
        $owner->save();

        // 3. Storekeeper (Inventory, Clothing Items, and Orders Management)
        $storekeeper = User::firstOrNew(['email' => 'storekeeper@curvesandtees.com']);
        $storekeeper->name = 'Curves & Tees Storekeeper';
        $storekeeper->phone = '0571038444';
        $storekeeper->password = bcrypt(env('STOREKEEPER_PASSWORD', 'storekeeper123'));
        $storekeeper->role = User::ROLE_STOREKEEPER;
        $storekeeper->status = User::STATUS_ACTIVE;
        $storekeeper->save();

        // 4. Legacy alias
        $legacy = User::firstOrNew(['email' => 'admin@streetman.com']);
        $legacy->name = 'Curves & Tees Admin';
        $legacy->phone = '0571038444';
        $legacy->password = bcrypt('password');
        $legacy->role = User::ROLE_SUPER_ADMIN;
        $legacy->status = User::STATUS_ACTIVE;
        $legacy->save();
    }
}
