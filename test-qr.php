<?php

require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$dir = 'public/uploads/qr_personel/';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$qr = QrCode::create('111')->setSize(200);

$result = (new PngWriter())->write($qr);

$result->saveToFile($dir . 'qr_111.png');

echo 'SELESAI';