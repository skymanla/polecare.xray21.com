<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$hospId = $_POST['hospId']; //required
$gatewayId = $_POST['gatewayId']; //required
$bandInfo = $_POST['bandInfo']; //array
$inMat = $_POST['inMat']; //array
$outMat = $_POST['outMat']; //array

echo "REQUEST MODE = ".$_SERVER['REQUEST_METHOD'];
echo '<br><br><br>';
if(empty($hospId) || empty($gatewayId)){	
	die("Required Params Empty!!!");	
}

// include_once($_SERVER['DOCUMENT_ROOT']."/lib/gatewayband_query.php");
if($hospId && $gatewayId){
	include_once($_SERVER['DOCUMENT_ROOT']."/lib/gatewayband_query.php");
}

$sql = "select * from tbl_gatewayband where 1 order by seq desc";
$query = $db->query($sql);

if($query->rowCount() == 0){
	echo "Data is empty";
}else{
	echo '<pre>';
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	print_r($result);
	echo '</pre>';
}

?>