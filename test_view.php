<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/zi-data-manage', 'GET', ['period' => 'BO3', 'tahun' => '2026']);
$controller = new App\Http\Controllers\ZiDataManageController();
$response = $controller->index($request);
$html = $response->render();

if (strpos($html, 'Terwujudnya pemerintahan digital') !== false) {
    echo "The text IS IN THE HTML!\n";
} else {
    echo "The text IS MISSING from HTML!\n";
}

file_put_contents('test_view.html', $html);
echo "HTML written to test_view.html\n";
