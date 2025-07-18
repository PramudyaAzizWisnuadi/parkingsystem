<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "🔐 Testing Role Access...\n\n";

// Test admin user
$admin = User::where('email', 'admin@parkir.com')->first();
if ($admin) {
    echo "👑 Admin User Test:\n";
    echo "   Name: {$admin->name}\n";
    echo "   Email: {$admin->email}\n";
    echo "   Role: {$admin->role}\n";
    echo "   Can access parking? " . (in_array($admin->role, ['admin', 'petugas']) ? '✅ YES' : '❌ NO') . "\n\n";
}

// Test petugas user
$petugas = User::where('email', 'petugas@parkir.com')->first();
if ($petugas) {
    echo "👮 Petugas User Test:\n";
    echo "   Name: {$petugas->name}\n";
    echo "   Email: {$petugas->email}\n";
    echo "   Role: {$petugas->role}\n";
    echo "   Can access parking? " . (in_array($petugas->role, ['admin', 'petugas']) ? '✅ YES' : '❌ NO') . "\n\n";
}

// Test middleware logic
echo "🛠️ Middleware Logic Test:\n";
$testRoles = ['admin', 'petugas', 'user', null];
$allowedRoles = ['admin', 'petugas'];

foreach ($testRoles as $role) {
    $canAccess = in_array($role, $allowedRoles);
    $roleDisplay = $role ?? 'NULL';
    echo "   Role '{$roleDisplay}': " . ($canAccess ? '✅ ALLOWED' : '❌ DENIED') . "\n";
}

echo "\n✨ Test completed!\n";
