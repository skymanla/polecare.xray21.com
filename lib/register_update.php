<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");
header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] != "POST"){
	header("HTTP/1.1 400 Bad Request");
	exit;
}

$name = $_POST['name'];
$id = $_POST['id'];
$name = $_POST['name'];
$pwd = (string) $_POST['pwd'];
$pwd_confirm = (string) $_POST['pwd_confirm'];
$phone = $_POST['phone1'].$_POST['phone2'].$_POST['phone3'];
$patient_name = $_POST['patient_name'];
$patient_birth = $_POST['patient_birth'];
$device_id = $_POST['device_id'];
if(!$device_id){
	$device_id = "test Device/No Push";
}

// id check
$sql = "select count(*) as cnt from tbl_member where str_id=?";
$query = $db->prepare($sql);
$id_chk = $query->execute([$id]);

$id_chk = $query->fetch();
if($id_chk['cnt'] == '1'){
	go_href("이미 가입된 아이디입니다.\\n로그인화면으로 이동합니다.", "/", "go");
	exit;
}

if($pwd != $pwd_confirm){
	go_href("입력된 패스워드가 서로 다릅니다.\\n로그인화면으로 이동합니다.", "/", "go");
	exit;
}

//phone check
$sql = " select count(*) as cnt from tbl_member where str_hp=?";
$query = $db->prepare($sql);
$hp_chk = $query->execute([$phone]);
$hp_chk = $query->fetch();
if($hp_chk['cnt'] == '1'){
	go_href("이미 가입된 핸드폰 번호입니다.\\n로그인화면으로 이동합니다.", "/", "go");
	exit;
}

$common_sql = " str_id = :id, 
				str_pwd = :pwd, 
				str_name = :username, 
				str_hp = :phone, 
				str_joinip = :joinip, 				
				str_device_id = :device_id, 
				str_join_date=now()";
/*
str_patient_name = :patient_name, 
str_patient_birth = :patient_birth,
*/

$sql = "insert into tbl_member set ".$common_sql;

try{	
	$query = $db->prepare($sql);	
	$query->execute(array("id"=>$id,					
					"username"=>$name,
					"phone"=>$phone,
					"joinip"=>$_SERVER['REMOTE_ADDR'],					
					"device_id"=>$device_id,
					"pwd"=>base64_encode($pwd)
					));
	/*
	"patient_name"=>$patient_name,
					"patient_birth"=>$patient_birth,
	*/
}catch(Exception $e){
	// echo $sql;
	// echo "Error = ".$e->getMessage();
	throw $e;
}


session_start();
$_SESSION['mb_id'] = $id;
$_SESSION['mb_name'] = $name;

go_href("", "/page/member/register_result.php", "nomsg");
?>