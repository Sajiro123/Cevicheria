<?php

if(isset($_POST['user'])){
require "cnSql.php";
$user=$_POST['user'];
$pass=$_POST['pass'];
$rol=0;
$sql="select * from usuario WHERE usuario='$user' AND password='$pass'";
$query = runSQL($sql);
$query=json_decode($query);

foreach($query as $row){
	$res=1;
	session_start();
	$_SESSION['usuario'] = $row->usuario; 
	$_SESSION['id_user'] = $row->idusuario; 
 }  
}else{
	//$res="Acceso Prohibido";
	header ('location:login.php');
}

echo $res;
?>