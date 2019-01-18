<?php
if($nurse_page == false){
?>
<header>
	<h1>폴케어</h1>
	<div class="pg_tit">
		<a href="javascript:history.back();"><i>이전</i></a>
		<h2><?php echo $w_s_title_1;?></h2>
	</div>
	<?php if($w_sub_name[2]!='member'){?>
	<div class="gnb">
		<a href="/page/s1/s1.php" <?php if($w_a_num==1){?>class="active"<?php } ?>>현재위치</a>
		<a href="/page/s2/s1.php" <?php if($w_a_num==2){?>class="active"<?php } ?>>환자관리</a>
		<a href="/page/s3/s1.php" <?php if($w_a_num==3){?>class="active"<?php } ?>>이력관리</a>
		<a href="/page/s4/s1.php" <?php if($w_a_num==4){?>class="active"<?php } ?>>마이페이지</a>
		<a href="/page/s5/s1.php" <?php if($w_a_num==5){?>class="active"<?php } ?>>설정</a>
	</div>
	<?php } ?>
</header>
<?php }else{ ?>
<header>
	<h1>폴케어</h1>
	<div class="gnb">
		<div style=" color:#666;font-size:100px; text-align:center;" id="clock">
		</div>
	</div>
</header>
<script>

$(function(){
	printClock();
})

function printClock() {
    
    var clock = document.getElementById("clock");            // 출력할 장소 선택
    var currentDate = new Date();                                     // 현재시간
    var calendar = currentDate.getFullYear() + "-" + (currentDate.getMonth()+1) + "-" + currentDate.getDate() // 현재 날짜
    var amPm = 'AM'; // 초기값 AM
    var currentHours = addZeros(currentDate.getHours(),2); 
    var currentMinute = addZeros(currentDate.getMinutes() ,2);
    var currentSeconds =  addZeros(currentDate.getSeconds(),2);
    
    if(currentHours >= 12){ // 시간이 12보다 클 때 PM으로 세팅, 12를 빼줌
    	amPm = 'PM';
    	currentHours = addZeros(currentHours - 12,2);
    }

    if(currentSeconds >= 50){// 50초 이상일 때 색을 변환해 준다.
       currentSeconds = '<span style="color:#de1951;">'+currentSeconds+'</span>'
    }
    clock.innerHTML = currentHours+":"+currentMinute+":"+currentSeconds +" <span style='font-size:50px;'>"+ amPm+"</span>"; //날짜를 출력해 줌
    
    setTimeout("printClock()",1000);         // 1초마다 printClock() 함수 호출
}

function addZeros(num, digit) { // 자릿수 맞춰주기
	  var zero = '';
	  num = num.toString();
	  if (num.length < digit) {
	    for (i = 0; i < digit - num.length; i++) {
	      zero += '0';
	    }
	  }
	  return zero + num;
}
</script>
<?php } ?>