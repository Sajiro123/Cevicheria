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
function FancyTable($header, $data,&$pdf,$cliente,$data_pedido)
{
	$x = $pdf->getX();
	$y = $pdf->getY();
	
	$pdf->SetFont('Times', 'I', 9);
	$pdf->Cell(348, 2, utf8_decode($cliente.'  '.$data_pedido['fecha']), 0, 0, 'C');
	$pdf->setX(49);

	$pdf->Image($pdf->pathFirma, 8, 2, 33, 0, 'PNG');
	$pdf->setX(49);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(115, 32, utf8_decode('Detalle Pedido'), 0, 0, 'C');
	$pdf->Ln();

	
 
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->SetTextColor(0, 93, 185);
	$pdf->setX($x + 6);
	$pdf->Cell(0.1, 8, utf8_decode(''), 'L,T,R,B', 0, 'L');
	$pdf->Cell(7, 8, utf8_decode('N°'), 'L,T,R,B', 0, 'C'); 
	$pdf->Cell(35, 8, utf8_decode('Categoria'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(40, 8, utf8_decode('Producto'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(10, 8, utf8_decode('Cant'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(60, 8, utf8_decode('Descripcion'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(15, 8, utf8_decode('PrecioU'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(15.8, 8, utf8_decode('SubTotal'), 'L,T,R,B', 0, 'C');
	$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);

	$i=0;
	$array_productos=[];
	foreach($data as $value){ 
		if(count($array_productos)==0){
			$array_pr=array("producto"=>$value['producto'],
			"categoria"=>$value['categoria'],
			"cantidad"=>1);
			array_push($array_productos,$array_pr);
		}else{ 
			$exist=array_filter($array_productos, function ($var,$key) use($value,&$array_productos) {
				if($var['producto'] == $value['producto']){
					$cantidad=$array_productos[$key]['cantidad'];
					$cantidad++;
					$array_productos[$key]['cantidad']=$cantidad; 
					return $var;
				}
			}, ARRAY_FILTER_USE_BOTH); 

			if(count($exist)==0){
				$array_pr=array("producto"=>$value['producto'],
				"categoria"=>$value['categoria'],
				"cantidad"=>1);
				array_push($array_productos,$array_pr);
			} 
		}
	

		$i++;
		$pdf->setX($x + 6.1);
		$pdf->SetFont('Arial', '', 6.5);
		$pdf->Cell(7, 8, utf8_decode($i), 'L,T,R,B', 0, 'C');
		$pdf->Cell(35.0, 8, utf8_decode(mb_strtoupper($value['categoria'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(40.0, 8, utf8_decode(mb_strtoupper($value['producto'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(10, 8, utf8_decode(mb_strtoupper($value['cantidad'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(60, 8, utf8_decode(mb_strtoupper($value['descripcion'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(15, 8,'S/'. utf8_decode(mb_strtoupper($value['precioU'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(15.8, 8,'S/'. utf8_decode(mb_strtoupper($value['total'])), 'L,T,R,B', 0, 'C'); 
		$pdf->Ln();
	}
	// $pdf->Ln();

	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(200, 60, utf8_decode(' '), 0, 0, 'C');
	$pdf->Ln();


	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(200, 20, utf8_decode('Resumen Pedido'), 0, 0, 'C');
	$pdf->Ln();
	
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->SetTextColor(0, 93, 185);
	$pdf->setX($x + 6);
	$pdf->Cell(0.1, 8, utf8_decode(''), 'L,T,R,B', 0, 'L');
	$pdf->Cell(7, 8, utf8_decode('N°'), 'L,T,R,B', 0, 'C'); 
	$pdf->Cell(50, 8, utf8_decode('Categoria'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(70, 8, utf8_decode('Producto'), 'L,T,R,B', 0, 'C');
	$pdf->Cell(25, 8, utf8_decode('Cant'), 'L,T,R,B', 0, 'C');
 	$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);

	$i=0;

	foreach($array_productos as $value){   
		$i++;
		$pdf->setX($x + 6.1);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(7, 8, utf8_decode($i), 'L,T,R,B', 0, 'C');
		$pdf->Cell(50, 8, utf8_decode(mb_strtoupper($value['categoria'])), 'L,T,R,B', 0, 'C');
		$pdf->Cell(70, 8, utf8_decode(mb_strtoupper($value['producto'])), 'L,T,R,B', 0, 'C'); 
		$pdf->Cell(25, 8,utf8_decode(mb_strtoupper($value['cantidad'])), 'L,T,R,B', 0, 'C'); 
		$pdf->Ln();
	}
 	$pdf->Ln();
}
}
 
class reporteDetalle{
	function __construct()
	{
	}
	function exportarDetalle ($data_,$cliente,$data_pedido){  
		$pdf = new PDF();
		// T�tulos de las columnas
		$header = array('Pa�s', 'Capital', 'Superficie (km2)', 'Pobl. (en miles)');
		// Carga de datos
		$data = $pdf->LoadData('paises.txt');
		$pdf->SetFont('Arial','',14);
		$pdf->AddPage(); 
		$pdf->FancyTable($header,$data_,$pdf,$cliente,$data_pedido);
		$pdf->Output();

		return $pdf;
	}	
}



?>
