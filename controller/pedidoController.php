<?php session_start();
require '../cnSql.php';
require '../subdominio/reporteDetalle.php';



class pedidoController extends cnSql
{

    function CargarDataCategoria()
    {
        $sql = "select c.idcategoria,c.nombre,c.url_imagen from categors c where c.deleted is  null  order by c.nombre desc ";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function CargarDataProducto()
    {
        $sql = "select  p.*,c.nombre as categoria from products p INNER JOIN categors c ON c.idcategoria=p.idcategoria where p.deleted is null order by nombre desc";

        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function ListarMesas()
    {
        $sql = "select * from mesa c where c.deleted is  null";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function ListarPedidosMesa()
    {
        $sql = "select    DATE_FORMAT(p.created_at,'%H:%i:%s') as pedido_hora,p.comentario,p.descuento, p2.idproducto,p1.lugarpedido,p2.acronimo, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad ,u.nombre usuario,p1.pedido_estado,p1.idpedidodetalle FROM pedido p" .
            " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido" .
            " INNER JOIN products p2 ON p1.idproducto=p2.idproducto " .
            " INNER JOIN categors c ON c.idcategoria=p1.idcategoria" .
            " INNER JOIN usuarios u ON p.id_created_at=u.idusuario" .

            " WHERE p.estado=1  AND p.deleted  IS null  AND p1.deleted  IS null ORDER BY p1.idpedido desc;";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function DeletePedidoMesa($mesa, $idpedido)
    {
        $sql = "update mesa set estado=0 where idmesa='$mesa';";
        runSQLReporte($sql);

        $sql = "update pedido set estado=2 where idpedido='$idpedido';";
        runSQLReporte($sql);
    }

    function CobrarPedido($mesa, $idpedido, $data)
    {
        $sql = "update mesa set estado=0 where idmesa='$mesa';";
        runSQLReporte($sql);

        $sql = "update pedido set estado=3,plin=$data[plin],efectivo=$data[efectivo],yape=$data[yape],visa=$data[visa] where idpedido='$idpedido';";
        runSQLReporte($sql);
    }

    function ReporteProductoDetalle($idpedido)
    {
        $sql = "select p1.opcionespedido, p1.pedido_estado, p.descuento,p.comentario, p1.lugarpedido, p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p" .
            " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido" .
            " INNER JOIN products p2 ON p1.idproducto=p2.idproducto " .
            " INNER JOIN categors c ON c.idcategoria=p1.idcategoria" .
            " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null  AND p1.deleted  IS null ORDER BY p.mesa;";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function InsertarProducto($total, $total_pedidos, $fecha, $mesa, $descuento, $comentario)
    {
        $idcliente = $_SESSION['id_user'];
        $fecha_time = date('Y-m-d H:i:s');

        if (isset($mesa)) {
            $sql = "update mesa set estado=1 where numero='$mesa';";
            runSQLReporte($sql);
        } else {
            $mesa = 0;
        }

        $sql = "insert into pedido
        (id_created_at
        ,fecha
        ,total_pedidos,
        created_at,
        estado,
        mesa,
        descuento,
        comentario
        )
        VALUES($idcliente,'$fecha',$total_pedidos,'$fecha_time',1,'$mesa',$descuento,'$comentario');";
        // insertar producto;

        runSQLReporte($sql);

        $sql = "select MAX(idpedido) idpedido FROM pedido;";
        // insertar producto;
        $resultado  = runSQLReporte($sql);

        if (mysqli_num_rows($resultado)) {
            echo '{"data":[';
            $first = true;

            while ($row = mysqli_fetch_array($resultado)) {
                $campo2 = utf8_encode($row['idpedido']);

                //formando json
                if ($first) {
                    $first = false;
                } else {
                    echo ',';
                }
                echo json_encode(array('idpedido' => $campo2));
            }
            echo ']}';
        }
    }

    function ActualizarEstado($value, $idpedidodetalle)
    {

        $sql = "update pedidodetalle set pedido_estado='$value'  where idpedidodetalle='$idpedidodetalle';";
        runSQLReporte($sql);
    }

    function BuscarPlatoSearch($value)
    {
        $sql = "select * FROM products p WHERE p.preciounitario IS NOT null";

        if ($value)
            $sql .= " and p.nombre LIKE '%$value%'";

        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }


    function EditarProducto($idpedido, $total, $total_pedidos, $fecha, $mesa, $descuento, $comentario)
    {
        $fecha_time = date('Y-m-d H:i:s');
        $idcliente = $_SESSION['id_user'];


        $sql = "update pedido set comentario='$comentario',total_pedidos='$total_pedidos',updated_at='$fecha_time',id_updated_at='$idcliente',descuento='$descuento' where idpedido='$idpedido';";
        runSQLReporte($sql);

        $sql = "update pedidodetalle set deleted = 1 where idpedido='$idpedido';";
        runSQLReporte($sql);
    }

    function InsertarProductoDetalle($detalle_total)
    {
        foreach ($detalle_total as $row) {
            $fecha = date('Y-m-d H:i:s');
            $row['pedido_estado'] = (isset($row['pedido_estado']) ? $row['pedido_estado'] : null);
            $var = ($row['opcionesarray'][0])['opciones'];
            $opciones= isset($var)? $var : null;

            $sql = "insert INTO pedidodetalle
        (idpedido
        ,idcategoria
        ,idproducto
        ,cantidad
        ,precioU
        ,total
        ,lugarpedido
        ,opcionespedido
        ,created_at 
        ,pedido_estado,
        id_created_at
        )
        VALUES
        ('$row[idpedido]',
        '$row[categoria]',
        '$row[producto]',
        '$row[cantidad]',
        '$row[precioU]',
         $row[total],
        '$row[lugarpedido]',   
        '$opciones',      
        '$fecha',
        '$row[pedido_estado]',
        2);";
            // var_dump($sql);
            runSQLReporte($sql);
        }
    }

    function TicketPdf($idpedido)
    {

        $sql = "select p.descuento,p.comentario, p2.acronimo,p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p" .
            " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido" .
            " INNER JOIN products p2 ON p1.idproducto=p2.idproducto " .
            " INNER JOIN categors c ON c.idcategoria=p1.idcategoria" .
            " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null  AND p1.deleted  IS null ORDER BY p.mesa;";
        $data_json = $this->SelectSql($sql);
        $pdf = new ReporteDetalle();
        $data = $pdf->Imprimir($data_json);
        return $data;
    }

    function TicketCocinaPdf($idpedido)
    {

        $sql = "select p1.opcionespedido, p1.pedido_estado,DATE_FORMAT(p.created_at,'%H:%i:%s') as pedido_hora, p1.lugarpedido, p.descuento,p.comentario, p2.acronimo,p1.idproducto,p2.idcategoria, p.idpedido, p1.cantidad,p2.nombre,p1.cantidad,p1.precioU,p1.total,p.mesa,c.nombre categoria,p.total totalidad FROM pedido p" .
            " INNER JOIN pedidodetalle p1 ON p.idpedido=p1.idpedido" .
            " INNER JOIN products p2 ON p1.idproducto=p2.idproducto " .
            " INNER JOIN categors c ON c.idcategoria=p1.idcategoria" .
            " WHERE p.estado=1 AND p.idpedido='$idpedido' AND p.deleted  IS null  AND p1.deleted  IS null ORDER BY p.mesa;";
        $data_json = $this->SelectSql($sql);
        $pdf = new ReporteDetalle();
        $data = $pdf->imprimirCocina($data_json);
        return $data;
    }

    function formatFecha($fecha, $format = 'dd/mm/yyyy')
    {
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

    function SelectSql($sql)
    {
        $this->getConexion();
        $rs_resultado = $this->cnx->prepare($sql);
        $rs_resultado->execute();
        $row_registro = $rs_resultado->fetchAll(PDO::FETCH_ASSOC);
        return $row_registro;
    }
}

$function = $_REQUEST['function'];
$categoria = "";
$cliente = "";
$data_cliente = "";
$pedidoclass = new pedidoController();
date_default_timezone_set("America/Lima");

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
        $pedidoclass->EditarProducto($_REQUEST['idpedido'], $_REQUEST['total'], $_REQUEST['total_pedidos'], $_REQUEST['fechapedido'], $_REQUEST['mesa'], $_REQUEST['descuento'], $_REQUEST['comentario']);
        break;
    case "InsertarProducto":
        $pedidoclass->InsertarProducto($_REQUEST['total'], $_REQUEST['total_pedidos'], $_REQUEST['fechapedido'], $_REQUEST['mesa'], $_REQUEST['descuento'], $_REQUEST['comentario']);
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
        $pedidoclass->DeletePedidoMesa($_REQUEST['mesa'], $_REQUEST['idpedido']);
        break;
    case "CobrarPedido":
        $pedidoclass->CobrarPedido($_REQUEST['mesa'], $_REQUEST['idpedido'], $_REQUEST['data']);
        break;
    case "ReporteProductoDetalle":
        $pedidoclass->ReporteProductoDetalle($_REQUEST['idpedido']);
        break;
    case "TicketPdf":
        $pedidoclass->TicketPdf($_REQUEST['idpedido']);
        break;
    case "TicketCocinaPdf":
        $pedidoclass->TicketCocinaPdf($_REQUEST['idpedido']);
        break;
    case "ActualizarEstado":
        $pedidoclass->ActualizarEstado($_REQUEST['value'], $_REQUEST['idpedidodetalle']);
        break;
    case "BuscarPlatoSearch":
        $pedidoclass->BuscarPlatoSearch($_REQUEST['plato']);
        break;
    default:
        # code...
        break;
}
