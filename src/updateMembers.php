<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
 $ids = $member = $age = $team = $role = $points = $access = $owner = array();


$posts = mysqli_query($connect, "select * from members");

if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;
   $myfile = fopen("members.json", "w+") or die("Unable to open file!");
   fwrite($myfile, "{\n");

   fwrite($myfile, '"members":[');
      fwrite($myfile, "\n");
    while($row = mysqli_fetch_assoc($posts)){
        $ids = $row['id'];
        $member = $row["member"];
        $age = $row['age'];
        $team = $row['team'];
        $role = $row['role'];
        $points = $row['points'];
        $access = $row['access'];
        $owner = $row['owner'];

        $scoreOwner  = mysqli_query($connect, "select sum(score) as totalScore from score_events where name = '$member' ");
        $totalScore = mysqli_fetch_assoc($scoreOwner)['totalScore'];
        if(mysqli_num_rows($scoreOwner) > 0){
           mysqli_query($connect, "update members set points = '$totalScore' where member = '$member'");
        }        

        $list = json_encode(array( "id" =>$ids, "member"=>$member, "age"=>$age, "team"=>$team, "role"=>$role, "points"=>$points, "access"=>$access, "owner"=>$owner)); 
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