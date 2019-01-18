<?php
$sql_common = "";

$bandInfo_arr_comma = explode(",", $bandInfo);
// $bandInfo_arr = explode("_", $bandInfo);
$inMat_arr = explode("_", $inMat);
$outMat_arr = explode("_", $outMat);

$sql_insert = "insert into tbl_gatewayband set ";
for($a = 0; $a < count($bandInfo_arr_comma); $a++){
	$seq_sql = "select max(seq) as seq from tbl_gatewayband where 1 order by seq desc limit 1";
	$seq_query = $db->query($seq_sql);
	$seq_val = $seq_query->fetch();
	if($seq_val['seq']){
		$seq = $seq_val['seq'];
		$seq++;
	}else{
		$seq = "1";
	}	
	$bandInfo_arr = explode("_", $bandInfo_arr_comma[$a]);

	$patient_sql = "select * from 
						tbl_patient 
					where 
						patient_bandtype in (select seq from tbl_equiment where equiment_macadd='".$bandInfo_arr[0]."')";
	$patient_query = $db->query($patient_sql);
	$patient_data = $patient_query->fetch();

	$sql_insert_common = " seq='$seq',
							hospid='$hospId',
							gatewayid='$gatewayId',
							bandinfo_mac='".$bandInfo_arr[0]."',
							bandinfo_rssi='".$bandInfo_arr[1]."',
							bandinfo_gps='".$bandInfo_arr[2]."',
							bandinfo_battery='".$bandInfo_arr[3]."',
							inmat_adc='".$inMat_arr[0]."',
							inmat_status='".$inMat_arr[1]."',
							outmat_adc='".$outMat_arr[0]."',
							outmat_status='".$outMat_arr[1]."',
							writeip='".$_SERVER['REMOTE_ADDR']."',
							patient_seq='".$patient_data['chartnum']."',
							regdate=now()";
	$sql = $sql_insert." ".$sql_insert_common;

	if($db->query($sql)){
		// $sql = "select str_device_id from tbl_member where str_patient_seq='".$patient_data['seq']."'";
		// $q = $db->query($sql);
		// if($q->rowCount() == false){
		// 	//pass
		// }else{
		// 	foreach($q as $tokenData){
		// 		$tokens[] = $tokenData['str_device_id'];
		// 	}
		// 	include_once($_SERVER['DOCUMENT_ROOT']."/lib/FcmConstruct.php");
		// }
	}else{
		die($sql);
	}
}
?>