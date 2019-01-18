<?php 
include_once '_inc/page.php';
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$sql = "select * from tbl_management where manage_id='".$_SESSION['manage_id']."'";
$query = $db->query($sql);

if($query->rowCount() == false){
	header("HTTP/1.1 400 Bad Request");
	exit;
}
$row = $query->fetch();
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
		<h1><a href="/adm"><i>폴스케어 관리자</i></a></h1>
		<ul class="gnb">
			<li class="s1"><a href="/adm/page/s1/s1.php">관리자회원관리</a></li>
			<li class="s5"><a href="/adm/page/s2/s1.php">환자관리</a></li>
			<li class="s13"><a href="/adm/page/s3/s1.php">사용자관리(앱)</a></li>
			<li class="s12"><a href="/adm/page/s4/s1.php">장비관리</a></li>
			<li class="s3"><a href="/adm/page/s5/s1.php">출입제한 이력관리</a></li>
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
				<dt>등급</dt><dd><?=$_SESSION['sAuth'] == "super" ? "최고관리자" : ""?></dd>
				<dt><a href="/adm/manage_modify.php">정보수정</a></dt>
			</dl>
		</div>
		<!-- <h2 class="title s11">고객센터 관리</h2>
		<ul class="lnb">
			<li class="active"><a href="javascript:void(0);">게시판1</a></li>
			<li><a href="javascript:void(0);">게시판2</a></li>
		</ul> -->
	</nav>
	<!-- END lng_wrap -->
	<!-- STR contents -->
	<section id="contents">
	<form name="manageForm" method="post">
		<input type="hidden" name="manage_id" value="<?=$row['manage_id']?>" />
		<div class="table_wrap1">
			<table>
				<caption>회원등록</caption>
				<colgroup>
					<col width="150">
					<col width="">
				</colgroup>
				<thead>
					<tr>
						<th colspan="4" class="txt_l">정보수정</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>이름</th>
						<td>
							<input type="text" class="w_input1" value="<?=$row['manage_name']?>" name="manage_name" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><?=$row['manage_id']?></td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>
							<input type="password" class="w_input1" value="" name="manage_pwd" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td>
							<input type="password" class="w_input1" value="" name="manage_pwd_confirm" placeholder="" style="width:300px"/>
						</td>
					</tr>
					<tr>
						<th>병원</th>
						<td>
							<input type="hidden" class="w_input1" value="<?=$row['manage_hospid']?>" name="manage_hospid" placeholder="" style="width:300px"/>
							<?=$row['manage_hospid']?>
						</td>
					</tr>
					<tr>
						<th>권한</th>
						<td>
							<?php
							if($_SESSION['sAuth'] == "super"){
								echo '<input type="hidden" name="manage_auth" value="super" />';
								echo "최고관리권한";
							}else{
								$sql = "select seq, auth_name from tbl_management_auth where seq='".$row['manage_auth']."'";
								$q = $db->query($sql);
								$v = $q->fetch();
							?>
							<input type="hidden" value="<?=$v['seq']?>" name="manage_auth" />
							<?=$v['auth_name']?>
							<?php
							}		
							?>
						</td>
					</tr>
					<tr>
						<th>등록일</th>
						<td><?=$row['regdate']?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="bt_wrap2">
			<a href="javascript:manageFrm(document.manageForm)" class="bt_1">수정</a>			
		</div>
	</form>						
</section>
<script>
function manageFrm(frm){
	if(frm.manage_name.value.trim() == "")	{
		alert("이름을 입력해주세요.");
		frm.manage_name.focus();
		return;
	}

	if(frm.manage_pwd.value.trim() != ""){
		if(frm.manage_pwd_confirm.value.trim() == ""){
			alert("비밀번호를 입력해주세요.");
			frm.manage_pwd_confirm.focus();
			return;
		}
	}

	if(frm.manage_hospid.value.trim() == ""){
		alert("병원아이디를 입력해주세요.");
		frm.manage_hospid.focus();
		return;
	}

	// if(frm.manage_auth.value.trim() == ""){
	// 	alert("권한을 선택해주세요.");
	// 	return;
	// }

	$.ajax({
		data: {"id": frm.manage_id.value.trim(), 
				"pwd": frm.manage_pwd.value.trim(),
				"name": frm.manage_name.value.trim(),
				"auth_seq": frm.manage_auth.value.trim(),
				"hospid": frm.manage_hospid.value.trim()},
		dataType: "json",
		type: "post",
		url: "/lib/manage/manage_update_id.php",
		success: function(r){
			alert(r.msg);
			if(r.code == "98"){
				history.back(-1);
			}
		}, error: function(){
			console.log('errrrrrrrr');
		}
	})
}
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>