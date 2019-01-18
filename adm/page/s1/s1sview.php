<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$sql = "select * from tbl_management where manage_id='".$_GET['id']."' and delete_flag != 1";
$query = $db->query($sql);

if($query->rowCount() == false){
	header("HTTP/1.1 400 Bad Request");
	exit;
}
$row = $query->fetch();
?>
<section class="section1">
	<form name="manageForm" method="post">
		<input type="hidden" name="manage_id" value="<?=$row['manage_id']?>" />
		<div class="table_wrap1">
			<table>
				<caption>회원등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">관리자회원수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>이름</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['manage_name']?>" name="manage_name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><?=$row['manage_id']?></td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>
							<input type="password" class="w_input1" value="" name="manage_pwd" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>병원</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['manage_hospid']?>" name="manage_hospid" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>권한</th>
						<td>
							<select name="manage_auth" title="" class="w_input1">	
								<?php
									$sql = "select * from tbl_management_auth where 1 order by seq desc";
									$q = $db->query($sql);								
									if($q->rowCount() == false){
								?>
								<option value="" >등록된 권한이 없습니다.</option>
								<?php
									}else{
										foreach($q as $auth_row){
								?>
								<option value="<?=$auth_row['seq']?>" <?=$auth_row['seq'] == $row['manage_auth'] ? "selected" : ""?>><?=$auth_row['auth_name']?></option>
								<?php 
										}
									} 
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th>등록일</th>
						<td><?=$row['regdate']?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:manageFrm(document.manageForm)" class="bt_1">수정</a>
			<a href="javascript:manageDelete(document.manageForm);" class="bt_2">삭제</a>
			<a href="s1.php"class="bt_2">목록</a>
		</div>
	</form>						
</section>
<script>
function manageFrm(frm){
	if(frm.manage_name.value.trim() == "")	{
		alert("이름을 입력해주세요.");
		frm.manage_name.focus();
		return;
	}

	if(frm.manage_hospid.value.trim() == ""){
		alert("병원아이디를 입력해주세요.");
		frm.manage_hospid.focus();
		return;
	}

	// if(frm.manage_auth.value.trim() == ""){
	// 	alert("권한을 선택해주세요.");
	// 	return;
	// }

	$.ajax({
		data: {"id": frm.manage_id.value.trim(), 
				"pwd": frm.manage_pwd.value.trim(),
				"name": frm.manage_name.value.trim(),
				"auth_seq": frm.manage_auth.value.trim(),
				"hospid": frm.manage_hospid.value.trim()},
		dataType: "json",
		type: "post",
		url: "/lib/manage/manage_update_id.php",
		success: function(r){
			alert(r.msg);
			if(r.code == "98"){
				location.href="./s1.php";
			}
		}, error: function(){
			console.log('errrrrrrrr');
		}
	})
}

function manageDelete(frm){
	$.ajax({
		data: {"id": frm.manage_id.value.trim()},
		dataType: "json",
		type: "post",
		url: "/lib/manage/manage_delete_id.php",
		success: function(r){
			alert(r.msg);
			if(r.code == "98"){
				location.href="./s1.php";
			}
		}, error: function(){
			console.log('errrrrr');
		}
	})
}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>