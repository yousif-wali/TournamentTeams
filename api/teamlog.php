<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
$name = $message = $created = array();
$teamName = $_REQUEST['teamName'];

$posts = mysqli_query($connect, "select * from teamLog where name = '$teamName' order by created desc");

$lists = " ";
if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;
   $lists .= '{"teamLog":[';
    while($row = mysqli_fetch_assoc($posts)){
        $name = $row['name'];
        $message = $row['message'];
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