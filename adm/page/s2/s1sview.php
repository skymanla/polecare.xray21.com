<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$id = $_GET['id'];
$tbl = "tbl_patient";


if(empty($id)){
	header("HTTP/1.1 404 Bad Request");
	go_href("잘못된 접근입니다.", "", "back");
	exit;
}

$sql = "select * from $tbl where chartnum='".$id."' and status='입원' and delete_flag != 1";
$q = $db->query($sql);

if($q->rowCount() == "0"){
	header("HTTP/1.1 404 Bad Request");
	go_href("잘못된 접근입니다.", "", "back");
	exit;
}else{
	$row = $q->fetch();
}
?>
<section class="section1">
	<form name="patientForm" method="post">
		<input type="hidden" name="seq" value="<?=$row['seq']?>" />
		<div class="table_wrap1">
			<table>
				<caption>회원정보 수정</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">회원정보 수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>차트번호</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['chartnum']?>" name="chartnum" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>연령</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['age']?>" name="age" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>성별</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="xy" id="w_x" value="m" <?=$row['sex'] == "m" ? "checked" : "" ?>><label for="w_x">남</label></div>
								<div class="label_box1"><input type="radio" name="xy" id="w_y" value="w" <?=$row['sex'] == "w" ? "checked" : "" ?>><label for="w_y">여</label></div>
							</div>
						</td>
					</tr>
					<tr>
						<th>이름</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['patient_name']?>" name="patient_name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>손목형밴드</th>
						<td>
							<select name="patient_bandtype" title="" class="w_input1">
								<?php
									//자신 것 가져오기
									$sql = "select seq, equiment_name, equiment_macadd 
												from tbl_equiment
											where seq='".$row['patient_bandtype']."'";
									$q = $db->query($sql);
									$v = $q->fetch();
									if($q->rowCount() > 0){
										echo '<option value="'.$v['seq'].'" selected>'.$v['equiment_name'].'('.$v['equiment_macadd'].')</option>';
									}
									$sql = "select seq, equiment_name, equiment_macadd 
												from tbl_equiment 
											where 
												equiment_type='손목형밴드' and 
												delete_flag = '0' and
												status='사용' and
												use_equiment='0'
												order by seq desc";
									$q = $db->query($sql);
									foreach($q as $equiment){										
										echo "<option value='".$equiment['seq']."' >".$equiment['equiment_name']."(".$equiment["equiment_macadd"].")</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="status" id="use_yes" value="입원" <?=$row['status'] == "입원" ? "checked" : "" ?>><label for="use_yes">사용</label></div>
								<div class="label_box1"><input type="radio" name="status" id="use_no" value="퇴원" <?=$row['status'] == "퇴원" ? "checked" : "" ?>><label for="use_no">퇴원</label></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:patientFrm(document.patientForm);" class="bt_1">수정</a>
			<a href="javascript:modiy_stat('D', 'patient');" class="bt_2">삭제</a>
			<a href="./s1.php"class="bt_2">목록</a>
		</div>
	</form>
</section>
<script>
function patientFrm(frm){
	if(frm.chartnum.value.trim() == ""){
		alert("차트번호를 입력해 주세요.");
		frm.chartnum.focus();
		return;
	}
	if(frm.age.value.trim() == ""){
		alert("연령을 입력해 주세요.");
		frm.age.focus();
		return;
	}
	if(frm.patient_name.value.trim() == ""){
		alert("환자이름을 입력해 주세요.");
		frm.patient_name.focus();
		return;
	}
	if(frm.patient_bandtype.value.trim() == ""){
		alert("손목형 밴드를 선택해 주세요.");		
		return;
	}

	$.ajax({
		data: {
			"seq": frm.seq.value,
			"chartnum": frm.chartnum.value.trim(),
			"age": frm.age.value.trim(),
			"patient_name": frm.patient_name.value.trim(),
			"sex": frm.xy.value,
			"patient_bandtype": frm.patient_bandtype.value,
			"status": frm.status.value
		},
		type: "post",
		dataType: "json",
		url: "/lib/manage/manage_modify_patient.php",
		success: function(r){
			alert(r.msg);
			if(r.code=="98"){
				location.href="./s1.php";
			}
		}, error: function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}

function modiy_stat(mode, type){
	if(mode=="D"){
		var chk_data = new Array();
		$.ajax({
			type : 'POST',
			dataType: "json",
			url : '/lib/manage/manage_del_list.php',
			data : {"seq" : chk_data.push("<?=$row['seq']?>"), "type": type},
			success : function(result){
				//console.log(result);
				alert("선택된 환자가 삭제되었습니다.");
				location.href="./s1.php";
			}, error : function(jqXHR, textStatus, errorThrown){
				console.log("error!\n"+textStatus+" : "+errorThrown);
			}
		});
	}else{
		console.log('undefinded mode');
		return false;
	}
}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>