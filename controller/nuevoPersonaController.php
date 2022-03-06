<?php session_start();
require '../cnSql.php';
  class nuevoPersonaController extends cnSql
{
   
     function CargarPersona($array){

        $sql="";
        $sql="select * FROM persona inner join usuario on persona.idpersona=usuario.idpersona WHERE persona.deleted IS null";
        if(isset($array->idpersona)){
            $sql.=" and persona.idpersona =".$array->idpersona;
        } 
        $row_registro=$this->SelectSql($sql); 
        echo json_encode($row_registro);  
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
    function SelectSql($sql){ 
        $this->getConexion();
        $rs_resultado= $this->cnx->prepare($sql);
        $rs_resultado->execute();
        $row_registro = $rs_resultado->fetchAll(PDO::FETCH_ASSOC); 
        return $row_registro;
    }
}
$array=json_decode(json_encode($_REQUEST)); // get all parameter request

$function=$array->function; 
$pedidoclass = new nuevoPersonaController();

switch ($function) {
	case "CargarPersona":
		$pedidoclass->CargarPersona($array);
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
?>


	 