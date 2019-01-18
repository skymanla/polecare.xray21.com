<?php
/*
skymanla Ryan 20181130
manage group auth process
*/
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();

$tbl = "tbl_management_auth";

$auth_name = (string) $_REQUEST['auth_name'];
$auth_type_arr = $_REQUEST['auth_type_arr'];

if(empty($auth_name)){
	$arr = ["code"=>"99", "msg"=>"아이디를 입력하지 않았습니다."];
	echo json_encode($arr);
	exit;
}

$sql = "select count(*) as cnt from $tbl where auth_name='".$auth_name."'";
$q = $db->query($sql);
$i_v = $q->fetch();
if($i_v['cnt'] > 0){
	$arr = ["code"=>"99", "msg"=>"이미 등록된 권한명입니다."];
	echo json_encode($arr);
	exit;
}

//seq
$sql = "select max(seq) as maxSeq from $tbl where 1";
$q = $db->query($sql);
$s_v = $q->fetch();

if(!$s_v['maxSeq']){
	$seq = "1";
}else{
	$seq = $s_v['maxSeq'];
	$seq++;
}

$auth_type = implode("||", $auth_type_arr);

// $common_sql = " seq=$seq,
// 				auth_name = :auth_name, 
// 				auth_types = :auth_type, 
// 				writeip = :writeip, 
// 				writername = :writername, 
// 				regdate = now()";

$common_sql = " seq=$seq,
				auth_name = '".$auth_name."', 
				auth_types = '".$auth_type."', 
				writeip = '".$_SERVER['REMOTE_ADDR']."', 
				writername = '".$_SESSION['manage_id']."', 
				regdate = now()";	

$sql = "insert into $tbl set ".$common_sql;

try{	
	$query = $db->prepare($sql);	
	// $query->execute(array("auth_name"=>$auth_name,			
	// 				"auth_types"=>$auth_type,
	// 				"writeip"=>$_SERVER['REMOTE_ADDR'],
	// 				"writername"=>$_SESSION['manage_id']
	// 				));
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"그룹 권한이 등록되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}
	
exit;
?>