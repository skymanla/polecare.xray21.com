<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');?>
<div class="con_box1 mrb10">
	<p class="copy_box1">
		회원가입 시 등록하신 정보를 입력해 주세요. <br />
		해당 번호로 <b>비밀번호 정보</b>를 보내드립니다.
	</p>
</div>
<form method="post" action="">
	<fieldset>
		<legend>아이디찾기</legend>
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
						<td><input type="text" class="p_input" value="" name="" placeholder="" /></td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><input type="text" class="p_input" value="" name="" placeholder="" /></td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>
							<div class="p_d_table1">
								<div>
									<input type="text" pattern="\d*" class="p_input" id="phone1" value="" name="phone1" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" id="phone2" value="" name="phone2" placeholder="" maxlength="4" />
								</div>
								<div>
									<input type="text" pattern="\d*" class="p_input" id="phone3" value="" name="phone3" placeholder="" maxlength="4" />
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="bt_box1">
		<button type="button" class="bt_01" onclick="checkId()">확인</button>
		</div>
	</fieldset>
</form>

<script type="text/javascript">
//<![CDATA[
$(function(){
	// checkId();
});

function isNumeric(n) { 
	return !isNaN(parseFloat(n)) && isFinite(n); 
}

function checkId(){
	var phone1 = document.getElementById("phone1")
	var phone2 = document.getElementById("phone2")
	var phone3 = document.getElementById("phone3")

	if(!isNumeric(phone1.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		phone1.focus();
		return;
	}
	if(!isNumeric(phone2.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		phone2.focus();
		return;
	}
	if(!isNumeric(phone3.value.trim())){
		alert("전화번호는 숫자만 가능합니다.");
		phone3.focus();
		return;
	}

	$('.bt_01').on('click',function(){
		alert('전송이 완료되었습니다.');
		location.href='/index.php';
	});
}
//]]>
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>