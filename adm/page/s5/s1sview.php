<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
?>
<section class="section1">

	<div class="table_wrap1">
		<table>
			<caption>회원등록</caption>
			<colgroup>
				<col width="150">
				<col width="">
			</colgroup>
			<thead>
				<tr>
					<th colspan="4" class="txt_l">관리자회원수정</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>차트</th>
					<td>
						P0001
					</td>
				</tr>
				<tr>
					<th>환자명</th>
					<td>홍길동</td>
				</tr>
				<tr>
					<th>출입제한 이력</th>
					<td>
						1층 출입금지 구역
					</td>
				</tr>
				<tr>
					<th>등록일</th>
					<td>2018-10-15 11:30</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="bt_wrap2">
		<a href="javascript:void(0);" class="bt_2">삭제</a>
		<a href="s1.php"class="bt_2">목록</a>
	</div>
</section>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>