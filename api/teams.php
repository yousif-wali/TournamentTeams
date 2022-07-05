<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
 $ids = $name = $members = $totalWins = $totalLosses = $created = array();


$posts = mysqli_query($connect, "select * from teams");

$lists = " ";

if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;

   $lists .= '{"teams":[';

    while($row = mysqli_fetch_assoc($posts)){
        $name = $row['name'];
        $ids = $row['id'];
        $members = $row['members'];
        $totalWins = $row['total_wins'];
        $totalLosses = $row['total_losses'];
        $created = $row['created'];
        $list = json_encode(array("id" => $ids, "name" => $name, "members" => $members, "total_wins" => $totalWins, "total_losses" => $totalLosses, "created" => $created)); 
        
        $count++;
       $lists.=$list;
        
        if($count == $limit){

        }else{
         $lists .=",";
        }
      
      }
      
      $lists .="]}";
}
echo $lists;
mysqli_close($connect);
?>