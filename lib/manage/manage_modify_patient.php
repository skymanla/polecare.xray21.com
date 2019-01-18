<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();
$arr = array();

$seq = $_REQUEST['seq'];
$chartnum = $_REQUEST['chartnum'];
$age = $_REQUEST['age'];
$patient_name = $_REQUEST['patient_name'];
$sex = $_REQUEST['sex'];
$patient_bandtype = $_REQUEST['patient_bandtype'];
$status = $_REQUEST['status'];

$tbl = "tbl_patient";

$sql = "select chartnum from $tbl where seq='".$seq."'";
$o_q = $db->query($sql);
$o_v = $o_q->fetch();

if($o_v['chartnum'] != $chartnum){
	$sql = " select count(*) as cnt from $tbl where chartnum='".$chartnum."'";
	$c_q = $db->query($sql);
	$c_v = $c_q->fetch();
	if($c_v['cnt'] > 0){
		$arr = ["code"=>"99" , "msg"=>"이미 등록된 차트번호입니다."];
		echo json_encode($arr);
		exit;
	}
}

//old <-> new
$sql = "select * from $tbl where seq='".$seq."'";
$q = $db->query($sql);
$old_data = $q->fetch();

if($status == "퇴원"){//x퇴원일 경우 밴드 제거
	$sql = "update tbl_equiment set use_equiment='0' where seq='".$patient_bandtype."'";
	$db->query($sql);
	$patient_bandtype = "";
}

$common_sql = "	age='".$age."',
				patient_name='".$patient_name."',
				sex='".$sex."',
				patient_bandtype='".$patient_bandtype."',
				status='".$status."',
				writerip='".$_SERVER['REMOTE_ADDR']."',
				writername='".$_SESSION['manage_id']."',
				modify_date=now()
				where chartnum='".$chartnum."'";
$sql = "update $tbl set ".$common_sql;
try{
	$query = $db->prepare($sql);
	$query->execute();

	
	if($old_data != $patient_bandtype){
		//update
		$sql = "update tbl_equiment set use_equiment='0' where seq='".$old_data['patient_bandtype']."'";
		$db->query($sql);

		$sql = "update tbl_equiment set use_equiment='1' where seq='".$patient_bandtype."'";
		$db->query($sql);
	}

	$arr = ["code"=>"98", "msg"=>"환자정보가 수정되었습니다."];
	echo json_encode($arr);
}catch(Exception $e){
	$arr = ["code"=>"99", "msg"=>$e];
	echo json_encode($arr);
	throw $e;
}

exit;
?>