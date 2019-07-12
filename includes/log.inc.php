<?php
session_start();

    use Firebase\JWT\JWT;
    require '../core/init.php';

    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $cook = $_COOKIE['username'];
        $sql = "SELECT * FROM users WHERE username='$cook'";
        $result=mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1) {
            //header("Location: ../index.php?login=error");
            exit();
        } else if($row=mysqli_fetch_assoc($result)){
                if($_COOKIE['password'] == $row['password']){
                 //user loged in
                 //$row['status'] = true;
                 $sql = "UPDATE users SET status = 1 WHERE username = '$cook'";
                 mysqli_query($conn,$sql);
                 $_SESSION['u_id'] = $row['user_id'];
                 $_SESSION['username'] = $row['username'];
                 header("Location: ../chatbox.php?login=success");
                 exit();
            }
        }

} else {
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
             setcookie('u_id', $row['user_id'], time()+60*60*24*365, '/');
             setcookie('username', $_POST['username'], time()+60*60*24*365, '/');
             setcookie('password', $_POST['password'], time()+60*60*24*365, '/');
             $_SESSION['u_id'] = $row['user_id'];
             $_SESSION['username'] = $row['username'];
             header("Location: ../chatbox.php?login=success");
             exit();
        }
    }
}
