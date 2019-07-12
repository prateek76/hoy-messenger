<?php
require '../core/init.php';
session_start();

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

        if(empty($users) === true) {
            echo "there are no users";
        } else {
                ?>
                <!--html goes here-->
                    <div class="onusers">
                        <ul class="all_users  list-group">
                            <?php
                            if(isset($_SESSION['u_id']))
                            {
                                foreach ($users as $user) {
                                    if($user['user_id'] != $_SESSION['u_id']) {
                                ?><li class="user_unique list-group-item" id="user_unique" user_unique_id="<?php echo $user['user_id'] ?>"><?php echo $user['username']?></li>
                                <?php }}?><?php
                            } else {
                            foreach ($users as $user) {
                            ?><a href="http://localhost/lets%20chat%20oneonone/user_profile/user_profile.php?@id=<?php echo $user['username'] ?>"><li class="user_unique list-group-item" id="user_unique"><?php echo $user['username']?></li></a>
                            <?php }?>
                            <?php } ?>
                        </ul>
                    </div>
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
        $cnt = 0;
        if(empty($messages) === true) {
            echo 'There are currently no messages';
        } else {
            ?> <ul class="message"> <?php
            foreach($messages as $message) {#close php here and give html tags.
                if ($message['user_id'] == $_SESSION['u_id'] && $message['send_id'] == $send_id) {
                    $cnt++;
                ?>

                    
                        <li class="message-mes-sess"><?php echo $message['message']; ?>
                            <?php 
                                    if ($message['reacted'] == 1) {?>
                                        <i class="fas fa-thumbs-up"></i>
                                        <?php
                                    } else if ($message['reacted'] == 2) {?>
                                        <i class="fas fa-thumbs-down"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 3) {?>
                                        <i class="far fa-smile"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 4) {?>
                                        <i class="fas fa-frown"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 5) {?>
                                        <i class="fas fa-heart"></i>
                                        <?php
                                    }
                                 ?>
                            <div class="time-mes-sess"><?php echo $message['time']; ?></div>
                        </li>
                    <?php }
                    else if($message['send_id'] == $_SESSION['u_id'] && $message['user_id'] == $send_id) {
                        $cnt++;
                    ?>

                            <li class="message-mes"><?php echo $message['message']; ?>
                                <?php 
                                    if ($message['reacted'] == 1) {?>
                                        <i class="fas fa-thumbs-up"></i>
                                        <?php
                                    } else if ($message['reacted'] == 2) {?>
                                        <i class="fas fa-thumbs-down"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 3) {?>
                                        <i class="far fa-smile"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 4) {?>
                                        <i class="fas fa-frown"></i>
                                        <?php
                                    }
                                    else if ($message['reacted'] == 5) {?>
                                        <i class="fas fa-heart"></i>
                                        <?php
                                    }
                                 ?>
                                <div class="time-mes"><?php echo $message['time']; ?></div>
                                <div class="react-menu-open" style="display: "><i class="fas fa-bars"></i></div>
                                <div class="react-menu" style="display: none;">
                                    <ul class="react-menu-ul">
                                        <li class="react-menu-ul-li thumbs-up" message_alt_id="<?php echo $message['timestamp'] ?>" message_id="<?php echo $message['message_id'] ?>"><i class="fas fa-thumbs-up tu"></i></li>
                                        <li class="react-menu-ul-li thumbs-down" message_alt_id="<?php echo $message['timestamp'] ?>" message_id="<?php echo $message['message_id'] ?>"><i class="fas fa-thumbs-down td"></i></li>
                                        <li class="react-menu-ul-li smile" message_alt_id="<?php echo $message['timestamp'] ?>" message_id="<?php echo $message['message_id'] ?>"><i class="far fa-smile sm"></i></li>
                                        <li class="react-menu-ul-li frown" message_alt_id="<?php echo $message['timestamp'] ?>" message_id="<?php echo $message['message_id'] ?>"><i class="fas fa-frown fr"></i></li>
                                        <li class="react-menu-ul-li heart" message_alt_id="<?php echo $message['timestamp'] ?>" message_id="<?php echo $message['message_id'] ?>"><i class="fas fa-heart hr"></i></li>
                                    </ul>
                                </div>
                            </li>
                    <?php }
            }
            ?></ul><?php
        }

    } else if ($method === 'throw' && isset($_POST['message']) === true) {
        //throw messages into database
        $message = trim($_POST['message']);
        $send_id = $_POST['send_id'];
        if(empty($message) === false) {
            //throw it
            $chat->throwMessages($_SESSION['u_id'], $send_id, $message);//error here
        }

    } 
    //when method == notification_react
    elseif ($method === 'notify_react' && isset($_SESSION['u_id'])) {
        //
        $send_id = $_POST['send_id'];
        $messages = $chat->fetchMessages(/*$send_id,$_SESSION['u_id']*/);
        //print_r($messages);
        $cnt = 0;
        if(empty($messages) === true) {
            echo 'There are currently no messages';
        } else {
            ?> <ul class="message"> <?php
            foreach($messages as $message) {#close php here and give html tags.
                if ($message['user_id'] == $_SESSION['u_id']) {
                    $cnt++;
                ?>
                <li class="message-mes-sess"><?php echo $message['message']; ?></li>
                    <?php }}}
    }
}