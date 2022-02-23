<?php session_start();
require '../cnSql.php';
require '../subdominio/reporteDetalle.php';

 
$function=$_REQUEST['function'];
$categoria="";
$cliente="";
$data_cliente="";
 
switch ($function) {
	case "CargarDataCategoria":
		CargarDataCategoria();
		break;
    case "ListarPedidosMesa":
		ListarPedidosMesa();
		break; 
	case "CargarDataProducto":
		CargarDataProducto(); 
		break;  
	case "EditarProducto":
		EditarProducto($_REQUEST['idpedido'],$_REQUEST['total'],$_REQUEST['total_pedidos'],$_REQUEST['fechapedido'],$_REQUEST['mesa']); 
			break;   
	case "InsertarProducto":
		InsertarProducto($_REQUEST['total'],$_REQUEST['total_pedidos'],$_REQUEST['fechapedido'],$_REQUEST['mesa']); 
			break; 
	case "InsertarProductoDetalle":
		InsertarProductoDetalle($_REQUEST['detalle_total']); 
			break; 
	case "EditarProductoDetalle":
		InsertarProductoDetalle($_REQUEST['detalle_total']); 
			break; 
    case "ListarMesas":
		ListarMesas(); 
			break;  
    case "ReportePedido":
        ReportePedido($_REQUEST['fechainicio'],$_REQUEST['fechafin']);
                break; 
    case "DeletePedidoMesa": 
        DeletePedidoMesa($_REQUEST['mesa'],$_REQUEST['idpedido']);
                break;  
    case "ReporteProductoDetalle": 
        ReporteProductoDetalle($_REQUEST['idpedido']);
                break;  
    case "TicketPdf": 
        TicketPdf($_REQUEST['idpedido']);
                break;  
	default:
		# code...
		break;
}

function CargarDataCategoria(){
	$sql="";
    $sql="select c.idcategoria,c.nombre,c.url_imagen from categoria c where c.deleted is  null";
    $resultado  = runSQL($sql);
    echo $resultado; 
}

function ListarMesas(){
	$sql="";
    $sql="select * from mesa c where c.deleted is  null";
    $resultado  = runSQL($sql);
    echo $resultado; 
} 

function ListarPedidosMesa(){
	$sql="";
    $sql="select  p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p". 
    " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido".
    " INNER JOIN producto p2 ON p1.idproducto=p2.idproducto ".
    " INNER JOIN categoria c ON c.idcategoria=p1.idcategoria".
    " WHERE p.estado=1  AND p.deleted  IS null   ORDER BY p.mesa;"; 
    $resultado  = runSQL($sql);
    echo $resultado; 
} 

function DeletePedidoMesa($mesa,$idpedido){
    $sql="";
    $sql="update mesa set estado=0 where idmesa='$mesa';";
    runSQLReporte($sql); 

    $sql="";
    $sql="update pedido set estado=2 where idpedido='$idpedido';";
    runSQLReporte($sql);
}

function CargarDataProducto(){ 
    $sql="";
    $sql="select  * FROM producto WHERE deleted is null";
    $resultado  = runSQL($sql);
    echo $resultado;  
}

function ReporteProductoDetalle($idpedido){ 
    $sql="";
    $sql="select p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p". 
    " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido".
    " INNER JOIN producto p2 ON p1.idproducto=p2.idproducto ".
    " INNER JOIN categoria c ON c.idcategoria=p1.idcategoria".
    " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null   ORDER BY p.mesa;"; 
    $resultado  = runSQL($sql);
    echo $resultado;  
}

 
function InsertarProducto($total,$total_pedidos,$fecha,$mesa){
    $idcliente=$_SESSION['id_user'];
    $fecha_time=date('Y-m-d H:i:s');

    $sql="";
    $sql="update mesa set estado=1 where idmesa='$mesa';";
    runSQLReporte($sql);

 	$sql=""; 
	$sql="insert into pedido
	(id_created_at
	 ,fecha
	 ,total
	 ,total_pedidos ,
     created_at,
     estado,
     mesa
	)
	VALUES('$idcliente','$fecha','$total','$total_pedidos','$fecha_time',1,'$mesa');";
	// insertar producto;
     runSQLReporte($sql);

	$sql=""; 
	$sql="select MAX(idpedido) idpedido FROM pedido;";
	// insertar producto;
    $resultado  = runSQLReporte($sql); 
	
     if (mysqli_num_rows($resultado)) {
        echo '{"data":[';
        $first = true;

        while ($row=mysqli_fetch_array($resultado)) { 
            $campo2=utf8_encode($row['idpedido']); 
            
            //formando json
            if ($first) {
                $first = false;
            } else {
                echo ',';
            }
            echo json_encode(array('idpedido'=>$campo2));
        }
        echo ']}';
    }
}

function EditarProducto($idpedido,$total,$total_pedidos,$fecha,$mesa){
     $fecha_time=date('Y-m-d H:i:s');
     $idcliente=$_SESSION['id_user'];

    $sql="";
    $sql="update pedido set total='$total',total_pedidos='$total_pedidos',updated_at='$fecha_time',id_updated_at='$idcliente' where idpedido='$idpedido';";
    runSQLReporte($sql);  

    $sql="";
    $sql="delete from pedidodetalle  where idpedido='$idpedido';";
    runSQLReporte($sql);  
}


function InsertarProductoDetalle($detalle_total)
{
    foreach ($detalle_total as $row) {
        $fecha=date('Y-m-d H:i:s');

        $sql="";
        $sql="insert INTO pedidodetalle
    (idpedido
     ,idcategoria
     ,idproducto
     ,cantidad
     ,precioU
     ,total
     ,descripcion
     ,created_at 
    )
    VALUES
    ('$row[idpedidodetalle]',
    '$row[categoria]',
    '$row[producto]',
    '$row[cantidad]',
    '$row[precioU]',
    '$row[total]',
    '$row[descripcion]',
    '$fecha');" ;
        // var_dump($sql);
        runSQLReporte($sql);
    }
};


function ReportePedido($fechainicio,$fechafin){
    $idcliente=$_SESSION['id_user'];

    $sql="";
    $sql="select distinct p.fecha,p.total,p.total_pedidos,pe.name,p.idpedido FROM pedido p INNER JOIN pedidodetalle pd ON p.idpedido=pd.idpedido INNER JOIN people pe ON p.idcliente=pe.ID  WHERE  fecha BETWEEN '$fechainicio'  and '$fechafin' ";
    if($_SESSION['rol_user']!=0){
        $sql.=" and idcliente='$idcliente'";
    } 
     $sql.=" order by p.idpedido desc";
     
    // var_dump($sql);
    $resultado  = runSQLReporte($sql);
    $n=0;

    if (mysqli_num_rows($resultado)) {
        echo '{"data":[';
        $first = true;

        while ($row=mysqli_fetch_array($resultado)) {
            //contador
            $data_pedido=array(
                'name'=>$row['name'],
                'fecha'=>$row['fecha'],
                'total_pedidos'=>$row['total_pedidos'],
                'total'=>$row['total']);

            $n++;
            //$dato2=str_replace("*"," ",$id_claves[2]);
            $campo1= $n;
            $campo7=utf8_encode($row['idpedido']);
            $campo2=utf8_encode($row['name']);
            $campo3=utf8_encode($row['fecha']);
            $campo4=utf8_encode($row['total_pedidos']);
            $campo5=utf8_encode($row['total']);
            $campo6='<a > <i class="glyphicon glyphicon-list-alt" data-toggle="modal" data-backdrop="false" data-target="#exampleModal" onclick=showDetalleProducto("'.utf8_encode($row['idpedido']).'","'.utf8_encode($row['name']).'") style="cursor:pointer;font-size: 18px" title="Editar"></i></a>';

            
            //formando json
            if ($first) {
                $first = false;
            } else {
                echo ',';
            }
            echo json_encode(array($n,$campo7,$campo2,$campo3,$campo4,$campo5,$campo6));

        }
        echo ']}';
    }else {
        echo '{"data":[]}';
     }
}

function TicketPdf(){ 
    
    $pdf=new ReporteDetalle();
    $data= $pdf->Imprimir($json_data,$cliente,$datapedido);
    return $data;
     
}

    

 

function formatFecha($fecha, $format = 'dd/mm/yyyy') {
    $newFecha = NULL;
    if (!empty($fecha) && strlen($fecha) == 10) {
        if ($format === 'dd/mm/yyyy') {
            //de: yyyy-mm-dd a: dd/mm/yyyy 
            $fecha = explode('-', $fecha);
            $newFecha = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
        }
        if ($format === 'yyyy-mm-dd') {
            //de: dd/mm/yyyy a: yyyy-mm-dd 
            $fecha = explode('-', $fecha);
            $newFecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
        }
    }
    
    return $newFecha;
}
?>


	 