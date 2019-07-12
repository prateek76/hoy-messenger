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
     <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="style/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style_chat.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">


  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css">

  </head>
  <body>

  <div class="all-container">
    <div class="multi-container">
      <div class="users-container" style="overflow-x: hidden;overflow-y: hidden;overflow: hidden;">
        <div class="users-menu">

          <span class="menubt"><i class="fas fa-ellipsis-v menubt"></i></span>

        </div>
        <div class="opo" style="height:  45px;background: #000;">
            <ul style="display:  inline-flex;">
              <li class="Freinds" style="padding: 10px;width: 170px;color: #fff;border-bottom: 2px solid #fff;text-align:  center;">Freinds</li>
                <li class="Groups" style="padding:  10px;color: #fff;width: 174px;text-align: center;">Groups</li>
            </ul>
        </div>

        <div class="menuwillopen" style="display: none;">
          <ul class="menuwillopen-ul">
            <li class="menuwillopen-li" style="padding: 20px">Refresh</li>
            <li class="menuwillopen-li grnew" style="padding: 20px">New group</li>
            <li class="menuwillopen-li dissolve" style="padding: 20px">Dissolve</li>
          </ul>
        </div>
        <div class="gr" style="display: none;height: 585px;">
            <div class="create_group_parent" style="">
              <div class="create_group_sib" style="padding: 20px;background: #fff;">
                <div class="group_name">
                  <input type="text" class="group_name_val" placeholder="group name">
                </div>
                <div class="group_category">
                  <input type="text" class="group_category_val" placeholder="Category(optional)">
                </div>
                <div class="make-grp-new-btn" style="text-align: center;">
                 <div class="submit_group_init" name="action">
                  Create Group
                  </div>
                </div>
              </div>
            </div>
          </div>
        <ul style="background: #fff!important" class="users collection" style="overflow-x: hidden;overflow-y: hidden;">

        </ul>
        <ul style="display: none;height: 585px" class="showmygrp collection"></ul>
        <ul style="display: none;height: 585px" class="show_add_grp_options collection"></ul>
        <ul style="height: 585px;overflow-y: scroll;" class="group_details collection">
          <div class="group_details_header" style=""><b class="fill_groupname">Group Name</b></div>
          <div class="showMyFri"><ul class="collection showMyFri-list"></ul></div>
          <div>

          </div>
        </ul>

      </div>
        <div class="chat-container">
        <div class="chat_conn">
          <div class="to_name">
          <a href=""><span id="to" class="to" style="color: #fff;font-size: 20px"></span></a>
        </div>
          <div class="mess_age_s" id="mess_age_s">

          </div>

        <textarea class="mess_enter" style="" id="textarea1"placeholder=" Type a message"></textarea>

        <!--<form method="post" id="frm" enctype="multipart/form-data">
          <input type="file" name="file" id="file" class="inputfile">
          <label for="file"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
          <button type="submit" name="submit" class="btn btn-info send_my_file"><i class="fas fa-paper-plane"></i></button>
        </form>-->
        </div>
        </div>
    </div>
  </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery-ui.min.js"></script>
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
