<?php
require('tfpdf/tfpdf.php');
require_once "tools.php";

$servername = "localhost";
$username = "root";
$password = null;
$database = "storage";
$mysqli = new mysqli($servername, $username, $password, $database);

class PDF extends tFPDF
{
   
    function Header()
    {
        // Logo
        $this->Image('tfpdf/icon.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Storage',1,0,'C');
        // Line break
        $this->Ln(20);
    }
    
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    

// Simple table
function BasicTable($header,$data)
{

    // Header
    foreach($header as $col)
        $this->Cell(60,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell(60,6,$row['name'],1);
        $this->Cell(60,6,$row['price'],1);
        $this->Cell(60,6,$row['quantity'],1);
        $this->Ln();
    }
}
}




$pdf = new PDF();
// Column headings
$header = array('Product', 'Price', 'Quantity');
// Data loading

$data = tools::getAll($mysqli);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->Output();