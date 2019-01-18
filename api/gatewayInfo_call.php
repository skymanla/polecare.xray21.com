<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$gatewaymac = $_POST['gatewaymac']; //required
$gatewayIP = $_POST['gatewayIP']; //required


if(empty($gatewaymac) || empty($gatewayIP)){	
	die("Required Params Empty!!!");	
}else{
	$sql = "select * from tbl_equiment where equiment_macadd='".$gatewaymac."'";
	$q = $db->query($sql);
	$gatewayInfo = $q->fetch();

	if(empty($gatewayInfo)){
		die("Not Data");
	}
	$sql = "insert into tbl_gatewayinfo_call_api set
				gateway_mac_add='".$gatewayInfo['equiment_macadd']."',
				gateway_etc='".$gatewayInfo['equiment_etc']."',
				gateway_ip='".$gatewayIP."',
				writerip='".$_SERVER['REMOTE_ADDR']."',
				regdate=now()";
	$db->query($sql);

	$return_val = "";

	switch($gatewayInfo['equiment_macadd']){
		case "b8:27:eb:c4:11:84":
			$return_val = "1";
			break;
		case "b8:27:eb:c9:69:8f":
			$return_val = "2";
			break;
		case "b8:27:eb:94:2d:8d":
			$return_val = "3";
			break;
		default:
			$return_val = "0";
			break;
	}
	
	die("1,".$return_val);	
}
?>