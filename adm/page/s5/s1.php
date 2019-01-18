<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$cur_page = (int)$_GET['cur_page'];
if($cur_page=="") $cur_page = 1; //페이지 번호가 없으면 1번 페이지

$tbl = "tbl_gatewayband";
$count_sql = "select count(*) as cnt from $tbl where 1";
$c_q = $db->query($count_sql);
$c_v = $c_q->fetch();
$cnt = $c_v['cnt'];

$limit_num = 10; //몇개씩 리스트에 보여줄 것인지
$offset_num = 10; //몇번 부터 시작할지
$show_offset_num = ($cur_page - 1) * $offset_num; //페이지마다 보여주는 리스트가 40개씩 갱신.

$board_no = $cnt - $show_offset_num;

$total_page = floor ( $cnt / $limit_num ) + 1;

$sql = "select * from $tbl where 1 order by seq desc limit $show_offset_num, $limit_num";
$query = $db->query($sql);

$list_flag = true;
if($query->rowCount() == "0"){
	$list_flag = false;
}
?>
<section class="section1">
	<!-- <div class="table_wrap1 no_line">
		<table>
			<caption>검색필터</caption>
			<colgroup>
				<col width="100">
				<col width="">
			</colgroup>
			<tbody>
				<tr>
					<th>검색필터</th>
					<td>
						<form method="post" action="">
							<input type="text" class="w_input1" id="date1_start" value="" name="" placeholder="시작일" style="width:180px"> ~ 
							<input type="text" class="w_input1" id="date1_end" value="" name="" placeholder="종료일" style="width:180px">
							&nbsp;&nbsp;
							<select name="" class="w_input1">
								<option value="">차트</option>
								<option value="">환자명</option>
								<option value="">출입제한 이력</option>
							</select>
							<input type="text" class="w_input1" value="" name="" style="width:180px">
							<button type="button" class="bt_s1 input_sel" >검색</button>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div> -->

	<div class="table_wrap1">
		<table>
			<caption>출입제한이력 목록</caption>
			<colgroup>
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
			<thead>
				<tr>
					<th>일련번호</th>
					<th>병원명</th>
					<th>위치</th>
					<th>환자이름</th>
					<th>안쪽매트</th>
					<th>바깥쪽매트</th>
					<th>현재시간</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($list_flag == false){
						echo "<tr><td class='txt_c' colspan='13'>Not Data.</td></tr>";
					}else{
				?>
				<?php
					foreach($query as $row){
						$sql = "select * from tbl_equiment where equiment_macadd='".$row['gatewayid']."'";
						// echo $sql;
						$q = $db->query($sql);
						$equiment = $q->fetch();

						$sql = "select * from tbl_patient where chartnum='".$row['patient_seq']."'";
						$q = $db->query($sql);
						$patient = $q->fetch();

						switch($row['inmat_status']){
							case "2":
								$inmat_status = "O";
								break;
							case "1":
								$inmat_status = "X";
								break;
							default:
								$inmat_status = "-";
								break;
						}

						$span_red = '';
						switch($row['outmat_status']){
							case "2":
								$outmat_status = "O";
								$span_red = 'style="color:red"';
								break;
							case "1":
								$outmat_status = "X";
								break;
							default:
								$outmat_status = "-";
								break;
						}
				?>
				<tr <?=$span_red?>>
					<td class="txt_c"><?=$board_no?></td>
					<td class="txt_c"><?=$row['hospid']?></td>
					<td class="txt_c"><?=$equiment['equiment_etc']?></td>
					<td class="txt_c"><?=$patient['patient_name']?></td>
					<td class="txt_c"><?=$inmat_status?></td>
					<td class="txt_c"><?=$outmat_status?></td>
					<td class="txt_c"><?=$row['regdate']?></td>
				</tr>
				<?php
					$board_no--;
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<nav class="paging_type1">
	<?php 
			$first_page_num = (floor ( ($cur_page - 1) / 10 )) * 10 + 1; // 1,11,21,31...
			$last_page_num = $first_page_num + 9; // 10,20,30...last
			$next_page_num = $last_page_num + 1;
			$prev_page_num = $first_page_num - 10;

			if ($first_page_num != 1) { // It's not first page
				echo "<a href='?cur_page=$prev_page_num' class='arr prev'><i>이전</i></a>\n";
			}

			for($i = $first_page_num; $i <= $total_page && $i <= $last_page_num; $i ++) {
				if ($cur_page == $i) {
					echo "<a href='?cur_page=$i' class='active'>$i</a>\n"; // Current page
				} else {
					echo "<a href='?cur_page=$i'>$i</a>\n";
				}
				if ($i % 10 == 0 && $last_page_num != $total_page) {
					echo "<a href='?cur_page=$next_page_num' class='arr next'><i>다음</i></a>";
				}
			}
			?>
	</nav>
</section>


<script type="text/javascript" src="/adm/js/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
	var dateFormat = 'yy-mm-dd';
	var from = $('#date1_start').datepicker({
		dateFormat: dateFormat,
		defaultDate: '+1w',
		changeMonth: true,
		numberOfMonths: 1
	}).on( 'change', function() {
		to.datepicker( 'option', 'minDate', getDate( this ) );
	});
	var to = $('#date1_end').datepicker({
		dateFormat: dateFormat,
		defaultDate: '+1w',
		changeMonth: true,
		numberOfMonths: 1
	}).on( 'change', function() {
		from.datepicker( 'option', 'maxDate', getDate( this ) );
	});

	function getDate( element ) {
		var date;
		try {
			date = $.datepicker.parseDate( dateFormat, element.value );
		} catch( error ) {
			date = null;
		}
		return date;
	}
});

//]]>
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>