<?php
/*
skymanla Ryan 20181130
manage add id check process
*/
header("Content-Type:application/json");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$id = $_REQUEST['id'];
$tbl = "tbl_management";

if(!preg_match("/[a-zA-Z]/", $id)){
	$arr = ["code"=>"99", "msg"=>"아이디는 영문만 가능합니다."];
	echo json_encode($arr);
	exit;
}

if(strlen($id) < 4){
	$arr = ["code"=>"99", "msg"=>"아이디는 4자 이상으로 해주세요."];
	echo json_encode($arr);
	exit;
}

$sql = " select count(*) as cnt from $tbl where manage_id='".$id."'";

$q = $db->query($sql);
$v = $q->fetch();
$arr = array();
if($v['cnt'] > 0){
	$arr = ["code"=>"99", "msg"=>"이미 등록된 아이디입니다."];
}else{
	$arr = ["code"=>"98", "msg"=>"사용 가능한 아이디입니다."];
}

echo json_encode($arr);
exit;
?>