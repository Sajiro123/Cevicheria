<?php
abstract class cnSql
{
    protected $manejador		=	"mysql";
    private static $servidor	=	"45.76.87.150";
    private static $usuario		=	"figa";
    private static $pass 		=	"Princesa14";
    protected $db_name			=	"bd_pruebas_";
    protected $cnx;
    protected function getConexion()
    {
        try {
            $params = array(PDO::ATTR_PERSISTENT=>true,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->cnx=new PDO('mysql:host=45.76.87.150;dbname='.'bd_pruebas_'.';charset=utf8', 'figa', 'Princesa14');
            return $this->cnx;
        } catch (PDOException $ex) {
            echo "Error en la conexión : ".$ex->getMessage();
        }
    }
	
}
// }
function runSQL($rsql) {

	// $db['default']['hostname'] = "localhost"; //localhost
	// $db['default']['username'] = 'root'; //root
	// $db['default']['password'] = ""; //'
	// $db['default']['database'] = "cevicheria"; //Eldulce
	
	
	$db['default']['hostname'] = "45.76.87.150"; //localhost
	$db['default']['username'] = 'figa'; //root
	$db['default']['password'] = "Princesa14"; //'
	$db['default']['database'] = "bd_pruebas_"; //Eldulce
	

	$active_group = 'default';

	$base_url = "https://".$_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

	$connect = mysqli_connect($db[$active_group]['hostname'],$db[$active_group]['username'],$db[$active_group]['password'],$db[$active_group]['database']) or die ("Error: could not connect to database");
	//$db = mysqli_select_db($db[$active_group]['database']);
	//mysql_query("set names 'utf8'");  
	$result = mysqli_query($connect,$rsql) or die ($rsql);
	mysqli_close($connect);

	$rows = array();
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r;
	}	 
	// var_dump($rows);
	return json_encode($rows);
}

function runSQLReporte($rsql) {

	// $db['default']['hostname'] = "localhost"; //localhost
	// $db['default']['username'] = 'root'; //root
	// $db['default']['password'] = ""; //'
	// $db['default']['database'] = "cevicheria"; //Eldulce
	
	$db['default']['hostname'] = "45.76.87.150"; //localhost
	$db['default']['username'] = 'figa'; //root
	$db['default']['password'] = "Princesa14"; //'
	$db['default']['database'] = "bd_pruebas_"; //Eldulce

	$active_group = 'default';

	$base_url = "https://".$_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

	$connect = mysqli_connect($db[$active_group]['hostname'],$db[$active_group]['username'],$db[$active_group]['password'],$db[$active_group]['database']) or die ("Error: could not connect to database");
	//$db = mysqli_select_db($db[$active_group]['database']);
	//mysql_query("set names 'utf8'");  
	$result = mysqli_query($connect,$rsql) or die ($rsql);
	return $result;
	mysqli_close($connect);

}
?>