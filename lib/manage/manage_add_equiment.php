<?php
/*
skymanla Ryan 20181130
manage equiment process
*/
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();

$type = $_REQUEST['type'];
$name = $_REQUEST['name'];
$mac = $_REQUEST['mac'];
$etc = $_REQUEST['etc'];
$status = $_REQUEST['status'];

$tbl = "tbl_equiment";
$sql = "select count(*) as cnt from $tbl where equiment_macadd='".$mac."'";
$q = $db->query($sql);
$m_v = $q->fetch();
if($m_v['cnt'] > 0){
	$r = ["code"=>"99", "msg"=>"이미 등록된 MAC 입니다."];
	echo json_encode($r);
	exit;
}

$sql = "select max(seq) as Maxseq from $tbl where 1 order by seq desc";
$q = $db->query($sql);
$s_v = $q->fetch();
if(!$s_v['Maxseq']){
	$seq = "1";
}else{
	$seq = $s_v['Maxseq'];
	$seq++;
}

$sql_common = " seq=$seq,
				equiment_macadd='$mac',
				equiment_name='$name',
				equiment_type='$type',
				status='$status',
				equiment_etc='$etc',
				regdate=now(),
				writer='".$_SESSION['manage_id']."',
				writerip='".$_SERVER['REMOTE_ADDR']."'";

$sql = "insert into $tbl set ".$sql_common;

try{	
	$query = $db->prepare($sql);		
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"장비가 등록되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}
	
exit;
?>