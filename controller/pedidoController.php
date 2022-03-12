<?php session_start();
require '../cnSql.php';
require '../subdominio/reporteDetalle.php';



class pedidoController extends cnSql
{
    
    function CargarDataCategoria(){ 
        $sql="select c.idcategoria,c.nombre,c.url_imagen from categoria c where c.deleted is  null";
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro);  
    }

    function CargarDataProducto(){ 
        $sql="select  * from producto p where p.deleted is null";
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro); 
    } 
    
    function ListarMesas(){
        $sql="select * from mesa c where c.deleted is  null";
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro); 
    } 

    function ListarPedidosMesa(){
         $sql="select p1.estadopedido,p2.acronimo, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p". 
        " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido".
        " INNER JOIN producto p2 ON p1.idproducto=p2.idproducto ".
        " INNER JOIN categoria c ON c.idcategoria=p1.idcategoria".
        " WHERE p.estado=1  AND p.deleted  IS null   ORDER BY p1.idpedido;"; 
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro); 
    } 

    function DeletePedidoMesa($mesa,$idpedido){
        $sql="update mesa set estado=0 where idmesa='$mesa';";
        runSQLReporte($sql); 

        $sql="update pedido set estado=2 where idpedido='$idpedido';";
        runSQLReporte($sql);
    }

    function CobrarPedido($mesa,$idpedido){
        $sql="update mesa set estado=0 where idmesa='$mesa';";
        runSQLReporte($sql); 

        $sql="update pedido set estado=3 where idpedido='$idpedido';";
        runSQLReporte($sql);
    }
 
    function ReporteProductoDetalle($idpedido){ 
        $sql="select p1.estadopedido, p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p". 
        " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido".
        " INNER JOIN producto p2 ON p1.idproducto=p2.idproducto ".
        " INNER JOIN categoria c ON c.idcategoria=p1.idcategoria".
        " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null   ORDER BY p.mesa;"; 
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro);
    }
 
    function InsertarProducto($total,$total_pedidos,$fecha,$mesa){
        $idcliente=$_SESSION['id_user'];
        $fecha_time=date('Y-m-d H:i:s');

        $sql="";
        $sql="update mesa set estado=1 where numero='$mesa';";
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
        ,estadopedido
        ,created_at 
        )
        VALUES
        ('$row[idpedido]',
        '$row[categoria]',
        '$row[producto]',
        '$row[cantidad]',
        '$row[precioU]',
        '$row[total]',
        '$row[estadopedido]',         
        '$fecha');" ;
            // var_dump($sql);
            runSQLReporte($sql);
        }
    } 

    function TicketPdf($idpedido){ 

        $sql="select p2.acronimo,p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p". 
        " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido".
        " INNER JOIN producto p2 ON p1.idproducto=p2.idproducto ".
        " INNER JOIN categoria c ON c.idcategoria=p1.idcategoria".
        " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null   ORDER BY p.mesa;"; 
        $data_json=$this->SelectSql($sql);  
        $pdf=new ReporteDetalle();
        $data= $pdf->Imprimir($data_json);
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

    function SelectSql($sql){ 
        $this->getConexion();
        $rs_resultado= $this->cnx->prepare($sql);
        $rs_resultado->execute();
        $row_registro = $rs_resultado->fetchAll(PDO::FETCH_ASSOC); 
        return $row_registro;
    }
}

    $function=$_REQUEST['function'];
    $categoria="";
    $cliente="";
    $data_cliente="";
    $pedidoclass = new pedidoController();
    

    switch ($function) {
        case "CargarDataCategoria":
            $pedidoclass->CargarDataCategoria();
            break;
        case "ListarPedidosMesa":
            $pedidoclass->ListarPedidosMesa();
            break; 
        case "CargarDataProducto":
            $pedidoclass->CargarDataProducto(); 
            break;  
        case "EditarProducto":
            $pedidoclass->EditarProducto($_REQUEST['idpedido'],$_REQUEST['total'],$_REQUEST['total_pedidos'],$_REQUEST['fechapedido'],$_REQUEST['mesa']); 
                break;   
        case "InsertarProducto":
            $pedidoclass->InsertarProducto($_REQUEST['total'],$_REQUEST['total_pedidos'],$_REQUEST['fechapedido'],$_REQUEST['mesa']); 
                break; 
        case "InsertarProductoDetalle":
            $pedidoclass->InsertarProductoDetalle($_REQUEST['detalle_total']); 
                break; 
        case "EditarProductoDetalle":
            $pedidoclass->InsertarProductoDetalle($_REQUEST['detalle_total']); 
                break; 
        case "ListarMesas":
            $pedidoclass->ListarMesas(); 
                break;    
        case "DeletePedidoMesa": 
            $pedidoclass->DeletePedidoMesa($_REQUEST['mesa'],$_REQUEST['idpedido']);
                    break;  
        case "CobrarPedido": 
            $pedidoclass->CobrarPedido($_REQUEST['mesa'],$_REQUEST['idpedido']);
                    break;
        case "ReporteProductoDetalle": 
            $pedidoclass->ReporteProductoDetalle($_REQUEST['idpedido']);
                    break;  
        case "TicketPdf": 
            $pedidoclass->TicketPdf($_REQUEST['idpedido']);
                    break;  
        default:
            # code...
            break;
    }


?>


	 