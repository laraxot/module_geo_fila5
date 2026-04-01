<?php

use Modules\Performance\Models\IndividualeRegionale;
use Modules\Ptv\Enums\WorkerType;

require __DIR__ . '/laravel/vendor/autoload.php';
$app = require_once __DIR__ . '/laravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Laravel Version: " . app()->version() . "\n";
    echo "Testing IndividualeRegionale casting...\n";
    $model = new IndividualeRegionale();
    
    $casts = $model->getCasts();
    echo "Cast for 'type': " . ($casts['type'] ?? 'NONE') . "\n";
    echo "enum_exists(WorkerType::class): " . (enum_exists(WorkerType::class) ? 'YES' : 'NO') . "\n";
    
    $model->type = 'regionale';
    
    echo "Accessing type attribute: ";
    $type = $model->type;
    var_dump($type);
    echo "Is Enum? " . ($type instanceof WorkerType ? 'YES' : 'NO') . "\n";
    
    echo "Calling attributesToArray()...\n";
    $array = $model->attributesToArray();
    print_r($array);
    
    echo "\nSuccess!\n";
} catch (\Throwable $e) {
    echo "\nCaught exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
