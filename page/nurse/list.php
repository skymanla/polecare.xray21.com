<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$cur_page = (int)$_GET['cur_page'];
if($cur_page=="") $cur_page = 1; //페이지 번호가 없으면 1번 페이지

$sql = "select 
			a.*, 
			b.equiment_name, b.equiment_type, b.equiment_etc,
			c.chartnum, c.patient_name, c.patient_bandtype
			from 
			tbl_gatewayband a left join tbl_equiment b on a.gatewayid=b.equiment_macadd
			left join tbl_patient c on a.patient_seq=c.chartnum
			where outmat_status='2'
			order by regdate desc";

$query = $db->query($sql);
$cnt = $query->rowCount();


$limit_num = 10; //몇개씩 리스트에 보여줄 것인지
$offset_num = 10; //몇번 부터 시작할지
$show_offset_num = ($cur_page - 1) * $offset_num; //페이지마다 보여주는 리스트가 40개씩 갱신.

$board_no = $cnt - $show_offset_num;

$total_page = floor ( $cnt / $limit_num ) + 1;

$sql_list =  $sql." limit $show_offset_num, $limit_num";
$query = $db->query($sql_list);

?>
<section class="section1">
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
					foreach($query as $row){
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
						switch($row['outmat_status']){
							case "2":
								$outmat_status = "O";								
								break;
							case "1":
								$outmat_status = "X";
								break;
							default:
								$outmat_status = "-";
								break;
						}
				?>
				<tr>
					<td class="txt_c"><?=$board_no--?></td>
					<td class="txt_c"><?=$row['hospid']?></td>
					<td class="txt_c"><?=$row['equiment_etc']?></td>
					<td class="txt_c"><?=$row['patient_name']?></td>
					<td class="txt_c"><?=$inmat_status?></td>
					<td class="txt_c"><?=$outmat_status?></td>
					<td class="txt_c"><?=$row['regdate']?></td>
				</tr>
				<?php
					$board_no--;
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