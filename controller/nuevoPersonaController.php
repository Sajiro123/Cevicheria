<?php session_start();
require '../cnSql.php';
 
$array=json_decode(json_encode($_REQUEST)); // get all parameter request

$function=$array->function; 

switch ($function) {
	case "CargarPersona":
		CargarPersona($array);
		break; 
    case "AgregarPersona":
        AgregarPersona($array);
         break; 
    case "ActualizarPersona":
        ActualizarPersona($array);
             break; 
    case "EliminarPersona":
        EliminarPersona($array);
                break; 
	default:
		# code...
		break;
}

function CargarPersona($array){

	$sql="";
    $sql="select * FROM persona inner join usuario on persona.idpersona=usuario.idpersona WHERE persona.deleted IS null";
    if(isset($array->idpersona)){
        $sql.=" and persona.idpersona =".$array->idpersona;
    } 
    $resultado  = runSQL($sql);
    echo $resultado; 
}

 
 
function AgregarPersona($array){

    $array->fechanacimiento  =formatFecha( $array->fechanacimiento, 'yyyy-mm-dd');
    $array->fechaingreso =formatFecha( $array->fechaingreso, 'yyyy-mm-dd'); 
    
    $array->usuario=$array->numerodoc;

    $espacio = '';
    if(isset($array->apellidomat)) {                        
        $array->apellidomat = ucwords(mb_strtolower(trim($array->apellidomat)));
        $espacio = !empty($array->apellidomat) ? ' ' : '';
    }else{
        $array->apellidomat = '';
    } 
    $array->apellidopat= ucwords(mb_strtolower(trim($array->apellidopat))); 
    $array->nombres= ucwords(mb_strtolower(trim($array->nombres)));   

    $array->completo =$array->apellidopat . $espacio . $array->apellidomat . ', ' . $array->nombres ; 

    $array->numerocel=($array->numerocel=="" ? "null" :$array->numerocel);

	$sql="";
    $sql="CALL createPersonaUsuario('$array->apellidopat','$array->apellidomat','$array->nombres', $array->idtipodoc, $array->numerodoc,'$array->email', $array->numerocel,' $array->fechanacimiento',' $array->fechaingreso','$array->password', $array->idperfil,'$array->usuario','$array->completo','$array->idsede');";
    $resultado  = runSQL($sql);
    echo $resultado; 
}

function ActualizarPersona($array){

    $array->fechanacimiento  =formatFecha( $array->fechanacimiento, 'yyyy-mm-dd');
    $array->fechaingreso =formatFecha( $array->fechaingreso, 'yyyy-mm-dd'); 
    
    $array->usuario=$array->numerodoc;

    $espacio = '';
    if(isset($array->apellidomat)) {                        
        $array->apellidomat = ucwords(mb_strtolower(trim($array->apellidomat)));
        $espacio = !empty($array->apellidomat) ? ' ' : '';
    }else{
        $array->apellidomat = '';
    } 
    $array->apellidopat= ucwords(mb_strtolower(trim($array->apellidopat))); 
    $array->nombres= ucwords(mb_strtolower(trim($array->nombres)));   

    $array->completo =$array->apellidopat . $espacio . $array->apellidomat . ', ' . $array->nombres ; 

    $array->numerocel=($array->numerocel=="" ? "null" :$array->numerocel);

	$sql="";
    $sql="CALL createActualizarUsuario('$array->apellidopat','$array->apellidomat','$array->nombres', $array->idtipodoc, $array->numerodoc,'$array->email', $array->numerocel,' $array->fechanacimiento',' $array->fechaingreso','$array->password', $array->idperfil,'$array->usuario','$array->completo','$array->idsede');";
    $resultado  = runSQL($sql);
    echo $resultado; 
}


function EliminarPersona($array){ 

	$sql="";
    $sql="update persona set deleted=1 where idpersona='$array->idpersona'";
    $resultado  = runSQLReporte($sql);
    $sql="update usuario set deleted=1 where idpersona='$array->idpersona'";
    $resultado  = runSQLReporte($sql);
    echo $resultado; 
} 

 
// function InsertarProducto($total,$total_pedidos,$fecha){
//     $idcliente=$_SESSION['id_user'];
//     $fecha=formatFecha($fecha, 'yyyy-mm-dd');

//  	$sql=""; 
// 	$sql="insert into pedido
// 	(idcliente
// 	 ,fecha
// 	 ,total
// 	 ,total_pedidos ,
//      created_at
// 	)
// 	VALUES('$idcliente','$fecha','$total','$total_pedidos','$fecha');";
// 	// insertar producto;
//      runSQLReporte($sql);

// 	$sql=""; 
// 	$sql="select MAX(idpedido) idpedido FROM pedido;";
// 	// insertar producto;
//     $resultado  = runSQLReporte($sql); 
	
//      if (mysqli_num_rows($resultado)) {
//         echo '{"data":[';
//         $first = true;

//         while ($row=mysqli_fetch_array($resultado)) { 
//             $campo2=utf8_encode($row['idpedido']); 
            
//             //formando json
//             if ($first) {
//                 $first = false;
//             } else {
//                 echo ',';
//             }
//             echo json_encode(array('idpedido'=>$campo2));
//         }
//         echo ']}';
//     }
// }

// function InsertarProductoDetalle($detalle_total)
// {
//     foreach ($detalle_total as $row) {
//         $fecha=date('Y-m-d H:i:s');

//         $sql="";
//         $sql="insert INTO pedidodetalle
//     (idpedido
//      ,idcategoria
//      ,idproducto
//      ,cantidad
//      ,precioU
//      ,total
//      ,descripcion
//      ,created_at 
//     )
//     VALUES
//     ('$row[idpedidodetalle]',
//     '$row[categoria]',
//     '$row[producto]',
//     '$row[cantidad]',
//     '$row[precioU]',
//     '$row[total]',
//     '$row[descripcion]',
//     '$fecha');" ;
//         // var_dump($sql);
//         runSQLReporte($sql);
//     }
// };


// function ReportePedido($fechainicio,$fechafin){
//     $idcliente=$_SESSION['id_user'];

//     $sql="";
//     $sql="select distinct p.fecha,p.total,p.total_pedidos,pe.name,p.idpedido FROM pedido p INNER JOIN pedidodetalle pd ON p.idpedido=pd.idpedido INNER JOIN people pe ON p.idcliente=pe.ID  WHERE  fecha BETWEEN '$fechainicio'  and '$fechafin' ";
//     if($_SESSION['rol_user']!=0){
//         $sql.=" and idcliente='$idcliente'";
//     } 
//      $sql.=" order by p.idpedido desc";
     
//     // var_dump($sql);
//     $resultado  = runSQLReporte($sql);
//     $n=0;

//     if (mysqli_num_rows($resultado)) {
//         echo '{"data":[';
//         $first = true;

//         while ($row=mysqli_fetch_array($resultado)) {
//             //contador
//             $data_pedido=array(
//                 'name'=>$row['name'],
//                 'fecha'=>$row['fecha'],
//                 'total_pedidos'=>$row['total_pedidos'],
//                 'total'=>$row['total']);

//             $n++;
//             //$dato2=str_replace("*"," ",$id_claves[2]);
//             $campo1= $n;
//             $campo7=utf8_encode($row['idpedido']);
//             $campo2=utf8_encode($row['name']);
//             $campo3=utf8_encode($row['fecha']);
//             $campo4=utf8_encode($row['total_pedidos']);
//             $campo5=utf8_encode($row['total']);
//             $campo6='<a > <i class="glyphicon glyphicon-list-alt" data-toggle="modal" data-backdrop="false" data-target="#exampleModal" onclick=showDetalleProducto("'.utf8_encode($row['idpedido']).'","'.utf8_encode($row['name']).'") style="cursor:pointer;font-size: 18px" title="Editar"></i></a>';

            
//             //formando json
//             if ($first) {
//                 $first = false;
//             } else {
//                 echo ',';
//             }
//             echo json_encode(array($n,$campo7,$campo2,$campo3,$campo4,$campo5,$campo6));

//         }
//         echo ']}';
//     }else {
//         echo '{"data":[]}';
//      }
// }

// function ReportePedidoID($idpedido,$pdf,$cliente){

  


//     $sql="";
//     $sql="select pe.name, DATE_FORMAT(p3.fecha, '%d/%m/%Y') as fecha,p3.total_pedidos,p3.total as total_final , c.NAME AS categoria,p1.NAME AS producto,p.cantidad,p.descripcion,p.precioU,p.total FROM pedidodetalle p ".
//     "INNER JOIN categories c ON p.idcategoria=c.ID " .
//     "INNER JOIN products p1  ON p1.ID=p.idproducto ". 
//     "INNER JOIN pedido p3  ON p3.idpedido=p.idpedido ".
//     "INNER JOIN people pe ON p3.idcliente=pe.ID ". 
//     "WHERE p.idpedido='$idpedido'";
    
     
//     // var_dump($sql);
//     $resultado  = runSQLReporte($sql);
//     $n=0;
//     $datapedido='';
//     if($pdf==true){
//         $json_data=[];
//         if (mysqli_num_rows($resultado)) { 
//             while ($row=mysqli_fetch_array($resultado)) {
//                 array_push($json_data,array(
//                     'categoria'=>$row['categoria'],
//                     'producto'=>$row['producto'],
//                     'cantidad'=>$row['cantidad'],
//                     'descripcion'=>$row['descripcion'],
//                     'precioU'=>$row['precioU'],
//                     'total'=>$row['total']));

//                     $datapedido=array(
//                         'name'=>$row['name'],
//                         'fecha'=>$row['fecha'],
//                         'total_pedidos'=>$row['total_pedidos'],
//                         'total'=>$row['total_final']);
//             }
//         }

//         $pdf=new ReporteDetalle();
//         $data= $pdf->exportarDetalle($json_data,$cliente,$datapedido);
//         return $data;
//     }else{
//         if (mysqli_num_rows($resultado)) {
//             echo '{"data":[';
//             $first = true;
    
//             while ($row=mysqli_fetch_array($resultado)) {
//                 //contador
//                 $n++;
    
//                 //$dato2=str_replace("*"," ",$id_claves[2]);
//                 $campo1= $n;
//                 $campo2=utf8_encode($row['categoria']);
//                 $campo3=utf8_encode($row['producto']);
//                 $campo4=utf8_encode($row['cantidad']);
//                 $campo5=utf8_encode(utf8_decode($row['descripcion']));
//                 $campo6=utf8_encode($row['precioU']);
//                 $campo7=utf8_encode($row['total']);
    
                
     
                
//                 //formando json
//                 if ($first) {
//                     $first = false;
//                 } else {
//                     echo ',';
//                 }
//                 echo json_encode(array(
//                 'categoria'=>$campo2,
//                 'producto'=>$campo3,
//                 'cantidad'=>$campo4,
//                 'descripcion'=>$campo5,
//                 'precioU'=>$campo6,
//                 'total'=>$campo7));
//             }
//             echo ']}';
//         }else {
//             echo '{"data":[]}';
//          } 
//     }

    

// }

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
            $fecha = explode('/', $fecha);
            $newFecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
        }
    }
    
    return $newFecha;
}
?>


	 