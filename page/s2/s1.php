<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$tbl = "tbl_patient";
$sql = " select 
			a.*, b.equiment_macadd, b.equiment_name, b.equiment_type, b.status 
		from $tbl a left join tbl_equiment b on a.patient_bandtype=b.seq 
		where a.seq='".$_SESSION['patient_seq']."'";
// echo $sql;
$query = $db->query($sql);

if($query->rowCount() == false){
	go_href("등록된 환자가 없습니다.", "", "back");
	exit;
}

$row = $query->fetch();
?>

<div class="con_box1">
	<table class="p_table1">
		<caption>환자관리 정보</caption>
		<colgroup>
			<col width="100px" />
			<col width="" />
		</colgroup>
		<tbody>
			<tr>
				<th>차트번호</th>
				<td><?=$row['chartnum']?></td>
			</tr>
			<tr>
				<th>연령</th>
				<td><?=$row['age']?></td>
			</tr>
			<tr>
				<th>성별</th>
				<td><?=$row['sex'] === "m" ? "남자" : "여자" ?></td>
			</tr>
			<tr>
				<th>이름</th>
				<td><?=$row['patient_name']?></td>
			</tr>
			<tr>
				<th>손목형밴드</th>
				<td><?=$row['equiment_name']?></td>
			</tr>
		</tbody>
	</table>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>