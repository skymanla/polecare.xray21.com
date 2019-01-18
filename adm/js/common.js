$(function(){
	$('.gnb').niceScroll();
	$('#lng_wrap').niceScroll();
});

function logincheck(){
	if (document.getElementById('id').value == ""){
		alert("아이디를 입력하세요.");
		document.getElementById('id').focus();
	}
	else if (document.getElementById('pw').value == ""){
		alert("비밀번호를 입력하세요.");
		document.getElementById('pw').focus();
	}
	else {
		var form = document.loginForm;
		form.method="post";
		form.action="/lib/login_proc.php";
		form.submit();
	}
}