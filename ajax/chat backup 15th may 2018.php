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
        $users_grp = array($_SESSION['u_id']);
        $users_grp = implode('__', $users_grp);

        //part of users table
        $subscription_list = $chat->current_subscription($_SESSION['u_id']);
        $subscription_list = explode('__', $subscription_list[0]['group_subscription']);
        $subscription_list[sizeof($subscription_list)] = $group_id;
        $subscription_list = implode('__', $subscription_list);

        $admin_rights = $chat->getAdminRights($_SESSION['u_id']);
        print_r($admin_rights);
        $admin_rights = explode('__', $admin_rights[1]['admin_rights']);
        $admin_rights[sizeof($admin_rights)] = $group_id;
        $admin_rights = implode('__', $admin_rights);

        $chat->create_new_group($group_id,$group_name,$group_category,$constant,$users_grp,$created_by_name,$admin,$created_by_id,$_SESSION['u_id'], $subscription_list, $admin_rights);
        //update users table also
        echo "created group";
        return 0;//no use
        
    } else if ($method === 'add_new_member' && isset($_SESSION['u_id'])) {
        //make a check user is admin first
        //make a row after group subscription
        //scheck admin rights from users table as well as grup table
        /**
         * Test data 
         */
        $test_group = "Bwost8dlYgjLifNG(ygD";
        $group_id = $test_group;
        $user_id = 6;
        /**
         * Test data ends 
         */
        $ans = $chat->getAdminRights($_SESSION['u_id']);
        //print_r($ans);
        $ans = explode('__', $ans[0]['admin_rights']);
        
        $ifUserIsAdmin = 0;
        echo sizeof($ans);
        for ($i=0; $i < sizeof($ans); $i++) { 
            //check for a match
            echo $ans[$i];
            echo " ";
            if($ans[$i] === $group_id) {//make use of binary search
                $ifUserIsAdmin = 69;
                break;
            } /*else {
                echo "N0 AdmIn RigHtS1";
                return "N0 AdmIn RigHtS1";
            }*/
        }
        
        if ($ifUserIsAdmin == 69) {

            $subscription_list = $chat->current_subscription($user_id);
            //print_r($subscription_list);
            $subscription_list = explode('__', $subscription_list[1]['group_subscription']);
            $subscription_list[sizeof($subscription_list)] = $group_id;
            $subscription_list = implode('__', $subscription_list);

            $group_users = $chat->fetchgrpusers($group_id);
            //print_r($group_users);
            $group_users = explode('__', $group_users[2]['users_grp']);
            $group_users[sizeof($group_users)] = $user_id;
            $group_users = implode('__', $group_users);

            $noofusers = $chat->numberofusers($group_id);
            print_r($noofusers);
            //print_r($noofusers);
            $noofusers = $noofusers[3]['users_count'];
            $noofusers = $noofusers + 1;

            $chat->add_member_to_the_group($noofusers,$group_id,$group_users,$user_id);

            echo "added new user";
            return 0;//no use
        } else {
            return 0;//no use
        }

        //print_r($scf['admin_rights']);
    } else if ($method ==='fetchgroups' && isset($_SESSION['u_id'])) {
        $groups = $chat->getGroups($_SESSION['u_id']);
        //print_r($groups);
        $groups = explode('__', $groups[0]['group_subscription']);
        //print_r($groups);
        $pet = new Chat();
        for ($i=0; $i < sizeof($groups); $i++) { 
            if($groups[$i] != "") {
                //error_reporting(0);
                $tempdata = $pet->getDataFromGrpId($groups[$i]);
            }
        }

        $array = array();
                //print_r($tempdata);
        $lobe = 0;
        for ($k=0; $k < sizeof($tempdata); $k++) { 
            $usernane = new Chat();
            $tempo = explode('__', $tempdata[$k]['users_grp']);
            for ($j=0; $j < sizeof($tempo); $j++) {
                if($groups[$lobe] == ""){
                    $lobe++;
                }
                $tempdata[$k]['users'] = $usernane->getUserFromId($tempo[$j]);
            }
            $lobe++;
            //$array[$i] = null;
        }
        $group_all_data = array();
        $group_all_data['groupdetails_user'] = $tempdata;
        //echo json_encode($tempdata);
        //echo json_encode($array);
        echo json_encode($group_all_data);
    }
}