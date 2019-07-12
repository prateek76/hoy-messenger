<?php
  session_start();
  //$_SESSION['user'] = (isset($_GET['user']) === true) ? (int)$_GET['user'] : 0;
  //echo $_SESSION['u_id'];
  require 'core/init.php';
  require_once('vendor/autoload.php');
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
     <!-- Compiled and minified CSS -->

    <!-- Compiled and minified JavaScript -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="style/index.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">


    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

  </head>
  <body>

      <div class="parent-container">
        <div class="logo-container">
          <div class="logo-logo">
            <img style="width: 200px;height: 200px;margin-left: 30px;margin-top: 0px;" src="style/lol.png">
          </div>
        </div>
        <div class="login-container">
          <div class="login-form">

            <form action="includes/logbsdk.php" method="POST" class="">
              <div class="">
                <input type="text" class="" name="username" id="email" style="" placeholder="username"/>
              </div>
                <div class="">
                <input type="password" id="pwd" class="" name="password" style="" placeholder="password"/>
              </div>
              <button  type="submit" class="goandlogin" name="submit" style="">login</button>
            </form>

          </div>
        </div>
      </div>

    <script src="vendor/jquery/jquery.min.js"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="jq/chat.js"></script>
    <script src="https://cdn.rawgit.com/twitter/typeahead.js/gh-pages/releases/0.10.5/typeahead.bundle.js"></script>
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
