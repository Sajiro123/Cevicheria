<?php
require('../library/fpdf/fpdf.php');

// $function=$_REQUEST['formato'];
// echo $function;

class PDF extends FPDF
{
	public $pathFirma = 'C:\laragon\www\cevicheria\images\logo.png';
	// public $pathFirma = 'http://dulce.com.pe/taller2/subdominio/icon.png';
	
// Cargar los datos
 
 public $function = '';

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

	if($this->function !='GenerarTicketCocina'){

	
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
} 

// Tabla coloreada
function GenerarTicket(&$pdf,$data_)
{
	$fecha=date('d/m/Y H:i:s');
	$mesa='';
	$totalidad=0;
	$descuento=0;
	$idpedido='';

	foreach($data_ as $row){ 
 			$descuento=$row['descuento'];
			$mesa=(isset($row['mesa']) ? $row['mesa'] :'' ); 
			$totalidad+=intval($row['precioU']) * intval($row['cantidad']);
 			$idpedido=$row['idpedido'];
 	}
	
	// CABECERA
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(60,1,'CEVICHERIA WILLY GOURMET',0,1,'C');
	$pdf->SetFont('Helvetica','',8);
	$pdf->Cell(60,6,'Nota de Venta: 000-'.$idpedido,0,1,'C');
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

	$totalidad = $totalidad - intval($descuento);

	$pdf->Ln(6);

 	$pdf->SetFont('Helvetica','',9); 
	$pdf->Cell(60,0,'Sirvase pagar esta cantidad',0,1,'C');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',15);  
	$pdf->Cell(0, 3.5, '* * * * * * * * * * * * * * * * *', 0);

	 
	// PIE DE PAGINA
	$pdf->Ln(4);
	if($descuento != 0){
		$pdf->SetFont('Helvetica','',12);
		$pdf->Cell(60,0,'DESCUENTO: S/'.$descuento,0,1,'C');
		$pdf->Ln(4); 
		$pdf->Ln(2);  
	}
	$pdf->SetFont('Arial','B',15); 
	$pdf->Cell(60,0,'TOTAL: S/'.$totalidad,0,1,'C');
	$pdf->Ln(3); 
	$pdf->Ln(3); 
	
	$pdf->Output('ticket.pdf','i');
}

// Tabla coloreada
function GenerarTicketCocina(&$pdf,$data_)
{
	$pdf->function='GenerarTicketCocina';
	$fecha=date('d/m/Y H:i:s');
	$mesa='';
	$totalidad=0;
	$descuento=0;
	$idpedido='';
	$Hora='';
	

	foreach($data_ as $row){ 
 		if($row['mesa'] != null){
			$descuento=$row['descuento'];
			$mesa=$row['mesa']; 
			$totalidad+=intval($row['precioU']) * intval($row['cantidad']);
			$idpedido=$row['idpedido'];
			$Hora=$row['pedido_hora'];  
		} 
	}
	// CABECERA
	$pdf->SetFont('Helvetica','',10);
	$pdf->Cell(60,3,'CEVICHERIA WILLY GOURMET '.'00-'.$idpedido,0,1,'C');
	$pdf->Ln(3); 
	$pdf->SetFont('Helvetica', 'B', 14);  
	$pdf->Cell(60,4,'Mesa   : '.$mesa,0,1,'C'); 
	$pdf->Ln(3); 
	$pdf->Cell(60,4,'HORA   : '.$Hora,0,1,'C'); 
	// DATOS FACTURA   
 	$pdf->Ln(4);
	
	if($mesa !=''){

		$pdf->SetFont('Helvetica', '', 14); 
		$pdf->Ln(0.5); 
		$pdf->SetX(0);

		$pdf->Cell(0, 3, '- - - - - - - - - - - - - - - - - - - - - - - - - - ', 0);
		$pdf->Ln(0.7); 
 		$pdf->Ln(3.5);
	} 
	$pdf->Ln(6);

	foreach($data_ as $row){
		if($row['pedido_estado'] != 1){
			$pdf->SetX(1);
			// $pdf->SetY(3);

			$pdf->SetTextColor(0,0,0);  

			$pdf->SetFont('Arial', 'B', 14);
			$pdf->Cell(-1,-3,$row['cantidad'],0,0,'L'); 
 			$pdf->SetFont('Arial', 'B', 12);

			$pdf->Cell(50, -4, $row['acronimo'],0,0,'R');
			$pdf->SetFont('Arial', 'B', 13);  
			$pdf->Cell(15, -4,  $row['precioU'],0,0,'R');
			$pdf->SetTextColor(0,0,0);  
			$pdf->Cell(13, -4,  ($row['lugarpedido'] == 1 ? 'Mesa' : 'Llevar'),0,0,'R'); 
 			$pdf->Ln();
 
			if($row['opcionespedido']){ 
				$pdf->SetFont('Arial', '', 9); 
				$pdf->Cell(45, 11, '*** '. $row['opcionespedido'].'***',0,0,'C');
				$pdf->Ln();
				$pdf->Ln(3);
			}else{
				$pdf->Cell(0, 11,'',0,0,'C');
				$pdf->Ln();

			}
		}
	}
	
 
 

  
	$pdf->Output('ticket.pdf','i');
}

}
 
class reporteDetalle{
	function __construct()
	{
	}
	function imprimir ($data_){  

		$inicial=120;
		$items = count($data_);	

		if($items > 3){
			$inicial+=12;
		}
		if($items > 7){
			$inicial+=12;
		}
		if($items > 10){
			$inicial+=12;
		}
		if($items > 12){
			$inicial+=12;
		}
		if($items > 14){
			$inicial+=12;
		}
		$pdf = new PDF('P','mm',array(80,$inicial));  
		    // $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(15, 5, 15, 5));

		$pdf->SetDisplayMode("fullpage");
		$pdf->AddPage();  
		$pdf->GenerarTicket($pdf,$data_);
		$pdf->Output();

		return $pdf;
	}

	function imprimirCocina ($data_){  
		$inicial=110;
		$items = count($data_);	

		if($items > 5){
			$inicial+=20;
		}
		if($items > 7){
			$inicial+=12;
		}
		 
		
		$pdf = new PDF('P','mm',array(90,$inicial));  
		    // $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(15, 5, 15, 5));

		$pdf->SetDisplayMode("fullpage");
		$pdf->AddPage();  
		$pdf->GenerarTicketCocina($pdf,$data_);
		$pdf->Output();

		return $pdf;
	}	
}
