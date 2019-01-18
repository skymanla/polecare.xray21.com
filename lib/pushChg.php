<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();
$mb_id = $_REQUEST['id'];
$pushVal = $_REQUEST['pushVal'];

if($pushVal == "true"){
	$pushVal = "Y";
}else if($pushVal == "false"){
	$pushVal = "N";
}

$sql = " update tbl_member set str_push_noti='".$pushVal."', str_push_noti_chg_date=now() where str_id='".$mb_id."'";
if($db->query($sql)){
	$_SESSION['push'] = $pushVal;
}else{

}
exit;
?>