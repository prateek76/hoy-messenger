<?php
  session_start();
  //$_SESSION['user'] = (isset($_GET['user']) === true) ? (int)$_GET['user'] : 0;
  //echo $_SESSION['u_id'];
  require 'core/init.php';

  $chat = new Chat();
  
  #echo '<pre>' , print_r($chat->fetchMessages()) , '</pre>';
  #$chat->throwMessages(3,"yup");
?>


<!doctype html>
<html>
  <head>
    <title>
      My Chat
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style_chat.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">


    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet"> 

  </head>
  <body>
    <nav class="navbar navbar-light" style="background-color: #009688;box-shadow: 0 0 4px #7f8c95;color: #fff;">
      <a class="navbar-brand">Let's Chat</a>
    <?php if(!isset($_SESSION['u_id'])){ 
      echo '
      <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Login & Register
  </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

    <form action="includes/log.inc.php" method="POST" class="form-inline my-2 my-lg-0">
        <div class="input-field inline" style="float: right;">
				  <input type="text" class="form-control mr-sm-2" name="username" id="email" style="outline: none;" placeholder="username"/>
        </div>
          <div class="input-field inline">
          <input type="password" id="pwd" class="form-control" name="password" style="outline: none;" placeholder="password"/>
        </div>
				<button  type="submit" class="btn btn-default" class="goandlogin" name="submit" style="margin-left: 5px;margin-top: 5px;">login</button>
        <a class="sign-up" href="signup.php" style="color: inherit;margin-top: 5px"><button class="btn btn-default" type="button" style="float: right;margin-left: 10px">sign up</button></a>
			</form>	
      </div>
      </div>
      ';
    }?>
     
      <?php
        if(isset($_SESSION['u_id'])){
          echo'
          <form action="index.php" method="get">
            <input type="text" class="bloodh" name="user" id="users">
            <input type="submit" class="blood" name="Go" value="Find Chatters">
          </form>
 
  
          <form action="includes/logout.inc.php" method="POST" class="form-inline my-2 my-lg-0">
          <button name="submit" type="submit" class="btn btn-danger getout" style="">Logout</button>
         </form>';
        }
      ?>
      
</nav>
  <div id="notification" class="notification">
    <div id="notify_child" class="notify_child">
      
    </div>
  </div>
  <div class="row content">
    <div class="col-sm-2 sidenav vertical" style="padding: 50px">
      <h3>All Users</h3>
      <div class="users">
        
      </div>
    </div>
    <div class="col-sm-8 text-left" style="padding-top: 30px;"> 
      <h3>Let's Chat</h3>
      <span style="margin-top: 50px;font-size: 22px;color: lightblue"><?php
        if(isset($_SESSION['u_id'])){
        echo "Welcomes, ";
        echo $_SESSION['username'];
        //echo " you are chatting with: ";
        }
      ?></span>
      <hr>
      
      
      <div class="chat_conn">
        <div class="to_name">
        <a href=""><span id="to" class="to" style="color: #fff;font-size: 22px"></span></a>
        <button type="button" class="close close-it" aria-label="Close" style="color: #fff;font-size: 28px">
          <span class="close-it" aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="mess_age_s" id="mess_age_s">

        </div>
        
      <textarea class="mess_enter materialize-textarea" id="textarea1"placeholder=" Hit Enter to send. Shift + return gives new line"></textarea>
      <form method="post" id="frm" enctype="multipart/form-data">
        <input type="file" name="file" id="file" class="inputfile">
        <label for="file"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
        <button type="submit" name="submit" class="btn btn-info send_my_file"><i class="fas fa-paper-plane"></i></button>
      </form>
      </div>
    </div>
      <div class="col-sm-2 sidenav vertical-left" style="padding: 50px;height: -webkit-fill-available;">
        <h3>online users</h3>
        <div class="all_online_users">
          
        </div>
    </div>
  </div>
  
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="jq/lazy.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="jq/chat.js"></script>
    <script src="jq/chat2.js"></script>
    <script type="text/javascript">
    /* var body = $('body');
      var colors =  ["#EAFAF1","#D5F5E3","#82E0AA","#82E0AA","#d2b4de","#58D68D","#28B463","#1D8348","#73C6B6","#73C6B6","#AED6F1"," #7d3c98","#ebdef0","#f5b7b1"];
      var currentIndex = 0;
      setInterval(function () {
         body.css({
           "background": colors[Math.floor(Math.random() * colors.length)]
         });
      }, 5000);*/

    </script>
  </body>
</html>