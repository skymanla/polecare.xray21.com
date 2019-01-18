<?php
try{
	$db = new PDO("mysql:host=localhost;dbname=polestarhc", "polestardb", "polestardb!@");
}catch(PDOException $e){
	echo 'Connect failed : '.$e->getMessage().'';
	return false;
}
?>