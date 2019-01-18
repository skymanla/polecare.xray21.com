<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");
if(!$_GET['id']){
	header("HTTP/1.1 404 Bad Request");
	go_href("잘못된 접근입니다.", "", "back");
	exit;
}

$str_id = $_GET['id'];
$tbl = "tbl_member";
$sql = "select * from $tbl where str_id='".$str_id."' and delete_flag != 1";
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
	<form name="memberForm" method="post">
		<input type="hidden" name="seq" value="<?=$row['str_idx']?>" />
		<div class="table_wrap1">
			<table>
				<caption>사용자관리(앱) 수정</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">사용자관리(앱) 수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>이름</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['str_name']?>" name="name" placeholder="" style="width:300px"/>							
						</td>
					</tr>
					<tr>
						<th>아이디</th>
						<td>
							<input type="hidden" name="id" value="<?=$row['str_id']?>" />
							<?=$row['str_id']?>
						</td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>
							<input type="password" class="w_input1" value="" name="pwd" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td>
							<input type="password" class="w_input1" value="" name="pwd_confirm" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>휴대폰 번호</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['str_hp']?>" name="hp" placeholder="" style="width:300px"/>							
						</td>
					</tr>
					<tr>
						<th>환자이름</th>
						<td>
							<input type="hidden" name="patient_seq" value="<?=$row['str_patient_seq']?>" />
							<input type="text" class="w_input1" value="<?=$row['str_patient_name']?>" name="patient_name" placeholder="" style="width:300px" readonly />
							<!-- SRT  2018-12-17 팝업 추가-->
							<button type="button" class="bt_s1 input_sel" onclick="mSearch()">검색</button>
							<!-- SRT  2018-12-17 팝업 추가-->				
						</td>
					</tr>
					<tr>
						<th>환자생년월일</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['str_patient_birth']?>" name="patient_birth" placeholder="" style="width:300px"/>							
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="use" id="use_yes" value="Y" <?=$row['member_accept'] == "Y" ? "checked" : "" ?>><label for="use_yes">승인</label></div>
								<div class="label_box1"><input type="radio" name="use" id="use_no" value="N" <?=$row['member_accept'] == "N" ? "checked" : "" ?>><label for="use_no">미승인</label></div>
							</div>
						</td>
					</tr>
					<tr>
						<th>등록일</th>
						<td>
							<?=$row['str_join_date']?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:userFrm(document.memberForm);" class="bt_1">수정</a>
			<a href="javascript:modiy_stat('D', 'member');" class="bt_2">삭제</a>
			<a href="s1.php"class="bt_2">목록</a>
		</div>
	</form>

	<!-- SRT  2018-12-17 팝업 추가-->
	<div class="pop_wrap1" id="mem_search">
	
	</div>
	<!-- END 2018-12-17 팝업 추가 -->
	
</section>
<script>
// STR 2018-12-17 팝업 추가
function mSearch(){
	var $tar = $('#mem_search');
	
	$tar.show().draggable();

	$.ajax({
		data: {
			"cur_page" : "1",
			"searchKey" : ""
		},
		url: "/lib/common/searchPatient.php",
		type: "post",
		success: function(r){
			$('#mem_search').append(r);
		}, error:  function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})

	$tar.find('.pop_cencle').on('click',function (){
		$tar.empty();
		$tar.hide();
	});
}

function searchAjax(){
	$.ajax({
		data: {
			"cur_page" : "1",
			"searchKey": $('input[name=searchKey]').val()
		},
		type: "post",
		url: "/lib/common/searchPatient.php",
		success: function(r){
			$('#mem_search').empty();
			$('#mem_search').append(r);
		}, error:  function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}

function movePage(cur_page, searchKey){
	$.ajax({
		data: {
			"cur_page" : cur_page,
			"searchKey": searchKey
		},
		type: "post",
		url: "/lib/common/searchPatient.php",
		success: function(r){
			$('#mem_search').empty();
			$('#mem_search').append(r);
		}, error:  function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}
// END 2018-12-17 팝업 추가
function userFrm(frm){
	if(frm.name.value.trim() == ""){
		alert("이름을 입력해 주세요.");
		frm.name.focus();
		return;
	}
	
	if(frm.pwd.value.trim() != frm.pwd_confirm.value.trim()){
		alert("비밀번호를 확인해 주세요.");
		frm.pwd_confirm.focus();
		return;
	}
	if(frm.hp.value.trim() == ""){
		alert("연락처를 입력해 주세요.");
		frm.hp.focus();		
		return;
	}
	if(frm.patient_name.value.trim() == ""){
		alert("환자 이름을 입력해 주세요.");
		frm.patient_name.focus();
		return;
	}
	
	$.ajax({
		data: {"name": frm.name.value.trim(), 
				"id": frm.id.value.trim(),
				"pwd": frm.pwd.value.trim(),
				"hp": frm.hp.value.trim(),
				"patient_seq": frm.patient_seq.value,
				"patient_name": frm.patient_name.value.trim(),
				"patient_birth": frm.patient_birth.value.trim(),
				"status": frm.use.value
			},
		type: "post",
		dataTyoe: "json",
		url: "/lib/manage/manage_modify_user.php",
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

/* select delete start */
function modiy_stat(mode, type){
	if(mode=="D"){
		var chk_data = new Array()
		
		$.ajax({
			type : 'POST',
			dataType: "json",
			url : '/lib/manage/manage_del_list_user.php',
			data : {"seq" : chk_data.push("<?=$row['str_idx']?>"), "type": type},
			success : function(result){
				//console.log(result);
				alert("선택된 회원이 삭제되었습니다.");
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
/* select delete end */
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>