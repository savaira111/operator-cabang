<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$selectedPeriod = 'BO3';
$query = App\Models\ZiMonitoring::with([
        'cabang', 
        'children' => function($q) use ($selectedPeriod) {
            $q->whereHas('children', function($q2) use ($selectedPeriod) {
                $q2->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
            });
        },
        'children.children' => function($q) use ($selectedPeriod) {
            $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
        }
    ])
    ->whereNull('parent_id')
    ->where('tahun', 2026);

$query->where(function($q) use ($selectedPeriod) {
    $q->whereHas('children', function($q) use ($selectedPeriod) {
        $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%')
          ->orWhereHas('children', function($q) use ($selectedPeriod) {
              $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
          });
    });
});

$results = $query->get();
echo "Count: " . $results->count() . "\n";
if ($results->count() > 0) {
    $first = $results->first();
    echo "First Item children count: " . $first->children->count() . "\n";
    if ($first->children->count() > 0) {
        $firstChild = $first->children->first();
        echo "First Child's children count: " . $firstChild->children->count() . "\n";
    }
}
