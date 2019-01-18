<?php
header("Content-Type:application/json");
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/db.conn.php');

$arr = array();
$sql = "select 
			a.*, 
			b.equiment_name, b.equiment_type, b.equiment_etc,
			c.chartnum, c.patient_name, c.patient_bandtype
			from 
			tbl_gatewayband a left join tbl_equiment b on a.gatewayid=b.equiment_macadd
			left join tbl_patient c on a.patient_seq=c.chartnum
			where 
				outmat_status='2' and
				a.regdate > date_format(date_add(now(), interval -20 MINUTE ), '%Y-%m-%d %H:%i:%s')
			order by regdate desc limit 0,5";
$q = $db->query($sql);

if($q->rowCount() == false){
	$arr = ["code"=>"99", "showClass"=>"NoData"];
	echo json_encode($arr);
	exit;
}else{
	$result = $q->fetchAll(PDO::FETCH_ASSOC);
	$arr = ["code"=>"98", "showClass"=>"getData", "data"=>$result];	
	echo json_encode($arr);
	exit;
}
?>
