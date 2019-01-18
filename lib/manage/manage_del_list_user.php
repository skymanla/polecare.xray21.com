<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$tbl = "tbl_".$_REQUEST['type'];
$arr = array();

$seq = $_REQUEST['seq'];


for($i=0; $i<count($seq); $i++){
	$common_sql = " delete_flag='1', delete_date=now() where str_idx='".$seq[$i]."'";
	$sql = "update $tbl set ".$common_sql;
	$db->query($sql);
}

$arr = ["code"=>"98", "msg"=>"삭제(중지)되었습니다."];
echo json_encode($arr);
exit;
?>