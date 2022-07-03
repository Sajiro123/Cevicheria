<?php session_start();
require '../cnSql.php';
  class productoController extends cnSql
{

    function AgregarProducto($array,$path){

        if($array->idarbol == true){$array->idarbol =2;}else{$array->idarbol =1;}  
        if( ! isset($array->idtipoproducto)) {$array->idtipoproducto = null;} 



        $target_dir = "C:/xampp/htdocs/cevicheria/images/platos_pedido/";
        $file = $path['name'];
        $pathe = pathinfo($file);
        $filename = $pathe['filename'];
        $ext = $pathe['extension'];
        $temp_name =$path['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
        }else{
        move_uploaded_file($temp_name,$path_filename_ext);
        echo "Congratulations! File Uploaded Successfully.";
        } 
        
        $name = $filename.".".$ext;
    
        $location = 'images/'.$name;
        file_put_contents($path['tmp_name'], $location);


        $sql="insert into producto(idcategoria,nombre,codigo,idtipoproducto,idarbol,imagen,acronimo,preciounitario) VALUES($array->idcategoria,'$array->nombre','$array->codigo','$array->idtipoproducto',$array->idarbol,'$name','$array->acronimo',$array->preciounitario)" ;     
        $row_registro=$this->SelectSql($sql); 
        return header("Location: http://192.168.1.12:8079/cevicheria/?page=productos", TRUE, 301);  
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
$productoController = new productoController();    

    switch ($function) {
        case "AgregarProductos":
            $productoController->AgregarProducto($array,$_FILES['imgproducto']);
            break;   
        default:
            # code...
            break;
    }