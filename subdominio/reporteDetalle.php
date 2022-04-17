<?php
require('../library/fpdf/fpdf.php');

// $function=$_REQUEST['formato'];
// echo $function;

class PDF extends FPDF
{
	public $pathFirma = 'C:\xampp\htdocs\cevicheria\images\logo.png';
	// public $pathFirma = 'http://dulce.com.pe/taller2/subdominio/icon.png';
	
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


function Footer() 
{

	$this->SetY(-17);  
	$this->SetFont('Helvetica','',9);  
	$this->Cell(60,0,'Este Dcto no es un comprobante de pago',0,1,'C');
	$this->SetY(-13);   
	$this->Cell(60,0,'This document is not a payment slip',0,1,'C');

		$this->SetY(-11);  
		$this->Cell(60,5,'Gracias por su visita vuelva pronto',0,1,'C');

        // Posición: a 1,5 cm del final
        $this->SetY(-5); 

        // Arial italic 8
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(0, 0, 0);

        // Número de página
        $this->Cell(70, 5, utf8_decode('Cevicheria Willy Gourmet'), 0, 0, 'L');
        // $this->Cell(100, 5, utf8_decode('Fecha y hora de generación: ') . date('d/m/Y H:i:s'), 0, 0, 'L');
        $this->Cell(100, 5, '');
        $this->Cell(0, 5, utf8_decode('Página ').$this->PageNo(), 0, 0, 'R');

        // Linea
        $this->SetDrawColor(0,0,0);  
        $this->SetLineWidth(.5); 
        $this->Line(2, $this->GetY(), 208, $this->GetY()); 
} 

// Tabla coloreada
function GenerarTicket(&$pdf,$data_)
{
	$fecha=date('d/m/Y H:i:s');
	$mesa='';
	$totalidad='';
	$idpedido='';

	foreach($data_ as $row){
		if($row['mesa'] != null){
			$mesa=$row['mesa'];
			$totalidad=$row['totalidad'];
			$idpedido=$row['idpedido'];
		} 
	}
	// CABECERA
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(60,4,'CEVICHERIA WILLY GOURMET',0,1,'C');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(60,4,'Nota de Venta: 000-'.$idpedido,0,1,'C');
	$pdf->Cell(60,4,'RUC.: 01234567A',0,1,'C'); 
	$pdf->Image($pdf->pathFirma, 27, 30, 30, 0, 'PNG'); 
	$pdf->Cell(60,4,'Av.Victor Malazques Mr Lt10 Pachamac-Manchay',0,1,'C');
	$pdf->SetFont('Helvetica', '', 9); 
	$pdf->Cell(60,4,'TEL 928 314 085',0,1,'C');
 	


	
	// DATOS FACTURA   
	$pdf->Ln(8);
	$pdf->Ln(8);
	$pdf->Ln(5);
 	$pdf->Ln(5);
 
	$pdf->Ln(5);
 	$pdf->Cell(60,4,'Fecha     : '.$fecha,0,1,'');

	if($mesa !=''){
		$pdf->SetFont('Helvetica', '', 11); 
		$pdf->Cell(60,4,'Mesa   : '.$mesa,0,1,''); 
		$pdf->Ln(0.5); 
		$pdf->Cell(0, 3, '- - - - - - - - - - - - - - - - - - - - - - - - -', 0);
		$pdf->Ln(0.7); 
		$pdf->Cell(0, 3.5, '- - - - - - - - - - - - - - - - - - - - - - - - -', 0);
		$pdf->Ln(3.5);
	} 
  
	foreach($data_ as $row){
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->MultiCell(30,4,$row['cantidad'],0,'L'); 
		$pdf->Cell(45, -4, $row['acronimo'],0,0,'R');
		$pdf->Cell(15, -4,  number_format(round($row['total'],2), 2, ',', '24'),0,0,'R');
 		$pdf->Ln(0);

	}
	$pdf->Ln(6);

 	$pdf->SetFont('Helvetica','',9); 
	$pdf->Cell(60,0,'Sirvase pagar esta cantidad',0,1,'C');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',15);  
	$pdf->Cell(0, 3.5, '* * * * * * * * * * * * * * * * *', 0);

	 
	// PIE DE PAGINA
	$pdf->Ln(4);
	$pdf->Cell(60,0,'TOTAL: S/'.$totalidad,0,1,'C');
	$pdf->Ln(3); 
	$pdf->Ln(3); 
	$pdf->Output('ticket.pdf','i');
}

}
 
class reporteDetalle{
	function __construct()
	{
	}
	function imprimir ($data_){  
		$pdf = new PDF('P','mm',array(80,150));  
		$pdf->AddPage(); 
		$pdf->GenerarTicket($pdf,$data_);
		$pdf->Output();

		return $pdf;
	}	
}



?>
