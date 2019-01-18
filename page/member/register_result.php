<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/lib/function.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');

if(!$_SESSION) go_href("잘못된 접근입니다.", "/", "go");

$mb_name = $_SESSION['mb_name'];
$mb_id = $_SESSION['mb_id'];

// destory session
session_destroy();
unset($_SESSION);
?>

<div class="con_box1">
	<p class="copy_box1">
		<b><?=$mb_name?></b>님의 회원가입을 <br />
		진심으로 축하합니다.<br />
		가입하신 정보로 <br />
		로그인하신 후 이용 가능합니다.
	</p>
</div>
<div class="bt_box1">
	<button type="button" class="bt_01" onclick="location.href='/index.php'">로그인 바로가기</button>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>