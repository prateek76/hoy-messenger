<?php

if(isset($_POST['submit'])){
    include '../core/init.php';
    
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if(empty($username) || empty($password)) {
        header("Location: ../signup.php?signup=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck>0){
            header("Location: ../signup.php?signup=usertaken");
            exit();
        } else {//insert into db
            $sql = "INSERT INTO users (`username`,`password`) VALUES ('$username','$password');";
            mysqli_query($conn,$sql);
            header("Location: ../index.php?signup=success");
            exit();
        }
    }

} else {
	header("Location: ../signup.php");
	exit();
}