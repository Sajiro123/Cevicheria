<?php session_start();
require '../cnSql.php';
  class productoController extends cnSql
{

    function AgregarProducto($array){

        $array=$array->data;



        if($array->idarbol == true){$array->idarbol =2;}else{$array->idarbol =1;}  
        if( ! isset($array->idtipoproducto)) {$array->idtipoproducto = null;} 

        $target_dir = "C:/xampp/htdocs/cevicheria/images/platos_pedido/";
        // $file = $path['name'];
        //  $pathe = pathinfo($file);
        // $filename = $pathe['filename'];
        // $ext = $pathe['extension'];
        // $temp_name =$path['tmp_name'];
        // $path_filename_ext = $target_dir.$filename.".".$ext;
        
        // Check if file already exists
        // if (file_exists($path_filename_ext)) {
        // echo "Sorry, file already exists.";
        // }else{
        // move_uploaded_file($temp_name,$path_filename_ext);
        // echo "Congratulations! File Uploaded Successfully.";
        // } 
        
        $name = 'arroz.jpg';
    
        // $location = 'images/'.$name;
        // file_put_contents($path['tmp_name'], $location);


        $sql="insert into producto(idcategoria,nombre,codigo,idtipoproducto,idarbol,imagen,acronimo,preciounitario,id_created_at) VALUES($array->idcategoria,'$array->nombre','$array->codigo','$array->idtipoproducto',$array->idarbol,'$name','$array->acronimo',$array->preciounitario,2)" ;     
        $row_registro=$this->SelectSql($sql); 

        $sql_idproducto = "select max(idproducto)as idproducto FROM producto;";
        $row_registro = $this->SelectSql($sql_idproducto);

        if(isset($array->array_opciones)){
            foreach($array->array_opciones as $row_){
                $sql_row = "insert into opciones_producto (idproducto,nombre) value(".$row_registro[0]['idproducto'].",'$row_')";
                $this->SelectSql($sql_row);
            } 
        }


        return header("Location: http://localhost/cevicheria/?page=productos", TRUE, 301);  
    }


    function EditarProducto($array){
        $array=$array->data;

        // $row_registro="";
        // if($array->idproductoeditar){
        //     $sql="select * from producto where idproducto = '$array->idproductoeditar'" ;     
        //     $row_registro=$this->SelectSql($sql); 

        //     $sql="delete from producto where idproducto = '$array->idproductoeditar'" ;     
        //     $this->SelectSql($sql); 
        // }
            

        if($array->idarbol == true){$array->idarbol =2;}else{$array->idarbol =1;}  
        if( ! isset($array->idtipoproducto)) {$array->idtipoproducto = null;}  

        $name =$row_registro->imagen; 

        $sql="update producto set idcategoria=$array->idcategoria ,nombre='$array->nombre',codigo='$array->codigo',idtipoproducto='$array->idtipoproducto',idarbol=$array->idarbol,imagen='arroz.jpg',acronimo='$array->acronimo',preciounitario=$array->preciounitario where idproducto= $array->idproductoeditar" ;     
        $row_registro=$this->SelectSql($sql); 

        $sql_row = "delete from  opciones_producto WHERE idproducto=".$array->idproductoeditar;
        $this->SelectSql($sql_row);

        if(isset($array->array_opciones)){  
            foreach($array->array_opciones as $row_){
                $sql_row = "insert into opciones_producto (idproducto,nombre) value(".$array->idproductoeditar.",'$row_')";
                $this->SelectSql($sql_row);
            } 
        }

        return header("Location: http://localhost/cevicheria/?page=productos", TRUE, 301);  
    }

    function Eliminar_Producto($array){
        $sql = "update producto set deleted =1 where idproducto=$array->valor";
        $row_registro = $this->SelectSql($sql);
        echo json_encode($row_registro);
    }

    function Opciones_Producto()
    {
        $sql = "select * FROM opciones_producto;";
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
$productoController = new productoController();    

    switch ($function) {
        case "AgregarProductos":
            $productoController->AgregarProducto($array);
            break;   
        case "EditarProducto":
            $productoController->EditarProducto($array);
            break;   
        case "Eliminar_Producto":
            $productoController->Eliminar_Producto($array);
            break;   
            
        case "Opciones_Producto":
            $productoController->Opciones_Producto();
            break;   
        default:
            # code...
            break;
    }