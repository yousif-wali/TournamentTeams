<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
 $ids = $name = $members = $totalWins = $totalLosses = $created = array();


$posts = mysqli_query($connect, "select * from teams");


if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;
   $myfile = fopen("Teams.json", "w+") or die("Unable to open file!");
   fwrite($myfile, "{\n");

   fwrite($myfile, '"teams":[');
      fwrite($myfile, "\n");

    while($row = mysqli_fetch_assoc($posts)){
        $name = $row['name'];
        $ids = $row['id'];
        $members = $row['members'];
        $totalWins = $row['total_wins'];
        $totalLosses = $row['total_losses'];
        $created = $row['created'];

        $scoreOwner  = mysqli_query($connect, "select * from members where team = '$name' ");
        $totalMembers = mysqli_num_rows($scoreOwner);
        if($totalMembers >= 0){
           mysqli_query($connect, "update teams set members = '$totalMembers' where name = '$name'");
        }        

        $list = json_encode(array("id" => $ids, "name" => $name, "members" => $members, "total_wins" => $totalWins, "total_losses" => $totalLosses, "created" => $created)); 
     $count++;
        fwrite($myfile, $list);
        
        if($count == $limit){

        }else{
         fwrite($myfile, ",");
        }
        fwrite($myfile, "\n");
      
      }
      
      fwrite($myfile, "]}");
      fclose($myfile);
}
mysqli_close($connect);
?>