<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/zi-data-manage', 'GET', ['period' => 'BO3', 'tahun' => '2026']);
$controller = new App\Http\Controllers\ZiDataManageController();
$response = $controller->index($request);
$data = $response->getData();
$monitorings = $data['monitorings'];

echo "Count from controller response: " . $monitorings->count() . "\n";
if ($monitorings->count() > 0) {
    $first = $monitorings->first();
    echo "First item SS2: " . $first->nomor . "\n";
    echo "First item children count: " . $first->children->count() . "\n";
} else {
    echo "WHY IS IT EMPTY??? Let's debug the DB state here.\n";
    echo "Total roots: " . App\Models\ZiMonitoring::whereNull('parent_id')->count() . "\n";
    echo "Total 2026 roots: " . App\Models\ZiMonitoring::whereNull('parent_id')->where('tahun', 2026)->count() . "\n";
}
