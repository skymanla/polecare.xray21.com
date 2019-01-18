<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$tbl = "tbl_management";
$arr = array();

$id = $_REQUEST['id'];
$pwd = (string) $_REQUEST['pwd'];
$name = $_REQUEST['name'];
$auth_seq = $_REQUEST['auth_seq'];
$hospid = $_REQUEST['hospid'];

// pwd check
if(empty($pwd)){
	// origin pwd
	$sql = "select manage_pwd from $tbl where manage_id='".$id."'";
	$query = $db->query($sql);
	$pwd = $query->fetch();
	$ct_pwd = $pwd['manage_pwd'];
}else{
	if(strlen($pwd) < 4){
		$arr = ["code"=>"99", "msg"=>"비밀번호는 4자 이상으로 해주세요."];
		echo json_encode($arr);
		exit;	
	}
	$ct_pwd = base64_encode($pwd);
}


$common_sql = " manage_pwd = :pwd, 
				manage_name = :manage_name, 
				manage_hospid = :manage_hospid, 
				manage_auth = :manage_auth,
				writeip = :writeip, 								
				regdate=now()
				where manage_id='".$id."'
				";

$sql = "update $tbl set ".$common_sql;

try{	
	$query = $db->prepare($sql);	
	$query->execute(array("manage_name"=>$name,
					"manage_hospid"=>$hospid,
					"manage_auth"=>$auth_seq,
					"writeip"=>$_SERVER['REMOTE_ADDR'],				
					"pwd"=>$ct_pwd
					));
	$arr = ["code"=>"98", "msg"=>"매니저 아이디가 수정되었습니다."];
	echo json_encode($arr);
	exit;
}catch(Exception $e){
	// echo $sql;
	// echo "Error = ".$e->getMessage();
	throw $e;
}
?>