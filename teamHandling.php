<?php
include_once "./data/data.php";
include "./api/event/log.php";
session_start();   
    $id = $_SESSION['id'];
    $team = $_SESSION['team'];
    $member = $_SESSION['member'];
    $group = $_POST['group'];

if(isset($_POST['leave']) && $_POST['group']){
    if($group == "Vacancy"){
        header("Location: index.php");
    }else{
    mysqli_query($connect, "update members set team = 'Vacancy' where id = '$id'");
    mysqli_query($connect, "update members set role = 'Vacant' where id = '$id'");
    createLog($connect,''.$team.'', "".$member." has left the team.");
    createLog($connect,"Vacancy", "".$member." has joined the team.");

    $_SESSION['team'] = 'Vacancy';
    header("Location: index.php");
    }
}else{
    header("Location: index.php");
}
if(isset($_POST['join']) && $_POST['group']){
    if($_POST['groupNumber'] <= 0 && $group != 'Vacancy'){
        header("Location: index.php?team=full");
    }
    else{
    mysqli_query($connect, "update members set team = '$group' where id = '$id'");
    createLog($connect,''.$team.'', "".$member." has left the team.");
    createLog($connect,''.$group.'', "".$member." has joined the team.");
    $_SESSION['team'] = $group;
    header("Location: index.php");
    }
}else{
    header("Location: index.php");
}
?>