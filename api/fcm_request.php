<?php
include_once($_SERVER['DOCUMENT_ROOT']."/lib/db.conn.php");
session_start();
if($_POST['Token']){
    $sql = "update tbl_member set str_device_id='".$_POST['Token']."' where str_id='".$_SESSION['mb_id']."'";
    $db->query($sql);
}
?>