<?php
function runSQL($rsql) {

	$db['default']['hostname'] = "localhost"; //localhost
	$db['default']['username'] = 'root'; //root
	$db['default']['password'] = ""; //'
	$db['default']['database'] = "cevicheria"; //Eldulce
	
	$active_group = 'default';

	$base_url = "https://".$_SERVER['HTTP_HOST'];
	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

	$connect = mysqli_connect($db[$active_group]['hostname'],$db[$active_group]['username'],$db[$active_group]['password'],$db[$active_group]['database']) or die ("Error: could not connect to database");
	//$db = mysqli_select_db($db[$active_group]['database']);
	//mysql_query("set names 'utf8'");  
	$result = mysqli_query($connect,$rsql) or die ($rsql);
	// mysqli_close($connect);

	$rows = array();
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r;
	}	 
	// var_dump($rows);
	return json_encode($rows);
}

function runSQLReporte($rsql) {

	$db['default']['hostname'] = "localhost"; //localhost
	$db['default']['username'] = 'root'; //root
	$db['default']['password'] = ""; //'
	$db['default']['database'] = "cevicheria"; //Eldulce
	
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