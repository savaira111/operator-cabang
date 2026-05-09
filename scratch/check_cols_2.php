<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
$hasIsPriority = Schema::hasColumn('analisis_risikos', 'is_priority');
$hasCabangId = Schema::hasColumn('analisis_risikos', 'cabang_id');
echo "is_priority: " . ($hasIsPriority ? 'YES' : 'NO') . "\n";
echo "cabang_id: " . ($hasCabangId ? 'YES' : 'NO') . "\n";
