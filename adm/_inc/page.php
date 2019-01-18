<?php 
session_start();
if($_SESSION['LoginAuth'] != true){
	echo '<meta http-equiv="refresh" content="0;url=/adm/login.php">';
	exit;
}

$super = false;
if($_SESSION['sAuth'] == "super"){
	$super = true;	
}
$w_http_host = $_SERVER['HTTP_HOST'];
$w_request_uri = $_SERVER['REQUEST_URI'];
$w_file_name = basename($_SERVER['PHP_SELF']);
$w_sub_name = explode('/',$w_request_uri);
$w_index = true;

if(isset($w_sub_name[3])){
	$w_index = false;
	$w_b_num = explode('.',$w_file_name);
	$w_b_num = explode('s',$w_b_num[0]);
	$w_b_num = $w_b_num[1];

	switch($w_sub_name[3]){
		case "s1" : 
			$w_a_num = 1; 
			$w_s_title_1="관리자회원관리";
			switch($w_b_num){
				case "1" : $w_s_title_2="관리자회원관리"; break;
			}
		break;
		case "s2" : 
			$w_a_num = 2; 
			$w_s_title_1="환자관리";
			switch($w_b_num){
				case "1" : $w_s_title_2="환자관리"; break;
			}
		break;
		case "s3" : 
			$w_a_num = 3; 
			$w_s_title_1="사용자관리(앱)";
			switch($w_b_num){
				case "1" : $w_s_title_2="사용자관리(앱)"; break;
			}
		break;
		case "s4" : 
			$w_a_num = 4; 
			$w_s_title_1="장비관리";
			switch($w_b_num){
				case "1" : $w_s_title_2="장비관리"; break;
			}
		break;
		case "s5" : 
			$w_a_num = 5; 
			$w_s_title_1="출입제한 이력관리";
			switch($w_b_num){
				case "1" : $w_s_title_2="출입제한 이력관리"; break;
			}
		break;
	}
	if($w_a_num){
		$w_a_num = $w_a_num-1;
	}
	$w_b_num = $w_b_num-1;

	//page 접근권한 분기 처리 skymanla
	if($super == true){
		//all pass
	}else{		
		if($w_a_num != "1"){
			$auth_types = explode("||", $_SESSION['auth_types']);
			if(in_array($w_a_num+1, $auth_types)){
				//pass
			}else{
				header('Content-Script-Type: text/javascript');			
				echo "<script>alert('접근권한이 없습니다.\\n관리자에게 문의하시기 바랍니다.');history.back(-1);</script>";
				exit;
			}		
		}else{
			// 환자관리는 그냥 패스
		}
	}
}
?>