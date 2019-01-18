<?php
include_once '_inc/page.php'
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>폴케어 관리자</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
	<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
</head>
<body>
<!-- STR warp -->
<div id="wrap">
	<!-- STR header -->
	<header>
		<h1><a href="/adm/page/s2/s1.php"><i>폴스케어 관리자</i></a></h1>
		<ul class="gnb">
			<li class="s5"><a href="/adm/page/s2/s1.php">환자관리</a></li>
			<li class="s13"><a href="/adm/page/s3/s1.php">사용자관리(앱)</a></li>
			<li class="s12"><a href="/adm/page/s4/s1.php">장비관리</a></li>
			<li class="s3"><a href="/adm/page/s5/s1.php">출입제한 이력관리</a></li>
			<li class="s1"><a href="/adm/page/s1/s1.php">관리자회원관리</a></li>
		</ul>
	</header>
	<!-- END header -->
	<!-- STR lng_wrap -->
	<nav id="lng_wrap">
		<div class="member_wrap">
			<div class="m_info">
				<div class="name"><?=$_SESSION['manage_name']?></div>
				<a href="/lib/logoutProc.php">로그아웃</a>
			</div>
			<dl class="data">
				<dt>로그인 IP</dt><dd><?=$_SESSION['login_ip']?></dd>
				<dt>등급</dt><dd><?=$_SESSION['sAuth'] == "super" ? "최고관리자" : $_SESSION['auth_name']?></dd>
				<dt><a href="/adm/manage_modify.php">정보수정</a></dt>
			</dl>
		</div>
		<h2 class="title s11">고객센터 관리</h2>
		<ul class="lnb">
			<li class="active"><a href="javascript:void(0);">게시판1</a></li>
			<li><a href="javascript:void(0);">게시판2</a></li>
		</ul>
	</nav>
	<!-- END lng_wrap -->
	<!-- STR contents -->
	<section id="contents">
		<div class="headgroup1">
			<h2>고객센터 관리</h2>
			<nav>관리자 홈<span>/</span>고객센터 관리<span>/</span>게시판1</nav>
		</div>
		<div class="table_wrap1">
			<table>
				<caption>게시글 목록</caption>
				<colgroup>
					<col width="100">
					<col width="">
					<col width="140">
					<col width="140">
				</colgroup>
				<thead>
					<tr>
						<th>글번호</th>
						<th>제목</th>
						<th>이름</th>
						<th>작성일</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="txt_c">5</td>
						<td><a href="view.html">장비가 작동이 잘 안됩니다.</a></td>
						<td class="txt_c">환자이름5</td>
						<td class="txt_c">2018-00-00</td>
					</tr>
					<tr>
						<td class="txt_c">4</td>
						<td><a href="view.html">환자가 갈 수 있는 지역은 어디까지인가요?</a></td>
						<td class="txt_c">환자이름4</td>
						<td class="txt_c">2018-00-00</td>
					</tr>
					<tr>
						<td class="txt_c">3</td>
						<td><a href="view.html">어플은 어디서 받아야하나요?</a></td>
						<td class="txt_c">환자이름3</td>
						<td class="txt_c">2018-00-00</td>
					</tr>
					<tr>
						<td class="txt_c">2</td>
						<td><a href="view.html">고객센터 전화번호가 따로 있나요?</a></td>
						<td class="txt_c">환자이름2</td>
						<td class="txt_c">2018-00-00</td>
					</tr>
					<tr>
						<td class="txt_c">1</td>
						<td><a href="view.html">밴드가 자꾸 꺼져요</a></td>
						<td class="txt_c">환자이름1</td>
						<td class="txt_c">2018-00-00</td>
					</tr>
					</tr>
				</tbody>
			</table>
		</div>
		<nav class="paging_type1">
			<a href="javascript:void(0);" class="arr all_prev"><i>처음</i></a>
			<a href="javascript:void(0);" class="arr prev"><i>이전</i></a>
			<a href="javascript:void(0);" class="active">1</a>
			<a href="javascript:void(0);">2</a>
			<a href="javascript:void(0);">3</a>
			<a href="javascript:void(0);">4</a>
			<a href="javascript:void(0);">5</a>
			<a href="javascript:void(0);">6</a>
			<a href="javascript:void(0);">7</a>
			<a href="javascript:void(0);">8</a>
			<a href="javascript:void(0);">9</a>
			<a href="javascript:void(0);">10</a>
			<a href="javascript:void(0);" class="arr next"><i>다음</i></a>
			<a href="javascript:void(0);" class="arr all_next"><i>마지막</i></a>
		</nav>
	</section>
	<!-- END contents -->
</div>
<!-- END warp -->
<script type="text/javascript" src="js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</body>
</html>