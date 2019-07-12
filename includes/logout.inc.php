<?php
require '../core/init.php';
if(isset($_POST['submit'])){
	session_start();
	$chat = new Chat();
	$uid = $_SESSION['u_id'];
	
	$sql = "UPDATE users SET status = 0 WHERE user_id = '$uid'";
    mysqli_query($conn,$sql);
    setcookie('username', "", time()+60*60*24*365, '/');
    setcookie('password', "", time()+60*60*24*365, '/');
	session_unset();
	session_destroy();

	//echo $_SESSION['u_id'];
	header("Location: ../index.php");
	//exit();
}