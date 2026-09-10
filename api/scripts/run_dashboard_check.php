<?php
// Script to bootstrap Laravel and call the admin dashboard route as user ID 1
chdir(__DIR__ . '/..');
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Make kernel and request
// Make the HTTP kernel to ensure service providers are registered.
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// Bootstrap the kernel to register service providers.
$kernel->bootstrap();

// Ensure a Request instance is bound so URL generator and routing providers can initialize.
try {
    $req = Illuminate\Http\Request::create('/');
    $app->instance('request', $req);
} catch (\Throwable $e) {
    // ignore
}

// Directly call the controller to avoid middleware/auth issues in CLI.
try {
    $controller = app()->make(App\Http\Controllers\DashboardController::class);
    $response = $controller->overview();
    if ($response instanceof Illuminate\Http\JsonResponse) {
        echo $response->getContent();
        exit(0);
    }
    echo json_encode(['error' => 'unexpected response type']);
} catch (\Throwable $e) {
    echo json_encode(['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    exit(1);
}
