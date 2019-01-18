<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/db.conn.php');

$sql = "select * from tbl_member where str_id='".$_SESSION['mb_id']."'";
$q = $db->query($sql);
$data = $q->fetch();

$sql = "select * from tbl_patient where seq='".$data['str_patient_seq']."'";
$q = $db->query($sql);
$patient = $q->fetch();

$sql = "select * from tbl_gatewayband where patient_seq='".$patient['chartnum']."' order by regdate desc limit 0, 20";
$boardno = "1";
$q = $db->query($sql);

$list_flag = true;
if($q->rowCount() == false){
	$list_flag = false;
}
?>

<ul class="d_t_list1">
	<?php
		if($list_flag == false){
			echo "<li><p>데이터가 없습니다.</p></li>";
		}else{
			foreach($q as $list){
				$sql = "select * from tbl_equiment where equiment_macadd='".$list['gatewayid']."'";
				$q = $db->query($sql);
				$equiment = $q->fetch();

				$exit_flag = "";
				$red = '';
				if($equiment['equiment_etc'] == "출입문" && $list['outmat_status'] == "2"){
					$exit_flag = " 밖으로 나감 ";
					$red = ' style="color:red" ';
				}else if($equiment['equiment_etc'] == "출입문" && $list['inmat_status'] == "2"){
					$exit_flag = " 접근 ";
				}else{
					$exit_flag = " 접근 ";
				}
	?>
	<li <?=$red?>>
		<p class="number"><?=$boardno++?></p>
		<b class="title">
			<?=$equiment['equiment_etc']?>
			<?=$exit_flag?>
		</b>
		<p class="date"><?=$list['regdate']?></p>
	</li>
	<?php
			}
		}
	?>
</ul>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>