<?php
include_once "./../../data/data.php";
include "./../event/log.php";

$promoted = $_REQUEST['name'];
$cur = $_REQUEST['cur'];
$team = $_REQUEST['team'];

session_start();
$_SESSION['team'] = "Vacancy";
$_SESSION['owner'] = "n";
mysqli_query($connect, "update members set team = 'Vacancy', owner = 'n', role='Vacant' where member = '$cur'");
mysqli_query($connect, "update members set role = 'Owner', owner = 'y' where member = '$promoted'");
createLog($connect, $team,$cur." promoted ".$promoted." to owner of the team and left.");
createLog($connect, "Vacancy ",$cur." has joined the team.");

