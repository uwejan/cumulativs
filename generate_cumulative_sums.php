<?php
// Create a 20x52 array of random values from a standard uniform distribution
$randomValues = [];
for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 52; $j++) {
        $randomValues[$i][$j] = rand() / getrandmax();
    }
}

// Calculate cumulative sums for each individual
$cumulativeSums = [];
for ($i = 0; $i < 20; $i++) {
    $sum = 0;
    for ($j = 0; $j < 52; $j++) {
        $sum += $randomValues[$i][$j];
        $cumulativeSums[$i][$j] = $sum;
    }
}

// Create a new Excel workbook using PHPSpreadsheet library
require 'vendor/autoload.php'; // Make sure to include the autoloader path

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fill the sheet with cumulative sum values
for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 52; $j++) {
        $sheet->setCellValueByColumnAndRow($j + 1, $i + 1, $cumulativeSums[$i][$j]);
    }
}

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('cumulative_sums.xlsx');
