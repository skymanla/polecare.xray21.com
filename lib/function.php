<?php
/*
function
 */
//htmlCheck유무를 간단히 사용하기 위해서
function htmlCheck($data,$check)
{
	switch($check)
	{
		case "N" :
			$data = htmlspecialchars($data);
			$data = nl2br($data);
			break;
		default : 
			$data = $data;
			break;
	}
	return $data;
}
//message, url, alter 타입
function go_href($msg,$url,$ty) 
{
	switch($ty){
		case "go";
			 echo("<script language=\"javascript\"> 
			 <!--
			 alert('$msg');
			 location.href='$url';
			 //-->   
			 </script>");
			break;
		case "back";
			echo("<script language=\"javascript\"> 
			 <!--
			 alert('$msg');
			 history.back();
			 //-->   
			 </script>");
			break;
		case "op";
			echo("<script language=\"javascript\"> 
			 <!--
			 alert('$msg');
			 opener.location.href='$url';
			 self.close();
			 //-->   
			 </script>");
			break;
        case "top";
			echo("<script language=\"javascript\"> 
			 <!--
			 alert('$msg');
             top.location.href='$url';
			 //-->   
			 </script>");
			break;
		case "nomsg":
			echo("<script language=\"javascript\"> 
			 <!--
             location.href='$url';
			 //-->   
			 </script>");
			break;
	}
}

//임시 아이디 / 재귀함수로
function return_device_id($getId=''){
	global $db;
	$recuve_sql = '';
	/*if(empty($getId)){//값 생성
		$hash_key = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//암호화키
		$charactersLength = strlen($hash_key);
		$randomString = "";
		for($i=0;$i<10;$i++){
			$randomString .= $hash_key[rand(0, $charactersLength-1)];//랜덤 문자 생성
		}
		$recuve_sql = "booking_device_id='".$randomString."' ";
	}else{
		$getId_arr = explode($getId, "||");
		$Id_cnt = count($getId_arr);
		for($i=0;$i<$Id_cnt;$i++){
			if($i == $Id_cnt-1){
				$recuve_sql = " booking_device_id='".$getId_arr[$i]."' ";
			}else{
				$recuve_sql = " booking_device_id='".$getId_arr[$i]."' or ";
			}
		}
	}*/

	$hash_key = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//암호화키
	$charactersLength = strlen($hash_key);
	$randomString = "";
	for($i=0;$i<8;$i++){
		$randomString .= $hash_key[rand(0, $charactersLength-1)];//랜덤 문자 생성
	}
	$recuve_sql = "booking_device_id='".$randomString."' ";

	$sql = "select count(*) as cnt from tbl_device_booking where ".$recuve_sql;
	$query = $db->query($sql);
	$data = $query->fetch();
	if($data['cnt'] == '0'){
		return $randomString;
	}else{
		return return_device_id($randomString);
	}
}

//임시 패스워드 / 재귀함수로
function return_device_pwd($getPwd=''){
	global $db;
	$recuve_sql = '';
	/*if(empty($getId)){//값 생성
		$hash_key = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//암호화키
		$charactersLength = strlen($hash_key);
		$randomString = "";
		for($i=0;$i<10;$i++){
			$randomString .= $hash_key[rand(0, $charactersLength-1)];//랜덤 문자 생성
		}
		$recuve_sql = "booking_device_id='".$randomString."' ";
	}else{
		$getId_arr = explode($getId, "||");
		$Id_cnt = count($getId_arr);
		for($i=0;$i<$Id_cnt;$i++){
			if($i == $Id_cnt-1){
				$recuve_sql = " booking_device_id='".$getId_arr[$i]."' ";
			}else{
				$recuve_sql = " booking_device_id='".$getId_arr[$i]."' or ";
			}
		}
	}*/

	$hash_key = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//암호화키
	$charactersLength = strlen($hash_key);
	$randomString = "";
	for($i=0;$i<8;$i++){
		$randomString .= $hash_key[rand(0, $charactersLength-1)];//랜덤 문자 생성
	}
	$recuve_sql = "booking_device_pwd='".$randomString."' ";

	$sql = "select count(*) as cnt from tbl_device_booking where ".$recuve_sql;
	$query = $db->query($sql);
	$data = $query->fetch();
	if($data['cnt'] == '0'){
		return $randomString;
	}else{
		return return_device_pwd($randomString);
	}
}


//curl : post
function post_curl($postdata = array()){
	$postdata = json_encode($postdata);

	//return $postdata;
	$url = "localhost:8080/admin/api/schedule";
	$header_data = [];
	$header_data[] = "Content-Type: application/json";
	$header_data[] = "Accept-Encoding: gzip";
	$header_data[] = "Authorization: Basic YXBpLXVzZXI6YXBpLXBhc3N3b3Jk";
	$ch = curl_init(); //파라미터:url -선택사항
	    
	curl_setopt($ch, CURLOPT_URL,$url); //여기선 url을 변수로
	curl_setopt($ch, CURLOPT_USERPWD, "ubuntu:dkdlxldnlsj1!");
	//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt ($ch, CURLOPT_HEADER, trur); // 헤더 출력 여부
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_NOSIGNAL, true);
	curl_setopt($ch,CURLOPT_POST, 1); //Method를 POST로 지정.. 이 라인이 아예 없으면 GET
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	    
	$data = curl_exec($ch);
	$curl_errno = curl_errno($ch);
	$curl_error = curl_error($ch);
	    
	curl_close($ch);

	//$decoder = json_decode($data, true);

	return $data;
}

function randomString(){
	$hash_key = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//암호화키
	$charactersLength = strlen($hash_key);
	$randomString = "";
	for($i=0;$i<8;$i++){
		$randomString .= $hash_key[rand(0, $charactersLength-1)];//랜덤 문자 생성
	}

	return $randomString;
}

function phoneLength($phone){
	$phoneLength = strlen($phone);
	switch($phoneLength){
		case "10":
			if(substr($phone, 0, 2) == "02"){
				$phone1 = substr($phone, 0, 2);
				$phone2 = substr($phone, 2, 4);
				$phone3 = substr($phone, 6, 10);
			}else{
				$phone1 = substr($phone, 0, 3);
				$phone2 = substr($phone, 3, 3);
				$phone3 = substr($phone, 6, 10);
			}			
			break;
		case "11":
			$phone1 = substr($phone, 0, 3);
			$phone2 = substr($phone, 3, 4);
			$phone3 = substr($phone, 7, 4);
			break;
		default:
			$phone1 = substr($phone, 0, 4);
			$phone2 = substr($phone, 4, 4);
			$phone3 = substr($phone, 8, $phoneLength-1);
			break;
	}

	return $phone1."-".$phone2."-".$phone3;
}

function send_notification($tokens, $message){
	$url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
         'registration_ids' => $tokens,
         'data'             => $message
    );
 
    $headers = array(
        'Authorization:key = AAAA9cD1ctg:APA91bHL80Or2mbAqhE-X43TtO_LZAsAOPVthueBzX5Z1MkYYmpDgnTClEoto0ZeBfDt0_eKwXZ6kL4jQyoXRTsumXr9cZWhWap-D2NmbDLUSSIhWjRHmBIIqGBRgoyzXUTrE6X5gSi9 ',
        'Content-Type: application/json'
	);
	
	echo json_encode($fields);
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);          
    if ($result === FALSE) {
       die('Curl failed: ' . curl_error($ch));
    }
	curl_close($ch);
    return $result;
}
?>