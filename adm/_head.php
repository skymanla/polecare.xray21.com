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
	<link rel="stylesheet" type="text/css" href="/adm/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="/adm/css/jquery-ui.min.css" />
	<script type="text/javascript" src="/adm/js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="/adm/js/jquery-ui.min.js"></script>
</head>
<body>
<!-- STR warp -->
<div id="wrap">
	<!-- STR header -->
	<?php include_once '_inc/header.php';?>
	<!-- END header -->
	<!-- STR lng_wrap -->
	<nav id="lng_wrap">
		<div class="member_wrap">
			<div class="m_info">
				<div class="name"><a herf="/adm/auth_member.php"><?=$_SESSION['manage_name']?></a></div>
				<a href="/lib/logoutProc.php">로그아웃</a>
			</div>
			<dl class="data">
				<dt>로그인 IP</dt><dd><?=$_SESSION['login_ip']?></dd>
				<dt>등급</dt><dd><?=$_SESSION['sAuth'] == "super" ? "최고관리자" : $_SESSION['auth_name']?></dd>
				<dt><a href="/adm/manage_modify.php">정보수정</a></dt>
			</dl>
		</div>
		<?php include_once '_inc/lnb'.$w_a_num.'.php';?>
	</nav>
	<!-- END lng_wrap -->
	<!-- STR contents -->
	<section id="contents">
		<div class="headgroup1">
			<h2><?php echo $w_s_title_1;?></h2>
			<!-- <nav>관리자 홈<span>/</span><?php echo $w_s_title_1;?><span>/</span><?php echo $w_s_title_2;?></nav> -->
			<nav>관리자 홈<span>/</span><?php echo $w_s_title_1;?><span></nav>
		</div>