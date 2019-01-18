<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");
if(!$_GET['id']){
	header("HTTP/1.1 404 Bad Request");
	go_href("잘못된 접근입니다.", "", "back");
	exit;
}

$seq = (string) $_GET['id'];
$tbl = "tbl_equiment";
$sql = "select * from $tbl where seq='".$seq."'";
$q = $db->query($sql);

if($q->rowCount() == "0"){
	header("HTTP/1.1 404 Bad Request");
	go_href("잘못된 접근입니다.", "", "back");
	exit;
}else{
	$row = $q->fetch();

	$bandSelect = "";
	$gatewaySelect = "";
	$smartSelect = "";
	switch($row['equiment_type']){
		case "손목형밴드":
			$bandSelect = "selected";
			break;
		case "게이트웨이":
			$gatewaySelect = "selected";
			break;
		case "스마트매트":
			$smartSelect = "selected";
			break;
	}
}
?>
<section class="section1">
	<form name="equimentForm">
		<input type="hidden" name="seq" value="<?=$row['seq']?>" />
		<div class="table_wrap1">
			<table>
				<caption>장비관리 수정</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">장비관리 수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>분류</th>
						<td>
							<select name="equiment" title="" class="w_input1">							
								<option value="">선택</option>
								<option value="손목형밴드" <?=$bandSelect?>>손목형 밴드</option>
								<option value="게이트웨이" <?=$gatewaySelect?>>게이트웨이</option>
								<option value="스마트매트" <?=$smartSelect?>>스마트매트</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>단말기명</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['equiment_name']?>" name="name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>단말기 MAC</th>
						<td>
							<input type="hidden" class="w_input1" value="<?=$row['equiment_macadd']?>" name="mac" placeholder="" style="width:300px"/>
							<?=$row['equiment_macadd']?>
						</td>
					</tr>
					<tr>
						<th>비고</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['equiment_etc']?>" name="etc" placeholder="" style="width:100%"/>
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="use" id="use_yes" value="사용" <?=$row['status'] == "사용" ? "checked" : "" ?>><label for="use_yes">사용</label></div>
								<div class="label_box1"><input type="radio" name="use" id="use_no" value="사용중지" <?=$row['status'] == "사용중지" ? "checked" : "" ?>><label for="use_no">사용안함</label></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:equimentFrm(document.equimentForm);" class="bt_1">저장</a>
			<a href="s1.php"class="bt_2">목록</a>
		</div>
	</form>
</section>
<script>
function equimentFrm(frm){
	if(frm.equiment.value == ""){
		alert("장비 분류를 선택해주세요.");
		return;
	}
	if(frm.name.value.trim() == ""){
		alert("단말기명을 입력해 주세요.");
		frm.name.focus();
		return;
	}
	if(frm.mac.value.trim() == ""){
		alert("단말기 MAC을 입력해 주세요.");
		frm.mac.focus();
		return;
	}
	
	$.ajax({
		data: { "seq": frm.seq.value, "type": frm.equiment.value, "name": frm.name.value.trim(), "mac": frm.mac.value.trim(), "etc": frm.etc.value.trim(), "status": frm.use.value},
		type: "post",
		dataType: "json",
		url: "/lib/manage/manage_modify_equiment.php",
		success: function(r){
			alert(r.msg);
			location.href="./s1.php?page=<?=$_GET['page']?>"
		}, error: function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>