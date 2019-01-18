<header>
	<h1><a href="/adm/page/s2/s1.php">폴케어</a></h1>
	<ul class="gnb">
		<li class="s5 <?php if($w_a_num===1){ echo 'active';}?>"><a href="/adm/page/s2/s1.php">환자관리</a></li>
		<li class="s13 <?php if($w_a_num===2){ echo 'active';}?>"><a href="/adm/page/s3/s1.php">사용자관리(앱)</a></li>
		<li class="s12 <?php if($w_a_num===3){ echo 'active';}?>"><a href="/adm/page/s4/s1.php">장비관리</a></li>
		<li class="s3 <?php if($w_a_num===4){ echo 'active';}?>"><a href="/adm/page/s5/s1.php">출입제한 이력관리</a></li>
		<li class="s1 <?php if($w_a_num===0){ echo 'active';}?>"><a href="/adm/page/s1/s1.php">관리자회원관리</a></li>
	</ul>
	<div class="sel_hospital">
		<?=$_SESSION['hospid']?>
	</div>
</header>