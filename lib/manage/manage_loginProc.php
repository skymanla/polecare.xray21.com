<?php
/*
skymanla Ryan 20181130
manage login process
*/
header("Content-Type:application/json");

session_start();
session_destroy();
unset($_SESSION);

include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$id = $_REQUEST['id'];
$pwd = $_REQUEST['pwd'];

$tbl = "tbl_management";

$arr = ["id"=>$id, "pwd"=>$pwd];
$result = json_encode($arr);

$sql = "select * from $tbl where manage_id='".$id."' and delete_flag = 0";
$query = $db->query($sql);

if($query->rowCount() == false){
	$r = ["code"=>"99", "msg"=>"가입되지 않은 아이디입니다.", "url"=>""];
	echo json_encode($r);
	exit;
}

$r = $query->fetch();
if($r['manage_pwd'] != base64_encode($pwd)){
	$r = ["code"=>"99", "msg"=>"패스워드가 잘못되었습니다.", "url"=>""];
}else{
	$sql = "update $tbl set 
				login_cnt=login_cnt+1,
				login_ip='".$_SERVER['REMOTE_ADDR']."',
				login_date=now()
			where manage_id='".$id."'";
	$db->query($sql);
	//auth types
	$sql = "select auth_name, auth_types from tbl_management_auth where seq='".$r['manage_auth']."'";
	$auth_q = $db->query($sql);
	if($auth_q->rowCount() == "0"){
		$auth_name = "";
		$auth_types = "";
	}else{
		$auth_v = $auth_q->fetch();
		$auth_name = $auth_v['auth_name'];
		$auth_types = $auth_v['auth_types'];
	}
	
	session_start();
	$_SESSION['sAuth'] = $r['manage_auth'];
	$_SESSION['auth_name'] = $auth_name;
	$_SESSION['auth_types'] = $auth_types;
	$_SESSION['manage_id'] = $r['manage_id'];
	$_SESSION['manage_name'] = $r['manage_name'];
	$_SESSION['hospid'] = $r['manage_hospid'];
	$_SESSION['login_ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['login_cnt'] = $r['login_cnt']+1;
	$_SESSION['LoginAuth'] = true;


	$r = ["code"=>"98", "msg"=>"로그인이 되었습니다.", "url"=>"/adm/page/s2/s1.php"];
	// if($_SESSION['manage_id'] == "admin"){
	// 	$r = ["code"=>"98", "msg"=>"로그인이 되었습니다.", "url"=>"/adm/hospital_select.php"];
	// }else{
	// 	$r = ["code"=>"98", "msg"=>"로그인이 되었습니다.", "url"=>"/adm/page/s2/s1.php"];
	// }
	
}
echo json_encode($r);
exit;
?>