<?php
session_start();
if(isset($_SESSION['member'])){
    header("Location: index.php");
}
?>
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
    <link rel="stylesheet" href="login.css" type="text/css">
    <title>Document</title>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="account">
       <form style="border:2px solid cyan" action="validateForm.php" method="post" autocomplete="off">
        <div>
        <p><u><b>With Us</b></u> Feel Secured</p>
        <i style="background-color: cyan"></i>
        </div>
        <div>
        <span>
        <input id="email" name="email" required type="text" onchange="change(this)" autofocus/>
        <label for="email">Email</label>
        </span>
        <span>
        <input id="password" name="pwd" required type="password" onchange="change(this)"/>
        <label for="password">Password</label>
        </span>
        <input name="login" type="submit" value="Login"/>
        <small>Don't have an account?<a href="signup.php">Create an Account.</a></small>
        </div>
       </form>
      </div>

      <script>
         function change(elem){
    let id = elem.getAttribute("id")
    let input = elem.value;
    if(elem.value.length > 0){
        document.querySelector('label[for='+id+']').classList.add("active");
        elem.classList.add("active")
    }else{
        document.querySelector('label[for='+id+']').classList.remove("active");
        elem.classList.remove("active")
    }
}
      </script>
</body>
</html>