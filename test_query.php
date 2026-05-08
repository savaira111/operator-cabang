<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$q = App\Models\ZiMonitoring::whereNull('parent_id')->where('tahun', 2026);
echo 'ROOTS: ' . $q->count() . "\n";

$q2 = clone $q;
$q2->whereHas('children', function($q) {
    $q->whereHas('children', function($q2) {
        $q2->where('waktu_pelaksanaan', 'LIKE', '%BO3%');
    });
});
echo 'ROOTS WITH BO3: ' . $q2->count() . "\n";
