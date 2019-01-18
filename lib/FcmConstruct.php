<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/function.php");
$message_string = "새로운 내용이 등록되었습니다.";
$message = array(
    "title"     => "공지사항이 왔어용~",
    "message"   => $message_string,
    "link"      => "http://polecare.xray21.com/page/s4/s1.php"
);
send_notification($tokens, $message);
?>