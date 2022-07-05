<?php
include_once "./../../data/data.php";
include "./../event/log.php";
$kick = $_REQUEST['kick'];

$team = $_REQUEST['team'];
$member = $_REQUEST['member'];
if(isset($kick)){
    mysqli_query($connect, "update members set team = 'Vacancy', role='Vacant' where member = '$kick'");
    createLog($connect, $team,$member." kicked out ".$kick." from team.");
}
