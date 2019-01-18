<?php
session_start();

if($_SESSION['LoginAuth'] == true){
	$url = "/adm";
}else{
	$url = "/";
}

unset($_SESSION);
session_destroy();

echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
exit;
?>