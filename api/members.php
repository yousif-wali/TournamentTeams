<?php

header('Content-Type: application/json');
include_once "../data/data.php";

 
 $ids = $member = $team = $role = $points = $access = $owner = array();
$teamName = $_REQUEST['teamName'];

$posts = mysqli_query($connect, "select * from members where team = '$teamName' order by points desc");

$lists = " ";
if(mysqli_num_rows($posts) > 0){
   $limit = mysqli_num_rows($posts);
   $count = 0;
   $lists .= '{"members":[';
    while($row = mysqli_fetch_assoc($posts)){
        $ids = $row['id'];
        $member = $row["member"];
        $team = $row['team'];
        $role = $row['role'];
        $points = $row['points'];
        $access = $row['access'];
        $owner = $row['owner'];
        $list = json_encode(array( "id" =>$ids, "member"=>$member, "team"=>$team, "role"=>$role, "points"=>$points, "access"=>$access, "owner"=>$owner)); 
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