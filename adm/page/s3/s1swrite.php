<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
?>
<section class="section1">
	<form name="userForm">
		<div class="table_wrap1">
			<table>
				<caption>사용자관리(앱) 등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">사용자관리(앱) 등록</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>이름</th>
						<td>
							<input type="text" class="w_input1" value="" name="name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>아이디</th>
						<td>
							<input type="text" class="w_input1" value="" name="id" placeholder="" style="width:300px"/>
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
							<input type="text" class="w_input1" value="" name="hp" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<!-- <tr>
						<th>닉네임</th>
						<td>
							<input type="text" class="w_input1" value="" name="" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>차트번호</th>
						<td>
							<input type="text" class="w_input1" value="" name="" placeholder="" style="width:300px"/>
						</td>
					</tr> -->
					<tr>
						<th>환자이름</th>
						<td>
							<input type="hidden" name="patient_seq" value="" />
							<input type="text" class="w_input1" value="" name="patient_name" placeholder="" style="width:300px" readonly/>
							<!-- SRT  2018-12-17 팝업 추가-->
							<button type="button" class="bt_s1 input_sel" onclick="mSearch()">검색</button>
							<!-- SRT  2018-12-17 팝업 추가-->
						</td>
					</tr>
					<tr>
						<th>환자생년월일</th>
						<td>
							<input type="text" class="w_input1" value="" name="patient_birth" placeholder="" style="width:300px" />
						</td>
					</tr>
					<tr>
						<th>상태</th>
						<td>
							<div class="label_box1_wrap">
								<div class="label_box1"><input type="radio" name="use" id="use_yes" value="Y" checked=""><label for="use_yes">승인</label></div>
								<div class="label_box1"><input type="radio" name="use" id="use_no" value="N"><label for="use_no">미승인</label></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:userFrm(document.userForm);" class="bt_1">저장</a>
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
	if(frm.id.value.trim() == ""){
		alert("아이디를 입력해 주세요.");
		frm.id.focus();
		return;
	}
	if(frm.pwd.value.trim() == ""){
		alert("비밀번호를 입력해 주세요.");
		frm.pwd.focus();
		return;
	}
	if(frm.pwd_confirm.value.trim() == ""){
		alert("비밀번호 확인을 해주세요.");
		frm.pwd_confirm.focus();
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
		url: "/lib/manage/manage_add_user.php",
		success: function(r){
			// console.log(r);
			alert(r.msg);
			if(r.code=="98"){
				location.href="./s1.php";
			}
		}, error: function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	})
}

function popupAjax(getPage, searchKey){

}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>