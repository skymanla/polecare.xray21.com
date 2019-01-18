<?php
/*
skymanla Ryan 20181130
manage user add process
*/
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();

$name = $_REQUEST['name'];
$id = $_REQUEST['id'];
$pwd = $_REQUEST['pwd'];
$hp = $_REQUEST['hp'];
$patient_seq = $_REQUEST['patient_seq'];
$patient_name = $_REQUEST['patient_name'];
$patient_birth = $_REQUEST['patient_birth'];
$status = $_REQUEST['status'];

$tbl = "tbl_member";

$sql_pwd = "";
if(!empty($pwd)){
	$sql_pwd = "str_pwd='".base64_encode($pwd)."', ";
}

$sql_common = $sql_pwd." str_name='$name',
				str_hp='$hp',
				str_patient_seq='$patient_seq',
				str_patient_name='$patient_name',
				str_patient_birth='$patient_birth',
				member_accept='$status'
				where str_id='$id'
			";

$sql = "update $tbl set ".$sql_common;

try{	
	$query = $db->prepare($sql);
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"사용자가 수정되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}
	
exit;
?>