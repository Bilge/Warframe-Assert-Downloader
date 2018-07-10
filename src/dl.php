<?php
declare(strict_types=1);

chdir(__DIR__);

$response = file_get_contents('http://content.warframe.com/MobileExport/Manifest/ExportManifest.json');
$json = json_decode($response, true);

foreach ($json['Manifest'] as $manifest) {
    $filename = '.' . str_replace('\\', '/', $manifest['textureLocation']);
    $dir = dirname($filename);

    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        throw new \RuntimeException("Failed to create directory: \"$dir\".");
    }

    // Skip files we already have.
    if (!is_file($filename)) {
        echo "Downloading $filename...\n";
        copy("http://content.warframe.com/MobileExport/$filename", $filename);
    }
}
