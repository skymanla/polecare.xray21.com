<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>폴스케어 관리자</title>
	<link rel="stylesheet" type="text/css" href="/adm/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="/adm/css/layout.css" />
	<script type="text/javascript" src="/adm/js/common.js"></script>
	<script type="text/javascript" src="/adm/js/jquery-1.12.4.min.js"></script>
</head>
<body>
<!-- STR warp -->
<div id="win_pop">
	<div class="table_wrap1 no_line">
		<table>
			<caption>검색필터</caption>
			<colgroup>
				<col width="100">
				<col width="">
			</colgroup>
			<tbody>
				<tr>
					<th>이름</th>
					<td>
						<form method="post" action="">
							<input type="text" class="w_input1" value="" name="" style="width:280px">
							<button type="button" class="bt_s1 input_sel">검색</button>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table_wrap1 no_line">
		<table>
			<caption>검색필터</caption>
			<colgroup>
				<col width="100">
				<col width="">
			</colgroup>
			<tbody>
				<?php for($i=0;$i<10;$i++){?>
				<tr>
					<td><a href="javascript:void(0);" style="display:block;">홍길동</a></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>
<!-- END warp -->
</body>
</html>