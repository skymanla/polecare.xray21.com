<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$sql = "select * from tbl_management_auth where seq='".$_GET['id']."'";
$query = $db->query($sql);

if($query->rowCount() == false){
	header("HTTP/1.1 400 Bad Request");
	exit;
}
$row = $query->fetch();
?>
<section class="section1">
	<form name="authForm" onsubmit="authFrm(this)">
		<input type="hidden" name="seq" value='<?=$row['seq']?>' />
		<div class="table_wrap1">
			<table>
				<caption>회원등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">권한설정 수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>권한명</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['auth_name']?>" name="auth_name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>권한메뉴</th>
						<td>
							<div class="label_box1_wrap">
								<?php
									$sql = "select * from tbl_auth where 1 order by seq asc";
									$q = $db->query($sql);
									$auth_arr = explode("||", $row['auth_types']);
									foreach($q as $auth_row){
										$checked = "";
										if(in_array($auth_row['seq'], $auth_arr)){
											$checked = "checked";	
										}
								?>
								<div class="label_box4">
									<input type="checkbox" name="auth_type" value="<?=$auth_row['seq']?>" <?=$checked?> /><label for=""><?=$auth_row['auth_name']?></label>
								</div>
								<?php } ?>
							</div>
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
			<a href="javascript:authFrm(document.authForm);" class="bt_1">수정</a>
			<a href="javascript:authDelete();" class="bt_2">삭제</a>
			<a href="s1stab1.php"class="bt_2">목록</a>
		</div>
	</form>
</section>
<script>
function authFrm(Frm){
	if(Frm.auth_name.value.trim() == ""){
		alert("권한명을 입력해주세요.");
		Frm.auth.focus();
		return;
	}

	var checkboxData = $("input[name=auth_type]:checked").map(function(){
		return $(this).val();
	}).get()

	$.ajax({
		data: {"seq": Frm.seq.value, "auth_name" : Frm.auth_name.value.trim(), "auth_type_arr" : checkboxData},
		type: "post",
		dataType: "json",
		url: "/lib/manage/manage_update_group_auth.php",
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