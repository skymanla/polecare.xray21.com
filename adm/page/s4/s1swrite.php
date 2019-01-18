<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
$cur_page = (int)$_GET['cur_page'];
if($cur_page=="") $cur_page = 1; //페이지 번호가 없으면 1번 페이지
?>
<section class="section1">
	<form name="equimentForm">
		<div class="table_wrap1">
			<table>
				<caption>장비관리 등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">장비관리 등록</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>분류</th>
						<td>
							<select name="equiment" title="" class="w_input1">
								<option value="" selected="selected">선택</option>
								<option value="손목형밴드" <?=$bandSelect?>>손목형 밴드</option>
								<option value="게이트웨이" <?=$gatewaySelect?>>게이트웨이</option>
								<option value="스마트매트" <?=$smartSelect?>>스마트매트</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>단말기명</th>
						<td>
							<input type="text" class="w_input1" value="" name="name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>단말기 MAC</th>
						<td>
							<input type="text" class="w_input1" value="" name="mac" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>비고</th>
						<td>
							<input type="text" class="w_input1" value="" name="etc" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="use" id="use_yes" value="사용" checked=""><label for="use_yes">사용</label></div>
								<div class="label_box1"><input type="radio" name="use" id="use_no" value="사용중지"><label for="use_no">사용안함</label></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:equimentFrm(document.equimentForm);" class="bt_1">저장</a>
			<a href="s1.php?&page=<?=$cur_page?>"class="bt_2">목록</a>
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
		data: { "type": frm.equiment.value, "name": frm.name.value.trim(), "mac": frm.mac.value.trim(), "etc": frm.etc.value.trim(), "status": frm.use.value},
		type: "post",
		dataType: "json",
		url: "/lib/manage/manage_add_equiment.php",
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
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>