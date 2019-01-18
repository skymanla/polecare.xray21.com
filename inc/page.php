<?php
session_start();

$token = "test Device/No Push";
if($_SESSION['uuid']){
	$token = $_SESSION['uuid'];
}

$nurse_page = false;
if(preg_match("/nurse/i", $_SERVER['REQUEST_URI'])){
	$nurse_page = true;
}

$w_http_host = $_SERVER['HTTP_HOST'];
$w_request_uri = $_SERVER['REQUEST_URI'];
$w_file_name = basename($_SERVER['PHP_SELF']);
$w_sub_name = explode('/',$w_request_uri);
$w_index = true;

if(isset($w_sub_name[2])){
	$w_index = false;
	$w_b_num = explode('.',$w_file_name);
	$w_b_num = explode('s',$w_b_num[0]);
	$w_b_num = $w_b_num[1];

	switch($w_sub_name[2]){
		case "s1" : 
			$w_a_num = 1; 
			$w_s_title_1="현재위치";
			switch($w_b_num){
				case "1" : $w_s_title_2=""; break;
			}
		break;
		case "s2" : 
			$w_a_num = 2; 
			$w_s_title_1="환자관리";
			switch($w_b_num){
				case "1" : $w_s_title_2=""; break;
			}
		break;
		case "s3" : 
			$w_a_num = 3; 
			$w_s_title_1="이력관리";
			switch($w_b_num){
				case "1" : $w_s_title_2=""; break;
			}
		break;
		case "s4" : 
			$w_a_num = 4; 
			$w_s_title_1="마이페이지";
			switch($w_b_num){
				case "1" : $w_s_title_2=""; break;
			}
		break;
		case "s5" : 
			$w_a_num = 5; 
			$w_s_title_1="설정";
			switch($w_b_num){
				case "1" : $w_s_title_2=""; break;
			}
		break;
		case "member" : 
			$w_a_num = "no"; 
			switch($w_file_name){
				case "id_lost.php" : $w_s_title_1="아이디 찾기"; break;
				case "password_lost.php" : $w_s_title_1="패스워드 찾기"; break;
				case "register_form.php" : $w_s_title_1="회원가입"; break;
				case "register_result.php" : $w_s_title_1="회원가입 완료"; break;
			}
		break;
	}
}

if($w_a_num != "no" && $nurse_page == false){
	if(!$_SESSION['mb_id'] || !$_SESSION['mb_name']){
		echo '<meta http-equiv="refresh" content="0;url=/">';
		exit;
	}
}

?>