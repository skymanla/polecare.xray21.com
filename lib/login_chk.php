<?php
// 로그인 시도 시점에서 세션을 뿌사분다.
session_start();

session_destroy();
unset($_SESSION);

include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$id = $_POST['id'];
$pwd = $_POST['pwd'];

//check id
$sql = " select count(*) as cnt from tbl_member where str_id='".$id."' ";
$query = $db->query($sql);
$chkId = $query->fetch();

if($chkId['cnt'] == false){
	go_href("아이디가 잘못되었습니다.", "/", "go");
	exit;
}

//check pwd
$sql = " select * from tbl_member where str_id='".$id."'";
$query = $db->query($sql);
$chkData = $query->fetch();

if($chkData['str_pwd'] != base64_encode($pwd)){
	go_href("패스워드가 잘못되었습니다.", "/", "go");
	exit;
}

$sql = " update tbl_member set 
			str_login_cnt=str_login_cnt+1,
			str_login_ip='".$_SERVER['REMOTE_ADDR']."',
			str_login_date=now()
		where str_id='".$id."'";
$db->query($sql);

//check data is complete!!!
session_start();
$_SESSION['mb_id'] = $chkData['str_id'];
$_SESSION['mb_name'] = $chkData['str_name'];
$_SESSION['mb_hp'] = $chkData['str_hp'];
// $_SESSION['patient_name'] = $chkData['str_patient_name'];
// $_SESSION['patient_birth'] = $chkData['str_patient_birth'];
$_SESSION['patient_seq'] = $chkData['str_patient_seq'];
$_SESSION['push'] = $chkData['str_push_noti'];

go_href("로그인이 되었습니다.", "/", "go");
?>