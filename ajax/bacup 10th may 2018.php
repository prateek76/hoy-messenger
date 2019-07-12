<?php
require '../core/init.php';
session_start();

//$_SESSION['u_id'] = 5;
//$_SESSION['username'] = "admin";

$chat = new Chat();
if(isset($_POST['method']) === true && empty($_POST['method']) === false) {

    $chat       = new Chat();
    $method     = trim($_POST['method']);

    if($method === 'update_reacted') {
        $message_id = $_POST['message_id'];
        $reacted_val = $_POST['reacted_val'];
        $timestamp = $_POST['message_alt_id'];
        echo $message_id;
        $sql = "UPDATE chat SET reacted = '$reacted_val' WHERE message_id = '$message_id' AND `timestamp` = '$timestamp'";
        mysqli_query($conn,$sql);
    }

    //show online users
    if ($method === 'online_users') {
        $onlineusers = $chat->fetchOnlineUsers();
        if(empty($onlineusers) === true) {
            echo "there are currently no online users";
        } else {
                ?>
                <!--html goes here-->
                    <div class="online_status">
                        <ul class="online_users">
                            <?php
                            foreach ($onlineusers as $Ouser) {
                            ?><li class="onuser"><p><?php echo $Ouser['username']?></p></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php
            }
    }

    //show users
    if ($method === 'users') {
        //show all users
        $users = $chat->fetchUsers();
        $messages = $chat->fetchMessages();

        if(empty($users) === true) {
            echo "there are no users";
        } else {
                ?>
                            <?php
                            if(isset($_SESSION['u_id']))
                            {
                                //username
                                //last message fronthend me
                                //user_id
                                $friends = array();
                                foreach ($users as $user) {
                                    if($user['user_id'] != $_SESSION['u_id']) {
                                        $user__unique__id = "xs3__counter__user__69";
                                        $username         = "xs3__counter__user__96";
                                        $friends[] = array($user__unique__id => $user['user_id'],$username => $user['username']);
                                ?>
                                <?php }}
                                echo json_encode($friends);
                                ?>
                                <?php
                            }  ?>
                <?php
            }
        }
        //unsecure make it secure after mains 8th april
        //messageid ko hash karke fronthend me daalo
        //safe hoga
        //sha 256
        //all id in fronthend should be hashed and use two level check
        //reated rule
        //0 == no reaction
        //1 == liked
        //2 == disliked
        //3 == smile
        //4 == sad
        //5 == heart
        //bakki apnii maa chudaye
    if($method === 'fetch' && isset($_SESSION['u_id'])) {
        //fetch messages and output
        $send_id = $_POST['send_id'];
        $messages = $chat->fetchMessages(/*$send_id,$_SESSION['u_id']*/);
        //print_r($messages);
        $row = array();
        $cnt = 0;
        if(empty($messages) === true) {
            echo 'There are currently no messages';
        } else {
            foreach($messages as $message) {
                error_reporting(0);
                if ($message['user_id'] == $_SESSION['u_id'] && $message['send_id'] == $send_id) {
                    $cnt++;
                    //$data .= '{"message":'.print $message['message'].',"sendto":'.print $message['user_id'].'},';
                    $row[] = $message;
                } else if ($message['send_id'] == $_SESSION['u_id'] && $message['user_id'] == $send_id) {
                    $row[] = $message;
                }
            }
            echo json_encode( $row );
        }

    } else if ($method === 'throw' && isset($_POST['message']) === true) {
        //throw messages into database
        $message = trim($_POST['message']);
        $send_id = $_POST['send_id'];
        if(empty($message) === false) {
            //throw it
            $chat->throwMessages($_SESSION['u_id'], $send_id, $message);//error here
        }

    } else if ($method === 'change_to_zero' && isset($_SESSION['u_id'])) {
        $send_id = $_POST['send_id'];
        $sess = $_SESSION['u_id'];
        $sql = "UPDATE chat SET seenunseen = 1 WHERE user_id = '$send_id' AND send_id = '$sess'";
        mysqli_query($conn,$sql);
    } else if ($method === 'userinfo' && isset($_SESSION['u_id'])) {
        echo $_SESSION['u_id'];
    } else if ($method === 'isuserloggedin') {
        if (isset($_SESSION['u_id'])) {
            echo "go ahead";
        } else {
            echo "restricted";
        }
    } else if ($method === 'create_new_group' && isset($_SESSION['u_id'])) {
        $group_name = $_POST['group_name'];
        $group_category = $_POST['group_category'];
        $created_by_id = $_SESSION['u_id'];
        $created_by_name = $_SESSION['username'];
        $group_id = $chat->generateRandomString();
        //also make a check if no such string is present in database

        $admin = array($_SESSION['u_id']);
        $admin = implode('__', $admin);
        $constant = 1;
        $users_grp = array($_SESSION['username']);
        $users_grp = implode('__', $users_grp);

        $chat->create_new_group($group_id,$group_name,$group_category,$constant,$users_grp,$created_by_name,$admin,$created_by_id);
        
    } else if ($method === 'add_new_member' && isset($_SESSION['u_id'])) {
        //make a check user is admin first
        //make a row after group subscription
        $ans = $chat->isGroupAdmin($_SESSION['u_id']);
        $ans = explode('__', $ans[0]['admin_rights']);
        for ($i=0; $i < sizeof($ans); $i++) { 
            echo $ans[$i];
            echo " ";
        }
        $test_group = "uq9XfSbFGglve5e4(%8q";
        $group_id = $test_group;
        $user_id = 6;
        //print_r($scf['admin_rights']);
        $chat->add_member_to_the_group(56,$group_id,"many",$user_id);
    }
}