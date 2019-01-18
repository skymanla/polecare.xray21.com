<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>폴케어 관리자</title>
	<link rel="stylesheet" type="text/css" href="/adm/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="/adm/css/login.css" />
	<script type="text/javascript" src="/adm/js/common.js"></script>
	<script type="text/javascript" src="/adm/js/jquery-1.12.4.min.js"></script>
</head>
<body>
<!-- STR warp -->
<div id="wrap">
	<div id="login_wrap">
		<h1 class="text">폴케어</h1>
		<form method="post" action="" onsubmit="manageFrm(this)" name="manageForm">
			<fieldset>
				<legend>로그인</legend>
				<div class="input_box"><label for="">ID</label><input type="text" name="id" id="id" placeholder="아이디" /></div>
				<div class="input_box"><label for="">PW</label><input type="password" name="pw" id="pw" placeholder="패스워드" /></div>
				<button type="button" onclick="manageFrm(document.manageForm)">LOGIN</button>
			</fieldset>
		</form>
	</div>
</div>
<script>
$(function(){
	$(document).keyup(function(event){
		if(event.keyCode == 13){			
			manageFrm(document.manageForm);
		}
	})
})
function manageFrm(Frm){
	console.log(Frm);
	if(Frm.id.value.trim() == ""){
		alert("아이디를 입력해주세요.");
		Frm.id.focus();
		return;
	}

	if(Frm.pw.value.trim() == ""){
		alert("비밀번호를 입력해주세요.");
		Frm.pw.focus();
		return;
	}

	$.ajax({
		url: "/lib/manage/manage_loginProc.php",
		data: {"id": Frm.id.value, "pwd": Frm.pw.value},
		dataType: "json",
		type: "POST",
		success: function(r){
			alert(r.msg);
			location.href=r.url;
		},
		error: function(){
			console.log("errrrrrr");
		}
	})
}
</script>
<!-- END warp -->
</body>
</html>