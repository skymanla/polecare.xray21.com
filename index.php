<?php
session_start();
if(isset($_GET['token'])){
	$_SESSION['uuid'] = $_GET['token'];
}
if($_SESSION['mb_id'] && $_SESSION['mb_name']){
	echo '<meta http-equiv="refresh" content="0;url=/page/s1/s1.php">';
	exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=yes" />
	<title>폴케어</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css?v=<?=time()?>" />
	<link rel="stylesheet" type="text/css" href="css/login.css?v=<?=time()?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
	<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
</head>
<body>
<!-- STR warp -->
<div id="wrap">
	<div id="login_box">
		<header>
			<h1>폴케어</h1>
			<p>로그인이 필요합니다.</p>
		</header>
		<div class="form_box">
			<form name="loginForm" method="post" action="/lib/login_chk.php" onsubmit="loginFrm(this)">
				<fieldset>
					<legend>로그인</legend>
					<input type="text" class="" value="" name="id" placeholder="아이디" />
					<input type="password" class="" value="" name="pwd" placeholder="비밀번호" />
					<button type="button" class="go_login" onclick="loginFrm(document.loginForm)">로그인</button>
				</fieldset>
			</form>
			<div class="check_user">
				<a href="/page/member/id_lost.php">아이디 찾기</a>
				<a href="/page/member/password_lost.php">비밀번호 찾기</a>
				<a href="/page/member/register_form.php">회원가입</a>
			</div>
		</div>
	</div>
</div>
<!-- END warp -->
<script>
function loginFrm(frm){
	if(frm.id.value.trim() == ""){
		alert("아이디를 입력해주세요.");
		frm.id.focus();
		return;
	}
	if(frm.pwd.value.trim() == ""){
		alert("비밀번호를 입력해주세요.");
		frm.pwd.focus();
		return;
	}

	frm.submit();
}
</script>
<script type="text/javascript" src="js/common.js"></script>
</body>
</html>