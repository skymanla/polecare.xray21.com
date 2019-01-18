<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");

$cur_page = (int) $_REQUEST['cur_page'];
if($cur_page=="") $cur_page = 1; //페이지 번호가 없으면 1번 페이지
$searchKey = (string) $_REQUEST['searchKey'];

$searchQuery = "";
if(!empty($searchKey)){
	$searchQuery = " and patient_name like '%".$searchKey."%' ";
}
$tbl = "tbl_patient";

$count_sql = "select count(*) as cnt from $tbl where delete_flag='0' and status='입원' ".$searchQuery;
$c_q = $db->query($count_sql);
$c_v = $c_q->fetch();
$cnt = $c_v['cnt'];

$limit_num = 10; //몇개씩 리스트에 보여줄 것인지
$offset_num = 10; //몇번 부터 시작할지
$show_offset_num = ($cur_page - 1) * $offset_num; //페이지마다 보여주는 리스트가 40개씩 갱신.

$board_no = $cnt - $show_offset_num;

$total_page = floor ( $cnt / $limit_num ) + 1;

$sql = "select * from $tbl where delete_flag='0' and status='입원' ".$searchQuery." order by seq desc limit $show_offset_num, $limit_num";
$query = $db->query($sql);

$list_flag = true;
if($query->rowCount() == "0"){
	$list_flag = false;
}
?>


<h2>환자검색</h2>
<button type="button" class="pop_close pop_cencle"></button>
<div class="con2">
	<div class="table_wrap1">
		<table>
			<caption>검색필터</caption>
			<colgroup>
				<col width="100">
				<col width="">
			</colgroup>
			<tbody>
				<tr>
					<th class="txt_c">이름</th>
					<td>
						<form name="patientSearchForm">
							<input type="text" class="w_input1" value="<?=$searchKey?>" name="searchKey" style="width:180px">
							<button type="button" class="bt_s1 input_sel" onclick="searchAjax()" >검색</button>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="table_wrap1">
		<table>
			<caption>회원 목록</caption>
			<colgroup>
				<col width="80">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>차트번호</th>
					<th>이름</th>
					<th>연령</th>
					<th>성별</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($list_flag == false){
						echo "<tr><td class='txt_c' colspan='5'>등록된 환자가 없습니다.</td></tr>";
					}else{
						foreach($query as $row){
				?>				
				<tr>
					<td class="txt_c"><?=$board_no--?></td>
					<td class="txt_c"><?=$row['chartnum']?></td>
					<td class="txt_c"><a href="javascript:addPatient('<?=$row["seq"]?>', '<?=$row["patient_name"]?>');"><?=$row['patient_name']?></a></td>
					<td class="txt_c"><?=$row['age']?></td>
					<td class="txt_c"><?=$row['sex'] == "m" ? "남자" : "여자"?></td>
				</tr>
				<?php 
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
			?>
			<a href="javascript:movePage('<?=$prev_page_num?>', '<?=$searchKey?>')" class="arr prev"><i>이전</i></a>
			<?php
			}

			for($i = $first_page_num; $i <= $total_page && $i <= $last_page_num; $i ++) {
				if ($cur_page == $i) {
				?>
					<a href="javascript:movePage('<?=$i?>', '<?=$searchKey?>')" class="active"><?=$i?></a>
				<?php					
				} else {
				?>
					<a href="javascript:movePage('<?=$i?>', '<?=$searchKey?>')"><?=$i?></a>
				<?php					
				}
				if ($i % 10 == 0 && $last_page_num != $total_page) {
					?>
					<a href="javascript:movePage('<?=$next_page_num?>', '<?=$searchKey?>')" class="arr next"><i>다음</i></a>
					<?php					
				}
			}
		?>
	</nav>
</div>

<script>
$(function(){
	$('.pop_cencle').on('click', function(e){
		$(this).parent().hide();
		$(this).parent().empty();
	})
})

function addPatient(seq, name){
	$('input[name=patient_seq]').val(seq);
	$('input[name=patient_name]').val(name);	

	$('#mem_search').hide();
	$('#mem_search').empty();
}
</script>