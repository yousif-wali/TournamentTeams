<?php 
ob_start();
include_once "./../../data/data.php";
include "./../event/log.php";
$name = $_REQUEST['name'];
$role = $_REQUEST['role'];
$team = $_REQUEST['team'];
mysqli_query($connect, "update members set role = '$role' where member = '$name'");
createLog($connect,$team, $name." role has been changed to ".$role." by the Owner of the team");
echo $name . $role . $team;
ob_flush();