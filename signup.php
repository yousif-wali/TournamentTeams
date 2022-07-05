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
    <?php include "header.php";?>
    <div class="account">
            <form style="border: 2px solid orange" action="validateForm.php" method="post" autocomplete="off">
            <div>
            <p><u><b>With Us</b></u> Feel Secured.</p>
            <i style="background-color: orange"></i>
            </div>
            <div>
            <dialog open id="dialog"><code id="errmessage"></code> <span onclick="this.parentElement.style.display = 'none'">&times;</span></dialog>
            <span>
            <input id="fullname" name="fullname" required type="text" onchange="change(this)" data-input="fullname" autofocus/>
            <label for="fullname">Full Name</label>
            </span>
            <span>
            <input id="email" name="email" required type="email" onchange="change(this)" />
            <label for="email">Email</label>
            </span>
            <span>
            <input id="password" name="pwd" required  type="password" onchange="change(this)"  data-input="password"/>
            <label for="password">Password</label>
            </span>
            <span>
            <input id="phone" name="phone" type="tel" required pattern="^\d{3}-\d{3}-\d{4}$" onchange="change(this)" />
            <label for="phone">Phone</label>
            </span>
            <span>
            <input id="confirm-password" required type="password" onchange="change(this)"  data-input="confirm-password"/>
            <label for="confirm-password">Confirm Password</label>
            </span>
            <span>
            <input id="dob" name="dob" type="date" required  onchange="change(this)" />
            <label for="dob">Date of birth</label>
            </span>
            <input type="submit" name="signup" value="Sign up"/>
            <small><a href="login.php">Login</a> if you have an Account.</small>
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
      <?php

      switch($_REQUEST['err']){
        case "emailexists":
            echo '<script>
            document.getElementById("errmessage").innerHTML ="Email Already Exists!";
            document.getElementById("dialog").style.display = "block";
            </script>';
            break;
      }

      ?>
</body>
</html>