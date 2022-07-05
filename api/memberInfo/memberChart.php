<?php
include_once "./../../data/data.php";
header("Content-Type: application/json");
$name = $_REQUEST['name'];

$infos = mysqli_query($connect, "select * from score_events where name = '$name'");
 
$score = $created = array();

$lists = " ";
if(mysqli_num_rows($infos) > 0){
   $limit = mysqli_num_rows($infos);
   $count = 0;
   $lists .= '{"scores":[';
    while($row = mysqli_fetch_assoc($infos)){
        $score = $row['score'];
        $created = $row['created'];

        // if (strlen($created) > 10){
        //     $created = substr($created, 0, 10);
        // }

        $list = json_encode(array("score" => (int) $score, "created" => $created)); 
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