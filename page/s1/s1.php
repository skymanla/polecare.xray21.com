<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/db.conn.php');

$sql = "select * from tbl_patient where seq='".$_SESSION['patient_seq']."'";
$q = $db->query($sql);
$patient = $q->fetch();

$sql = "select * from tbl_gatewayband where patient_seq='".$patient['chartnum']."' order by regdate desc limit 0, 1";
// echo $sql;
$q = $db->query($sql);
$bandInfo = $q->fetch();

$img_info = "";
switch($bandInfo['outmat_status']){
	case "2":
		$img_info = "O";
		break;
	default:
		$img_info = "X";
		break;
}
?>

<!--  층간 체크
<div class="con_box2 mrb10">
	<div class="check_room_box">
		<h3>2층</h3>
		<ul>
			<li>
				<div><p>201</p></div>
			</li>
			<li>
				<div class="active"><p>202</p></div>
			</li>
			<li>
				<div><p>203</p></div>
			</li>
		</ul>
	</div>
</div>

<div class="con_box2">
	<div class="check_room_box">
		<h3>1층</h3>
		<ul>
			<li>
				<div><p>101</p></div>
			</li>
			<li>
				<div><p>102</p></div>
			</li>
			<li>
				<div><p>103</p></div>
			</li>
		</ul>
	</div>
</div>
층간 체크 -->

<!-- SRT 현재상태 bed 유무-->
<?php if($img_info == "X"){ ?>
<div class="con_box2 mrb10">
	<div class="check_room_box">
		<h3>현재상태</h3>
		<div class="bed_check no"></div>
	</div>
</div>
<?php }else{ ?>
<div class="con_box2">
	<div class="check_room_box">
		<h3>현재상태</h3>
		<div class="bed_check"></div>
	</div>
</div>
<?php } ?>
<!-- END 현재상태 bed 유무-->

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>