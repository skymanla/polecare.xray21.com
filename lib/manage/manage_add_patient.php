<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();
$arr = array();

$chartnum = $_REQUEST['chartnum'];
$age = $_REQUEST['age'];
$patient_name = $_REQUEST['patient_name'];
$sex = $_REQUEST['sex'];
$patient_bandtype = $_REQUEST['patient_bandtype'];
$status = $_REQUEST['status'];

$tbl = "tbl_patient";

$sql = " select count(*) as cnt from $tbl where chartnum='".$chartnum."'";
$c_q = $db->query($sql);
$c_v = $c_q->fetch();
if($c_v['cnt'] > 0){
	$arr = ["code"=>"99" , "msg"=>"이미 등록된 차트번호입니다."];
	echo json_encode($arr);
	exit;
}

$sql = "select max(seq) as maxSeq from $tbl where 1";
$q = $db->query($sql);
$s_v = $q->fetch();

if(!$s_v['maxSeq']){
	$seq = "1";
}else{
	$seq = $s_v['maxSeq'];
	$seq++;
}

$update = "update tbl_equiment set use_equiment='1' where seq='".$patient_bandtype."'";
$db->query($update);

$common_sql = "seq=$seq,
				chartnum='".$chartnum."',
				age='".$age."',
				patient_name='".$patient_name."',
				sex='".$sex."',
				patient_bandtype='".$patient_bandtype."',
				status='".$status."',
				writerip='".$_SERVER['REMOTE_ADDR']."',
				writername='".$_SESSION['manage_id']."',
				regdate=now()";
$sql = "insert into $tbl set ".$common_sql;
try{
	$query = $db->prepare($sql);
	$query->execute();
	$arr = ["code"=>"98", "msg"=>"환자가 등록되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}

exit;
?>