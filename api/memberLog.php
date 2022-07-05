<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
$name = $message = $created = array();
$memberLog = $_REQUEST['memberName'];

$posts = mysqli_query($connect, "select * from score_events where name = '$memberLog' order by id desc");

$lists = " ";
if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;
   $lists .= '{"memberLog":[';
    while($row = mysqli_fetch_assoc($posts)){
        $name = $row['type'];
        $message = $row['score'];
        $created = $row['created'];
        $list = json_encode(array("name" => $name, "message" => $message, "created" => $created)); 
     $count++;
        $lists .= $list;
        
        if($count == $limit){

        }else{
         $lists .= ",";
        }
      
      }

        $lists .="]}";
}
echo $lists;
mysqli_close($connect);
?>