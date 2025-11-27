<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
$products = Product::all(['id', 'product_name', 'media', 'link']);
foreach ($products as $p) {
    echo $p->id . ' | ' . $p->product_name . ' | Media: ' . ($p->media ?? 'NULL') . ' | Link: ' . ($p->link ?? 'NULL') . "\n";
}
