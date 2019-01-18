<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
?>
<section class="section1">
	<form name="authWriteForm">
		<div class="table_wrap1">
			<table>
				<caption>회원등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">권한설정 등록</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>권한명</th>
						<td>
							<input type="text" class="w_input1" value="" name="auth_name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>권한메뉴</th>
						<td>
							<div class="label_box1_wrap">
								<?php
									$sql = "select * from tbl_auth where 1 order by seq asc";
									$q = $db->query($sql);

									foreach($q as $auth_row){
								?>
								<div class="label_box4">
									<input type="checkbox" name="auth_type" value="<?=$auth_row['seq']?>" /><label for=""><?=$auth_row['auth_name']?></label>
								</div>
								<?php } ?>
								<!-- <div class="label_box4">
									<input type="checkbox" name="" /><label for="">관리자 회원 관리</label>
								</div>
								<div class="label_box4">
									<input type="checkbox" name="" /><label for="">환자 관리</label>
								</div>
								<div class="label_box4">
									<input type="checkbox" name="" /><label for="">사용자관리(앱)</label>
								</div>
								<div class="label_box4">
									<input type="checkbox" name="" /><label for="">장비관리</label>
								</div>
								<div class="label_box4">
									<input type="checkbox" name="" /><label for="">출입제한 이력관리</label>
								</div> -->
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:authWriteFrm(document.authWriteForm);" class="bt_1">저장</a>
			<a href="s1stab1.php"class="bt_2">목록</a>
		</div>
	</form>
</section>
<script>
function authWriteFrm(frm){
	if(frm.auth_name.value.trim() == ""){
		alert("권한명을 입력해 주세요.");
		frm.auth_name.focus();
		return;
	}
	
	var checkboxData = $("input[name=auth_type]:checked").map(function(){
		return $(this).val();
	}).get()
	
	$.ajax({
		data: {"auth_name" : frm.auth_name.value.trim(), "auth_type_arr" : checkboxData},
		type: "post",
		dataType: "json",
		url: "/lib/manage/manage_add_group_auth.php",
		success: function(r){
			alert(r.msg);
			if(r.code == "98"){	
				location.href="./s1stab1.php";
			}
		}, error: function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>