<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/db.conn.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/function.php');

$phone_arr = explode("-", phoneLength($_SESSION['mb_hp']));

?>
<form method="post" action="" name="registerFrm">
	<input type="hidden" name="flag" value="w" />
	<input type="hidden" name="deviceId" value="<?=$_GET['token']?>" />
	<input type="hidden" name="str_id" value="<?=$_SESSION['mb_id']?>" />
	<input type="hidden" name="str_name" value="<?=$_SESSION['mb_name']?>" />
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
						<td><?=$_SESSION['mb_name']?></td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><?=$_SESSION['mb_id']?></td>
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
									<input type="text" pattern="\d*" class="p_input" value="<?=$phone_arr[0]?>" name="phone1" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" value="<?=$phone_arr[1]?>" name="phone2" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" value="<?=$phone_arr[2]?>" name="phone3" placeholder="" maxlength="4" />
								</div>
							</div>
							<p style="margin-top:5px;">즉시 연락가능 휴대폰 or 전화번호를 입력해 주세요.</p>
						</td>
					</tr>
					<tr>
						<th></th>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="bt_box1">
			<button type="button" class="bt_02" onclick="cancelMove();">취소</button>
			<button type="button" class="bt_01" onclick="registerFrmw(document.registerFrm);">수정</button>
			<button type="button" class="bt_02" onclick="logout();">로그아웃</button>
		</div>
	</fieldset>
</form>
<script>
function cancelMove(){
	location.href="/";
}
function isNumeric(n) { 
	return !isNaN(parseFloat(n)) && isFinite(n); 
}
function registerFrmw(Frm){
	if(Frm.pwd.value.trim() != ""){
		if(Frm.pwd.value.trim() != Frm.pwd_confirm.value.trim()){
			alert("입력하신 비밀번호가 다릅니다.");
			Frm.pwd_confirm.focus();
			return;
		}
	}

	if(Frm.phone1.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		frm.phone1.focus();
		return;
	}

	if(!isNumeric(Frm.phone1.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		Frm.phone1.focus();
		return;
	}
	
	if(Frm.phone2.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		Frm.phone2.focus();
		return;
	}

	if(!isNumeric(Frm.phone2.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		Frm.phone2.focus();
		return;
	}

	if(Frm.phone3.value.trim() == ""){
		alert("전화번호를 입력해 주세요.");
		Frm.phone3.focus();
		return;
	}

	if(!isNumeric(Frm.phone3.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		Frm.phone3.focus();
		return;
	}

	Frm.action="/lib/register_update.php";
	Frm.submit();
}
function logout(){
	location.href="/lib/logoutProc.php";
}
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>