<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Updating user roles...\n";

// Update or create admin user
$admin = User::where('email', 'admin@parkir.com')->first();
if ($admin) {
    $admin->update(['role' => 'admin']);
    echo "✅ Admin role updated successfully\n";
} else {
    User::create([
        'name' => 'Admin Parkir',
        'email' => 'admin@parkir.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    echo "✅ Admin user created successfully\n";
}

// Update or create petugas user
$petugas = User::where('email', 'petugas@parkir.com')->first();
if ($petugas) {
    $petugas->update(['role' => 'petugas']);
    echo "✅ Petugas role updated successfully\n";
} else {
    User::create([
        'name' => 'Petugas Parkir',
        'email' => 'petugas@parkir.com',
        'password' => Hash::make('password'),
        'role' => 'petugas',
        'email_verified_at' => now(),
    ]);
    echo "✅ Petugas user created successfully\n";
}

// Update any existing users without role
$usersWithoutRole = User::whereNull('role')->orWhere('role', '')->get();
foreach ($usersWithoutRole as $user) {
    $user->update(['role' => 'petugas']);
    echo "✅ Updated user {$user->email} with petugas role\n";
}

// Show all users
echo "\n📋 Current users:\n";
$users = User::all(['id', 'name', 'email', 'role']);
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

echo "\n🎉 User setup completed!\n";
