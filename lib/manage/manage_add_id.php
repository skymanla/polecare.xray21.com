<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$tbl = "tbl_management";
$arr = array();

$id = (string) $_REQUEST['id'];
$pwd = $_REQUEST['pwd'];
$name = $_REQUEST['name'];
$auth_seq = $_REQUEST['auth_seq'];
$hospid = $_REQUEST['hospid'];

if(empty($id)){
	$arr = ["code"=>"99", "msg"=>"아이디를 입력하지 않았습니다."];
	echo json_encode($arr);
	exit;
}

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

//check id
$sql = "select count(*) as cnt from $tbl where manage_id='".$id."'";

$q = $db->query($sql);
$i_v = $q->fetch();
if($i_v['cnt'] > 0){
	$arr = ["code"=>"99", "msg"=>"이미 등록된 아이디입니다."];
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
$common_sql = " seq=$seq,
				manage_id = :id, 
				manage_pwd = :pwd, 
				manage_name = :manage_name, 
				manage_hospid = :manage_hospid, 
				manage_auth = :manage_auth,
				writeip = :writeip, 								
				regdate=now()";

$sql = "insert into $tbl set ".$common_sql;

try{	
	$query = $db->prepare($sql);	
	$query->execute(array("id"=>$id,					
					"manage_name"=>$name,
					"manage_hospid"=>$hospid,
					"manage_auth"=>$auth_seq,
					"writeip"=>$_SERVER['REMOTE_ADDR'],				
					"pwd"=>base64_encode($pwd)
					));
	$arr = ["code"=>"98", "msg"=>"매니저 아이디가 등록되었습니다."];
	echo json_encode($arr);
	exit;
}catch(Exception $e){
	// echo $sql;
	// echo "Error = ".$e->getMessage();
	throw $e;
}
?>