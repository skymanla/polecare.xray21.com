<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$bandInfomac = $_REQUEST['bandInfomac']; //required

if(empty($bandInfomac)){	
	die("Required Params Empty!!!");	
}else{	
	//등록(1), 수정(2), 삭제(3)
	echo "홍길동,010-1234-1234, 1";
}

?>