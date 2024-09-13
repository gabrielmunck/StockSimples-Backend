<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=inventory.xlsx");

require '../vendor/autoload.php';
include('../db/connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Price');
$sheet->setCellValue('D1', 'Quantity');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$row = 2;
while($product = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $product['id']);
    $sheet->setCellValue('B' . $row, $product['name']);
    $sheet->setCellValue('C' . $row, $product['price']);
    $sheet->setCellValue('D' . $row, $product['quantity']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$conn->close();
