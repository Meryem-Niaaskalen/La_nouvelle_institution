<?php
chdir(__DIR__ . '/..');
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

try {
    $user = App\Models\User::find(1);
    if (!$user) {
        echo "User ID 1 not found\n";
        exit(1);
    }

    $roleModel = Spatie\Permission\Models\Role::where('name', 'super_admin')
        ->where('guard_name', 'api')
        ->first();

    if (!$roleModel) {
        // Create an API-guard super_admin role if not exists
        $roleModel = Spatie\Permission\Models\Role::create([
            'name' => 'super_admin',
            'guard_name' => 'api',
        ]);
        echo "Created api super_admin role\n";
    } else {
        echo "Found api super_admin role\n";
    }

    // Assign role to user (using api guard)
    $user->assignRole($roleModel);
    echo "Assigned role 'super_admin' (api) to user ID 1\n";

    // Clear permission cache
    try {
        app()['cache']->forget('spatie.permission.cache');
    } catch (\Throwable $e) {
        // ignore
    }

    exit(0);
} catch (\Throwable $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
