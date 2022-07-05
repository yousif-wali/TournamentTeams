<?php
ob_start();
include_once "./data/data.php";
if(isset($_POST['signup'])){
    $fullname = mysqli_real_escape_string($connect, $_POST['fullname']);
    $email = mysqli_real_escape_string($connect, $_POST['email']); 
    $pwd = mysqli_real_escape_string($connect, $_POST['pwd']); 
    $phone = mysqli_real_escape_string($connect, $_POST['phone']); 
    $dob = mysqli_real_escape_string($connect, $_POST['dob']); 

    function hashing($e){
        $opts03 = [ "cost" => 15 ];
        return password_hash($e, PASSWORD_BCRYPT, $opts03);
     }

     $hashed = hashing($pwd);
    $checkEmail = mysqli_num_rows(mysqli_query($connect, "select * from members where email='$email'"));

    if($checkEmail > 0){
        header("Location: signup.php?err=emailexists");
    }else{
        mysqli_query($connect, "insert into members (member, email, pwd, phone, access, owner, dob) values ('$fullname', '$email', '$hashed', '$phone', 'n', 'n', '$dob')");
        header("Location: login.php");
    }
}
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $pwd = mysqli_real_escape_string($connect, $_POST['pwd']);
    $getEmail = mysqli_query($connect, "select * from members where email='$email'");
    $getPwd = mysqli_fetch_assoc($getEmail)['pwd'];
    if(mysqli_num_rows($getEmail) > 0){
        if(password_verify($pwd, $getPwd)){
            $memberSelect = mysqli_query($connect, "select * from members where email='$email'");
            $member = mysqli_fetch_assoc($memberSelect);
            session_start();
            $_SESSION['id'] = $member['id'];
            $_SESSION["member"] = $member['member'];
            $_SESSION['team'] = $member['team'];
            $_SESSION['owner'] = $member['owner'];
            header("Location: index.php");
        }else{
            header("Location: index.php?err=password");
        } 
    }else{
        echo "Email not verified";
    }
}

if(isset($_POST["logout"])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
}
ob_flush();
?>