<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
// 초기 admin pass 설정
$common_sql = " seq=1,
				manage_id = :id, 
				manage_pwd = :pwd, 
				manage_name = :manage_name, 
				manage_hospid = :manage_hospid, 
				manage_auth = :manage_auth, 
				writeip = :writeip, 								
				regdate=now()";

$sql = "insert into tbl_management set ".$common_sql;

try{	
	$query = $db->prepare($sql);	
	$query->execute(array("id"=>$id,					
					"manage_name"=>"관리자",
					"manage_hospid"=>"super",
					"manage_auth"=>"super",
					"writeip"=>$_SERVER['REMOTE_ADDR'],				
					"pwd"=>base64_encode($pwd)
					));
}catch(Exception $e){
	// echo $sql;
	// echo "Error = ".$e->getMessage();
	throw $e;
}
?>