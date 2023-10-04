<?php session_start();
require '../cnSql.php';
  class ReportesController extends cnSql
{

    function ReporteDiario($array){ 
        $sql = "select SUM(p.visa) AS VISA,SUM(p.yape) AS YAPE,SUM(p.efectivo) AS EFECTIVO,SUM(p.plin) AS PLIN ,p.fecha FROM pedido p WHERE p.estado=3 AND p.fecha BETWEEN '$array->inicio' and '$array->fin' GROUP BY p.fecha;" ;
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function ReporteDia($array){ 
        $sql = "select ".
        "p.mesa ,p.idpedido,p.fecha,p.mesa,p.descuento,p.total,p.total_pedidos,  p.yape,  p.plin,  p.efectivo,  p.visa,TIME_FORMAT(p.created_at , '%H:%i') AS hora".
        " FROM pedido p ". 
        "WHERE p.estado = 3 ".
        "and p.fecha = '$array->fecha' order by p.idpedido  desc";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }
    

    function SelectSql($sql){ 
        $this->getConexion();
        $rs_resultado= $this->cnx->prepare($sql);
        $rs_resultado->execute();
        $row_registro = $rs_resultado->fetchAll(PDO::FETCH_ASSOC); 
        return $row_registro;
    } 
}

$array=json_decode(json_encode($_REQUEST)); // get all parameter request 
$function=$_REQUEST['function'];
$ReportesController = new ReportesController();    

    switch ($function) {
        case "ReporteDiario":
            $ReportesController->ReporteDiario($array);
            break;  
        case "ReporteDia":
            $ReportesController->ReporteDia($array);
            break;   
        default:
            # code...
            break;
    }