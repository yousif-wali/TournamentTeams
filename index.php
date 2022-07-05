<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="main.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <title>FutureDev - Teams</title>
</head>
<body>
   <?php 
   session_start();
   include "header.php";
   ?>
    <main>
        <div id="teams">
            
        </div>
        <div id="group"></div>
    </main>
    <script src="loadTeam.js"></script>
    <script> 
     let teamReload = [];
        window.onload = function() {
            <?php 
                if(isset($_SESSION['member'])){
                echo 'let member = "'.$_SESSION['member'].'"; let team = "'.$_SESSION['team'].'";';}else{
                echo 'let member = ""; let team = "";';
                }?>
              
            const teams = document.getElementById("teams");
            fetch("./api/teams.php").then(res=>res.json()).then((result)=>{
               result.teams.map((res)=>{
                if(res.members == 0){
                    
                }else{
                if(res.name == team){
                    teamReload[0] = res.members;
                    teamReload[1] = res.total_wins;
                    teamReload[2] = res.total_losses;
                    teamReload[3] = res.created;
                }
                teams.innerHTML += `
                <div class="team" onclick="teamMembers('${res.name}','${member}', ${res.members}, ${res.total_wins}, ${res.total_losses}, '${res.created}')">
                <span>${res.name}</span>
                <code>${res.members}</code>
                <code class="status"><span style="color:blue">${res.total_wins}</span>|<span style="color:red">${res.total_losses}</span></code>
                <time>${res.created}</time>
                </div>
                `}
               })
            });
        }
        let countmembers = 0;
         const teamMembers = (groupName,currentMember, groupNumber, groupWins, groupLosses, groupCreated)=>{
             const groups = document.getElementById("group");
             fetch(`./api/members.php?teamName=${groupName}`).then((res)=>res.json()).then((result)=>{
                <?php 
                if(isset($_SESSION['member'])){
                echo 'let memberTeam = "'.$_SESSION['team'].'";';}else{
                echo 'let memberTeam = "";';
                }?>
                groups.innerHTML =    `
                    ${( currentMember && groupName == memberTeam)? "<form action='teamHandling.php' method='post'><input type='hidden' name='group' value='"+groupName+"'/><button name='leave'>Leave Team</button></form>":"<form action='teamHandling.php' method='post'><input type='hidden' name='groupNumber' value='"+groupNumber+"'/><input type='hidden' name='group' value='"+groupName+"'/><button name='join'>Join Team</button></form>"}
                     <h1>${groupName} Team</h1>
                     <div class="groupInfo">
                     <code>Member/s: ${groupNumber}</code>
                     <code>Total Win/s: ${groupWins}</code>
                     <code>Total Loss/es: ${groupLosses}</code>
                     <code>Creaded on: ${groupCreated}</code>
                     </div>
                     <hr/>
                     <table border="1" data-type="members" class="w3-table-all w3-hoverable">
                     <thead>
                     <tr class="w3-blue">
                     <th>Member Info</th><th>Role</th><th>Points</th>
                     </tr>
                     </thead>
                     <tbody data-type="members">
                     </tbody>
                     </table>

                     <table id="teamLog" data-type="teamLog" class="w3-table-all w3-hoverable">
                     <caption>Team Log</caption>
                     <thead>
                     <tr>
                     <th>Message</th><th>Date</th>
                     </tr>
                     </thead>
                     <tbody data-type="teamLog"></tbody>
                     </table>
                     `;
                 result.members.map((res)=>{
                    document.querySelector("tbody[data-type=members]").innerHTML += `
                        <tr onclick="memberDemo('${res.team}', '${res.member}', '${res.role}')" ${(currentMember == res.member)?"style='background-color:yellow'":""}>
                         <td>${res.member}</td><td>${res.role}</td><td>${res.points}</td>
                         </tr>`;
                 })
                 setTimeout(()=>{
         $("#teamLog").DataTable({
             searching: false,
             order: [ [ 1, 'desc' ]]
            });
        }, 50)
                 getTeamLogs(groupName);
             }).catch((err)=>{
                 groups.innerHTML = '<h1>The Group is Empty</h1><hr/>'+err.message;
             })
         }
         const getTeamLogs = (name)=>{
            fetch(`./api/teamLog.php?teamName=${name}`).then(result => result.json()).then((res)=>{
                res.teamLog.map((res)=>{
            document.querySelector("tbody[data-type=teamLog]").innerHTML += `
                <tr>
                <td>${res.message}</td><td>${res.created}</td>
                </tr>
                `
                })
            }).catch((e)=>{
                document.querySelector("tbody[data-type=teamLog]").innerHTML = `
                <tr>
                <td>No messages</td><td>-</td>
                </tr>
                `
            })
         }
         <?php 
         if(isset($_SESSION['member'])){
            echo 'setTimeout(()=>{teamMembers("'.$_SESSION['team'].'", "'.$_SESSION['member'].'", teamReload[0], teamReload[1], teamReload[2], teamReload[3]);}, 100);';
         }
         ?>
         setTimeout(()=>{
            let disableMoves = document.querySelectorAll("button[disabled]")
            if(disableMoves.length > 0){
               document.querySelectorAll("form[action='teamHandling.php'] input[type='hidden']").forEach((res)=>{
                    res.setAttribute("name", "groups");
                })
            }
         }, 100);

    </script>
</body>
</html>