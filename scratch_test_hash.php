<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
foreach ($users as $user) {
    echo "ID: " . $user->id . "\n";
    echo "Username: [" . $user->username . "]\n";
    echo "Email: [" . $user->email . "]\n";
    echo "Role: " . $user->role . "\n";
    $pass = 'Sipinter@2026';
    echo "Verify pass: " . (Illuminate\Support\Facades\Hash::check($pass, $user->password) ? "YES" : "NO") . "\n";
    echo "-------------------\n";
}
