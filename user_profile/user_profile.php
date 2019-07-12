<?php
//work in progress
require '../core/init.php';
session_start();

$chat = new Chat();

$result = mysqli_query($conn, "SELECT * FROM users WHERE username='".$_GET['@id']."'");

$resultCheck= mysqli_num_rows($result);

if($resultCheck<1){
	header("Location: ../index.php?koi nahi hai bc");
    exit();
}

$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>
	<title>user</title>
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="../vendor/jquery/jquery.min.js"></script>
	<style type="text/css">
		table.table-profile tbody td {
			text-align: center;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-light" style="background-color: #009688;box-shadow: 0 0 4px #7f8c95;color: #fff;">
      <a class="navbar-brand" href="../index.php">Let's Chat</a>
      <?php
        if(isset($_SESSION['u_id'])){
          echo'
          <form action="../includes/logout.inc.php" method="POST" class="form-inline my-2 my-lg-0">
          <button name="submit" type="submit" class="btn btn-danger" style="">Logout</button>
         </form>';
        }
      ?>
      
</nav>
	<div class="jumbotron" style="background-color: #f3f3f3;">
	  <h1 class="display-4">Profile</h1>
	  <p class="lead"><?php echo $row['username']; ?></p>
	  <hr class="my-4">
<table class="table table-profile" style="width: 80%;background-color: #fff;margin: 0 auto">
  <tbody>
    <tr>
      <th scope="row">Username</th>
      <td><?php echo $row['username']; ?></td>
    </tr>
    <tr>
      <th scope="row">First Name</th>
      <td><?php echo $row['first_name']; ?></td>
    </tr>
    <tr>
      <th scope="row">Last Name</th>
      <td><?php echo $row['last_name']; ?></td>
    </tr>
    <tr>
      <th scope="row">mobile</th>
      <td><?php echo $row['mobile_number']; ?></td>
    </tr>
    <tr>
      <th scope="row">email</th>
      <td><?php echo $row['email']; ?></td>
    </tr>
  </tbody>
</table>
	</div>
</body>
</html>