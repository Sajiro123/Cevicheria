<?php
require('../library/fpdf/fpdf.php');

// $function=$_REQUEST['formato'];
// echo $function;

class PDF extends FPDF
{
	//public $pathFirma = 'C:\xampp\htdocs\taller\subdominio\icon.png';
	public $pathFirma = 'http://dulce.com.pe/taller2/subdominio/icon.png';
	
// Cargar los datos
 
 
function LoadData($file)
{
	// Leer las l�neas del fichero
	$lines = file($file);
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
}

// Tabla coloreada
	function FancyTable()
	{
		// $x = $pdf->getX();
		// $y = $pdf->getY();
		
		// $pdf->SetFont('Times', 'I', 9);
		// $pdf->Cell(348, 2, utf8_decode('fecha'), 0, 0, 'C');
		// $pdf->setX(49);

		// $pdf->Image($pdf->pathFirma, 8, 2, 33, 0, 'PNG');
		// $pdf->setX(49);
		// $pdf->SetFont('Arial', 'B', 15);
		// $pdf->Cell(115, 32, utf8_decode('Detalle Pedido'), 0, 0, 'C');
		// $pdf->Ln();

		
	
		// $pdf->SetFont('Arial', 'B', 8);
		// $pdf->SetTextColor(0, 93, 185);
		// $pdf->setX($x + 6);
		// $pdf->Cell(0.1, 8, utf8_decode(''), 'L,T,R,B', 0, 'L');
		// $pdf->Cell(7, 8, utf8_decode('N°'), 'L,T,R,B', 0, 'C'); 
		// $pdf->Cell(35, 8, utf8_decode('Categoria'), 'L,T,R,B', 0, 'C');
		// $pdf->Cell(40, 8, utf8_decode('Producto'), 'L,T,R,B', 0, 'C');
		// $pdf->Cell(10, 8, utf8_decode('Cant'), 'L,T,R,B', 0, 'C');
		// $pdf->Cell(60, 8, utf8_decode('Descripcion'), 'L,T,R,B', 0, 'C');
		// $pdf->Cell(15, 8, utf8_decode('PrecioU'), 'L,T,R,B', 0, 'C');
		// $pdf->Cell(15.8, 8, utf8_decode('SubTotal'), 'L,T,R,B', 0, 'C');
		// $pdf->Ln();
		// $pdf->SetTextColor(0, 0, 0);

	
	}
}
 
class ImprimirTicket{
	function __construct()
	{
	}
	function Imprimir (){  
		$pdf = new PDF();
		// T�tulos de las columnas
		$header = array('Pa�s', 'Capital', 'Superficie (km2)', 'Pobl. (en miles)');
		// Carga de datos
		$data = $pdf->LoadData('paises.txt');
		$pdf->SetFont('Arial','',14);
		$pdf->AddPage(); 
		$pdf->FancyTable();
		$pdf->Output();

		return $pdf;
	}	
}



?>
