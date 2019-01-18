<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_head.php');

include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");

$cur_page = (int)$_GET['cur_page'];
if($cur_page=="") $cur_page = 1; //페이지 번호가 없으면 1번 페이지

$searchType = $_GET['searchType'];
$searchKey = (string) $_GET['searchKey'];
$alertMent = "관리자 회원";

$searchQuery = "";
if(!empty($searchKey)){
	switch($searchType){
		case "name":
			$searchQuery = " and manage_name like '%".$searchKey."%' ";
			$checked = "name";
			break;
		case "id":
			$searchQuery = " and manage_id like '%".$searchKey."%' ";
			$checked = "id";
			break;
		case "hospid":
			$searchQuery = " and manage_hospid like '%".$searchKey."%' ";
			$checked = "hospid";
			break;
	}
}


$tbl = "tbl_management";
$count_sql = "select count(*) as cnt from $tbl where manage_id != 'admin' and delete_flag != 1 ".$searchQuery;
$c_q = $db->query($count_sql);
$c_v = $c_q->fetch();
$cnt = $c_v['cnt'];

$limit_num = 10; //몇개씩 리스트에 보여줄 것인지
$offset_num = 10; //몇번 부터 시작할지
$show_offset_num = ($cur_page - 1) * $offset_num; //페이지마다 보여주는 리스트가 40개씩 갱신.

$board_no = $cnt - $show_offset_num;

$total_page = floor ( $cnt / $limit_num ) + 1;

$sql = "select * from $tbl where manage_id != 'admin' and delete_flag != 1 ".$searchQuery." order by seq desc limit $show_offset_num, $limit_num";
$query = $db->query($sql);

$list_flag = true;
if($query->rowCount() == "0"){
	$list_flag = false;
}
?>
<section class="section1">

	<ul class="tab_type1">
		<li class="active"><a href="s1.php">운영자관리</a></li>
		<li><a href="s1stab1.php">권한설정</a></li>
	</ul>

	<div class="table_wrap1 no_line">
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
						<form method="get" name="searchForm" action="">
							<select name="searchType" class="w_input1">
								<option value="id" <?=$checked=="id" ? "selected" : "" ?>>아이디</option>
								<option value="name" <?=$checked=="name" ? "selected" : "" ?>>이름</option>
								<option value="hospid" <?=$checked=="hospid" ? "selected" : "" ?>>병원</option>
								<!-- <option value="">권한</option>
								<option value="">등록일</option> -->
							</select>
							<input type="text" class="w_input1" value="<?=$searchKey?>" name="searchKey" style="width:180px">
							<button type="button" class="bt_s1 input_sel" onclick="searchFrm(document.searchForm)" >검색</button>
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
				<col width="50">
				<col width="80">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="140">
			</colgroup>
			<thead>
				<tr>
					<th><input type="checkbox" class="" value="" name="" id="all_check" onclick="javascript:all_check();" /></th>
					<th>글번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>병원</th>
					<th>권한</th>
					<th>등록일</th>
					<th>정보</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($list_flag == false){
						echo "<tr><td class='txt_c' colspan='8'>등록된 관리자가 없습니다.</td></tr>";
					}else{
				?>
				<?php
					foreach($query as $row){
						$sql = "select seq, auth_name from tbl_management_auth where seq='".$row['manage_auth']."'";
						$a_q = $db->query($sql);
						$auth_name = "";
						if($a_q->rowCount() == false){
							$auth_name = "권한미부여";
						}else{
							$a_v = $a_q->fetch();
							$auth_name = $a_v['auth_name'];
						}
				?>
				<tr>
					<td class="txt_c"><input type="checkbox" class="rp_check_class" name="rp_check[]" value="<?=$row['seq']?>" /></td>
					<td class="txt_c"><?=$board_no?></td>
					<td class="txt_c"><?=$row['manage_id']?></td>
					<td class="txt_c"><?=$row['manage_name']?></td>
					<td class="txt_c"><?=$row['manage_hospid']?></td>
					<td class="txt_c"><?=$auth_name?></td>
					<td class="txt_c"><?=$row['regdate']?></td>
					<td class="txt_c"><a href="s1sview.php?id=<?=$row['manage_id']?>" class="bt_s1">정보수정</a></td>
				</tr>
				<?php
					$board_no--;
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="bt_wrap1">
		<div class="left_box">
			<button type="button" class="bt_1" onclick="javascript:modiy_stat('D', 'management')">선택삭제</button>
		</div>
		<div class="right_box">
			<button type="button" class="bt_1" onclick="location.href='s1swrite.php'">등록</button>
		</div>
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
<script>
function searchFrm(frm){
	frm.submit();
}
function all_check(){
	if($('#all_check').is(':checked')){
		$(".rp_check_class").prop("checked", true);
	}else{
		$(".rp_check_class").prop("checked", false);   
	}
}
function all_check_t(){
	$(".rp_check_class").prop("checked", true);
}
function all_check_f(){
	$(".rp_check_class").prop("checked", false);   
}
/* select delete start */
function modiy_stat(mode, type){
	if(mode=="D"){
		var chk_data = new Array()
		var chk_cnt = 0;
		var chkbox = $('.rp_check_class');

		for(var i=0;i<chkbox.length;i++){
			if(chkbox[i].checked == true){
				chk_data[chk_cnt] = chkbox[i].value;
				chk_cnt++;
			}
		}
		if(chk_data == ''){
			alert("삭제할 회원을 선택해 주세요.");
			return false;
		}
		$.ajax({
			type : 'POST',
			dataType: "json",
			url : '/lib/manage/manage_del_list.php',
			data : {"seq" : chk_data, "type": type},
			success : function(result){
				//console.log(result);
				alert("선택된 회원이 삭제되었습니다.");
				location.reload();
			}, error : function(jqXHR, textStatus, errorThrown){
				console.log("error!\n"+textStatus+" : "+errorThrown);
			}
		});
	}else{
		console.log('undefinded mode');
		return false;
	}
}
/* select delete end */
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/adm/_tail.php');
?>