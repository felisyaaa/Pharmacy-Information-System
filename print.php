<?php
require "FPDF/fpdf.php";
require "components/connect.php";

// Membuat kelas PDF dengan format A4 portrait
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(20, 20);
$pdf->AddPage();

// Judul halaman
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0, 10, 'DATA PRODUK', 0, 1, 'C');

// Header tabel
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(10, 10, 'NO', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama Produk', 1, 0, 'C');
$pdf->Cell(60, 10, 'Kategori', 1, 0, 'C');
$pdf->Cell(50, 10, 'Harga', 1, 1, 'C');

// Query untuk mengambil data produk
$select_products = $conn->prepare("SELECT * FROM `products`");
$select_products->execute();
$data = $select_products->fetchAll(PDO::FETCH_ASSOC);

// Menampilkan data produk dalam tabel
$pdf->SetFont('Times', '', 12);
$no = 1;
foreach ($data as $row) {
    // Menentukan posisi X untuk data produk
    

    $pdf->Cell(10, 10, $no, 1, 0, 'C');
    $pdf->Cell(50, 10, $row["name"], 1, 0, 'L');
    $pdf->Cell(60, 10, $row["category"], 1, 0, 'L');
    $pdf->Cell(50, 10, $row["price"], 1, 1, 'L');

    $no++;
}

$pdf->Ln();
$pdf->Cell(0, 5, 'Tanggal: ' . date('d-M-Y'), 0, 1);

$pdf->Output();
?>
