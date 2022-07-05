<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <title><?php echo $_REQUEST['memberName'].' - '.$_REQUEST['teamName'];?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    @import "main.css";
    @import "../../main.css";
    </style>
</head>
<body>
  <?php include "./../../header.php"; ?>
    <div class="wrapper container">
    <h1 id="member"></h1>

    <?php 
        session_start();
       if($_SESSION['owner'] == 'y' && $_SESSION['team'] == $_REQUEST['teamName']){
        echo "<p id='role' onclick='changeRole(this)'>".$_REQUEST['role']."</p>
        <button id='changebtn' onclick='roles();' class='btn btn-primary' style='width:100px; display:none;'>Change</button>
        ";
        if( $_SESSION['member'] == $_REQUEST['memberName']){
          echo "<button class='btn btn-danger' style='width:100px;' onclick='leave()'>Leave</button>";
        }else{
          echo "<button class='btn btn-danger' style='width:100px;' onclick='kick()'>Kick</button>";
        }
      }else{
        echo "<p id='role'>".$_REQUEST['role']."</p>";
      }
    ?>

    <div id="charts">
    <canvas id="memberDemographic" class="col-lg-6 offset-0 col-sm-12"></canvas>
    <div id="teamMembers"></div>
    <canvas id="teamDemographic" class="col-lg-6 offset-0 col-sm-12"></canvas>
    </div>
    </div>
    <?php
    echo
    '<script>
    let teamName = "'.$_REQUEST['teamName'].'"
    let memberName = "'.$_REQUEST['memberName'].'"
    let role = "'.$_REQUEST['role'].'"
    let user = "'.$_SESSION['member'].'"
    </script>';
    // Use this sql to query the different time frame formats for chart.
    // select distinct created, sum(score) from score_events where name = "Yousif R. Wali" and created = "2022-07-01";
    //
    ?>

<table id="memberLog" data-type="memberLog" class="w3-table-all w3-hoverable" style="margin-bottom:1em; ">
          <caption>Member Log</caption>
      <thead>
          <tr>
              <th>Message</th><th>Date</th>
          </tr>
        </thead>
  <tbody data-type="memberLog"></tbody>
 </table>
 
 <div id="admin">
  <div class="container">
  <span onclick="this.parentNode.parentNode.style.display='none';">&times;</span>
  <div class="frame">
    <p>Please make one of your members as owner of the team before you leave.</p>
    <code>Who do you want to be the owner?</code>
    <div id="members"></div>
    <script>
      $.getJSON("./../../src/members.json", (data)=>{
        data.members.map((res)=>{
          if(res.team == teamName && res.role != "Owner"){
            document.getElementById("members").innerHTML += `
            <input type='radio' id='${res.member}' name='admin'><label for='${res.member}' onclick='chooseAdmin(this)'>${res.member}<i>${res.role}</i></label>
            `;
          }
        })
      });
      const chooseAdmin = (elem)=>{
        document.querySelectorAll("label.active").forEach((i)=>{
          i.classList.remove("active")
        })
        elem.classList.add("active");
      }
    </script>
    <button class="btn btn-danger" onclick="changeAdmin()">Leave</button>
  </div>
</div>
 </div>
    <script>
const changeAdmin = ()=>{
  id = document.querySelector("input[name='admin']:checked").id
  Swal.fire({
  title: `Do you want to make <u>${id}</u> the Owner?`,
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Yes',
  denyButtonText: `No`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    Swal.fire(`${id} has been promoted to Owner!!`, '', 'success')
    fetch("./leave.php?name="+id+"&cur="+memberName+"&team="+teamName).then(window.location.replace("./../../index.php"));
  } else if (result.isDenied) {
  }
})
}


document.getElementById("member").innerHTML = memberName + " - " + teamName;

let memberdates = [];
let memberscores = [];

fetch("./memberChart.php?name="+memberName).then(result=>result.json()).then((res)=>{res.scores.map((res, index)=>{
  memberdates[index]=res.created;
   memberscores[index]=res.score;
  })}).catch((err)=>{console.log(err)})
setTimeout(()=>{
new Chart("memberDemographic", {
  type: "line",
  data: {
    labels: memberdates,
    datasets: [{
      label:"Score",
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(100,200,50,1.0)",
      borderColor: "rgba(100,255,50,0.1)",
      data: memberscores
    }
],
  },
  options: {
    legend: {display: true},
    title:{
        display:true,
        text: "Member Statistics"
    }
  }
});
}, 100);
var xValues = [7,8,8,9,9,9,10,11,14,14,15];

var yValue = [,7,10,12,15,9,10,11,24,14,15];

new Chart("teamDemographic", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      label:"Wins",
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,255,0,1.0)",
      borderColor: "rgba(0,255,0,0.1)",
      data: yValue
    }
],
  },
  options: {
    legend: {display: true},
    title:{
        display:true,
        text: "Team Statistics"
    },/*
    scales: {
      yAxes: [{ticks: {min: 6, max:16}}],
    }*/
  }
});

let memberInfo = [];
$.getJSON("./../../src/members.json", (data)=>{
  let counter = 0;
  data.members.map((elem)=>{
    if(elem.team == teamName){
      let point = parseInt(elem.points);
      memberInfo.push([elem.member, point])
      counter++      
    }
  })
  if(counter == 2){
    memberInfo[2] = ["", 0];
  }
});
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {
  try{
var data = google.visualization.arrayToDataTable([
  ["Team", "Alpha"],
  memberInfo[0],
  memberInfo[1],
  memberInfo[2]
]);

var options = {
  title:'Team Scores',
  is3D:true
};

var chart = new google.visualization.PieChart(document.getElementById('teamMembers'));
  chart.draw(data, options);
}catch(err){
  document.getElementById('teamMembers').style.display = 'none';
}
}


// Member Log
const getTeamLogs = (name)=>{
            fetch(`./../memberLog.php?memberName=${name}`).then(result => result.json()).then((res)=>{
                res.memberLog.map((res)=>{
            document.querySelector("tbody[data-type=memberLog]").innerHTML += `
                <tr>
                <td>${memberName} Got ${res.message} points from ${res.name}.</td><td>${res.created}</td>
                </tr>
                `
                })
            }).catch((e)=>{
                document.querySelector("tbody[data-type=memberLog]").innerHTML = `
                <tr>
                <td>No messages</td><td>-</td>
                </tr>
                `
            })
         }
         getTeamLogs(memberName);
const changeRole = (elem)=>{
  if(teamName == "<?php echo $_SESSION['team'];?>"){
  if(role == "Owner"){
    console.log("Cannot change Role");
  }else{
    // Changin Role
    elem.setAttribute("contenteditable", "true");
    document.getElementById("changebtn").style.display="block";
  }
}else{
  console.log("Not your Team member!!");
}
}
const roles = ()=>{
  let newRole = document.getElementById("role").innerHTML
  fetch("./role.php?name="+memberName+"&role="+newRole+"&team="+teamName).then(window.location.replace("memberdemo.php?teamName="+teamName+"&memberName="+memberName+"&role="+newRole))
}
   
setTimeout(()=>{$("#memberLog").DataTable({
  searching: false,
});}, 100);

// Kick Players
   const kick = ()=>{
    Swal.fire({
  title: `Do you want to kick out <u>${memberName}</u>?`,
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Keep',
  denyButtonText: `Kick`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    
  } else if (result.isDenied) {
    Swal.fire(`${memberName} got kicked out of your team!!`, '', 'success')
    fetch("./kick.php?kick="+ memberName+"&member="+user+"&team="+teamName).then(window.location.replace("./../../index.php"));
  }
})
   }
   const leave = ()=>{
  document.getElementById("admin").style.display="flex"; 
  }
   </script>
</body>
</html>