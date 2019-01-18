<?php
/*
skymanla Ryan 20181130
manage equiment process
*/
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();

$seq = $_REQUEST['seq'];
$type = $_REQUEST['type'];
$name = $_REQUEST['name'];
$mac = $_REQUEST['mac'];
$etc = $_REQUEST['etc'];
$status = $_REQUEST['status'];

$tbl = "tbl_equiment";
$sql = "select count(*) as cnt from $tbl where seq='".$seq."' and equiment_macadd='".$mac."'";
$q = $db->query($sql);
$m_v = $q->fetch();
if($m_v['cnt'] == 0){
	$r = ["code"=>"99", "msg"=>"존재하지 않는 장비입니다."];
	echo json_encode($r);
	exit;
}

$sql_common = " equiment_name='$name',
				equiment_type='$type',
				status='$status',
				equiment_etc='$etc'
				where seq=$seq and equiment_macadd='$mac'";

$sql = "update $tbl set ".$sql_common;

try{	
	$query = $db->prepare($sql);		
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"장비가 수정되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}
	
exit;
?>