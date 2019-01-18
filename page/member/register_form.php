<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
header('Content-Type: text/html; charset=UTF-8');
?>

<form method="post" id="registerForm" name="registerForm" onsubmit="register_Form(this)">
	<input type="hidden" name="device_id" value="<?=$_SESSION['uuid']?>" />
	<fieldset>
		<legend>회원가입</legend>
		<div class="con_box1">
			<table class="p_table1">
				<caption>회원가입 정보</caption>
				<colgroup>
					<col width="110px" />
					<col width="" />
				</colgroup>
				<tbody>
					<tr>
						<th>이름</th>
						<td><input type="text" class="p_input" value="" name="name" placeholder="" /></td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><input type="text" class="p_input" value="" name="id" placeholder="" /></td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td><input type="password" class="p_input" value="" name="pwd" placeholder="비밀번호를 입력해 주세요" /></td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td><input type="password" class="p_input" value="" name="pwd_confirm" placeholder="입력하신 비밀번호를 한 번 더 입력해 주세요." /></td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>
							<div class="p_d_table1">
								<div>
									<input type="text" pattern="\d*" class="p_input" value="" name="phone1" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" value="" name="phone2" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" value="" name="phone3" placeholder="" maxlength="4" />
								</div>
							</div>
							<p style="margin-top:5px;">즉시 연락가능 휴대폰 or 전화번호를 입력해 주세요.</p>
						</td>
					</tr>
					<!-- <tr>
						<th>환자이름</th>
						<td><input type="text" class="p_input" value="" name="patient_name" placeholder="" /></td>
					</tr>
					<tr>
						<th>환자생년월일</th>
						<td><input type="date" class="p_input" value="2018-01-01" name="patient_birth" placeholder="" /></td>
					</tr> -->
				</tbody>
			</table>
		</div>
		<div class="bt_box1">
			<button type="button" class="bt_01" onclick="register_Form(document.registerForm)">등록</button>
			<!-- <button type="button" class="bt_01" onclick="location.href='register_result.php'">등록</button> -->
		</div>
	</fieldset>
</form>


<script>
function isNumeric(n) { 
	return !isNaN(parseFloat(n)) && isFinite(n); 
}
function register_Form(frm){
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
		alert("비밀번호가 다릅니다.");
		frm.pwd_confirm.focus();
		return;
	}
	if(frm.pwd.value != frm.pwd_confirm.value){
		alert("비밀번호가 다릅니다.");
		frm.pwd_confirm.focus();
		return;
	}
	
	if(frm.phone1.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		frm.phone1.focus();
		return;
	}

	if(!isNumeric(frm.phone1.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		frm.phone1.focus();
		return;
	}
	
	if(frm.phone2.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		frm.phone2.focus();
		return;
	}

	if(!isNumeric(frm.phone2.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		frm.phone2.focus();
		return;
	}

	if(frm.phone3.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		frm.phone3.focus();
		return;
	}

	if(!isNumeric(frm.phone3.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		frm.phone3.focus();
		return;
	}

	// Legacy
	// if(Number.isInteger(frm.phone1.value) == false){
	// 	alert("전화번호는 숫자만 입력 가능합니다.");
	// 	frm.phone1.focus();
	// 	return;
	// }
	// if(Number.isInteger(frm.phone2.value) == false){
	// 	alert("전화번호는 숫자만 입력 가능합니다.");
	// 	frm.phone2.focus();
	// 	return;
	// }

	// if(Number.isInteger(frm.phone3.value) == false){
	// 	alert("전화번호는 숫자만 입력 가능합니다.");
	// 	frm.phone3.focus();
	// 	return;
	// }
	
	// if(frm.patient_name.value.trim() == ""){
	// 	alert("환자 이름을 입력해 주세요.");
	// 	frm.patient_name.focus();
	// 	return;
	// }

	// if(frm.patient_birth.value.trim() == ""){
	// 	alert("환자의 생일을 입력해 주세요.");
	// 	frm.patient_birth.focus();
	// 	return;
	// }
	
	if(confirm("해당 내용으로 회원가입 하시겠습니까?")){
		frm.action = "/lib/register_update.php"
		frm.submit();
	}else{
		return
	}

	return false;
}
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>