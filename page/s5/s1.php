<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_head.php');
?>

<div class="con_box2 mrb10">
	<div class="push_box">
		<div class="title_box">
			<h3>PUSH</h3>
			<div class="check_design1">
				<input type="checkbox" name="push_noti" id="check_push" onclick="pushNoti()" <?=$_SESSION['push'] == "Y" ? "checked": ""?> />
				<label for="check_push"><i>푸시설정</i></label>
			</div>
		</div>
		<div class="copy_box">
			<p class="copy1">
				아이폰의 경우 스마트폰 설정 > 알림에서 가능합니다.<br />
				어플 알림이 활성화 되어 있는지 확인해 주세요.
			</p>
		</div>
	</div>
</div>
<script>
function pushNoti(){
	$.ajax({
		url: "/lib/pushChg.php",
		data: {"pushVal": document.getElementById("check_push").checked, "id": "<?=$_SESSION['mb_id']?>"},
		type: "POST",
		success: function(r){
			
		}, error: function(){
			
		}
	})
}
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/_tail.php');?>