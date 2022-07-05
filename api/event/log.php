<?php 
function createLog($link,$team, $message){
 mysqli_query($link, "insert into teamlog (name, message) values ('$team', '$message')");
}
?>