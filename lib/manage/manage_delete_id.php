<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$tbl = "tbl_management";
$arr = array();

$id = $_REQUEST['id'];

$sql = "select count(*) as cnt from $tbl where manage_id='".$id."' and delete_flag='0'";
$q = $db->query($sql);
$v = $q->fetch();

if($v['cnt'] != "1"){
	$arr = ["code"=>"99", "msg"=>"존재하지 않는 아이디입니다."]
	echo json_encode($arr);
	exit;
}

$common_sql = " delete_flag='1', delete_date=now() where manage_id='".$id."'";

$sql = "update $tbl set ".$common_sql;

try{	
	$query = $db->prepare($sql);
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"매니저 아이디가 삭제되었습니다."];
	echo json_encode($arr);
	exit;
}catch(Exception $e){
	// echo $sql;
	// echo "Error = ".$e->getMessage();
	throw $e;
}
?>