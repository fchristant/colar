<?php

$colar = require_once __DIR__.'/../colar/colar.return.php';

$array = [];
foreach ($colar as $name => $colors) {
    foreach ($colors as $key => $color) {
        $array[ucfirst($name)][$key] = $color;
    }
}

file_put_contents(__DIR__.'/colar.json', json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

echo "Done\n";
