<?php
session_start();
use Firebase\JWT\JWT;

if(isset($_POST['method']) === true && empty($_POST['method']) === false) {
    $method     = trim($_POST['method']);
    if($method === 'loginnow') {
    require '../core/init.php';
    
    $uid=mysqli_real_escape_string($conn,$_POST['username']);
    $pwd=mysqli_real_escape_string($conn,$_POST['password']);
    
    //not checking for errors

    $sql = "SELECT * FROM users WHERE username='$uid'";
    $result=mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck < 1) {
        //header("Location: ../index.php?login=error");
        exit();
    }else if($row=mysqli_fetch_assoc($result)){
            if($pwd == $row['password']){
             //user loged in
             //$row['status'] = true;
             $sql = "UPDATE users SET status = 1 WHERE username = '$uid'";
             mysqli_query($conn,$sql);
             $_SESSION['u_id'] = $row['user_id'];
             $_SESSION['username'] = $row['username'];

             echo "loggin__success";
             exit();
        }
    }
}
}