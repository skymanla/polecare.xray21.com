<?php
/*
skymanla Ryan 20181130
manage user add process
*/
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");
session_start();

$name = $_REQUEST['name'];
$id = $_REQUEST['id'];
$pwd = $_REQUEST['pwd'];
$hp = $_REQUEST['hp'];
$status = $_REQUEST['status'];
$patient_seq = $_REQUEST['patient_seq'];
$patient_name = $_REQUEST['patient_name'];
$patient_birth = $_REQUEST['patient_birth'];

$tbl = "tbl_member";
$sql = "select count(*) as cnt from $tbl where str_id='".$id."'";
$q = $db->query($sql);
$m_v = $q->fetch();
if($m_v['cnt'] > 0){
	$r = ["code"=>"99", "msg"=>"이미 등록된 ID 입니다."];
	echo json_encode($r);
	exit;
}
// $arr = ["code"=>"test", "valud"=>phoneLength($hp)];
// echo json_encode($arr);
// exit;
$sql_common = " str_id='$id',
				str_pwd='".base64_encode($pwd)."',
				str_name='$name',
				str_hp='".$hp."',
				str_join_date=now(),
				str_patient_seq='$patient_seq',
				str_patient_name='$patient_name',
				str_patient_birth='$patient_birth',
				member_accept='$status'
			";

$sql = "insert into $tbl set ".$sql_common;

try{	
	$query = $db->prepare($sql);		
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"사용자가 등록되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}
	
exit;
?>