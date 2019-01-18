<?php
include_once '_inc/page.php'
?>
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
		<h1><img src="img/common/logo.png" alt="폴스케어 관리자" /></h1>
		<form method="post" action="">
			<fieldset>
				<legend>로그인</legend>
				<div class="input_box">
					<label for="">ID</label>
					<select name="" title="">
						<option value="" selected="selected">병원선택</option>
						<option value="">병원1</option>
						<option value="">병원2</option>
						<option value="">병원3</option>
						<option value="">병원4</option>
						<option value="">병원5</option>
					</select>
				</div>
				<button type="button" onclick="location.href='/adm/page/s2/s1.php'">확인</button>
				<!-- <button type="button" onclick="location.href='/adm/page/s1/s1.php'">확인</button> -->
			</fieldset>
		</form>
	</div>
</div>
<!-- END warp -->
</body>
</html>