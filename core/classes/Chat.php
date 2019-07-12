<?php

require('vendor/autoload.php');
use \Statickidz\GoogleTranslate;


                #--extra , was giving error
class Chat extends Core {
    public function fetchMessages(/*$send_id,$uid*/) {
        $this->query("
            SELECT      `chat`.`message`,
                        `chat`.`message_id`,
                        `users`.`username`,
                        `chat`.`send_id`,
                        `users`.`user_id`,
                        `chat`.`time`,
                        `chat`.`date`,
                        `chat`.`reacted`,
                        `chat`.`timestamp`,
                        `chat`.`seenunseen`,
                        `chat`.`senders_nameGRP`
            FROM        `chat`
            JOIN        `users`
            ON          `chat`.`user_id` = `users`.`user_id`
            ORDER BY    `chat`.`timestamp`
            /*DESC*/
        ");
        return $this->rows();
    }







    /****************
     * ************************
     *   group functions ***************
     * ************************
     * **************
     */

    public function getUserFromId($id) {
        //make sql query
        $this->query("
            SELECT      `users`.`username`
            FROM        `users`
            WHERE       `users`.`user_id` = '$id'
        ");
        return $this->rows();
    }

    /*same function as getadminrights
    public function isGroupAdmin($id) {
        //make sql query
        $this->query("
            SELECT      `users`.`admin_rights`
            FROM        `users`
            WHERE       `users`.`user_id` = '$id'
        ");
        return $this->rows();
    }*/

    public function current_subscription($id) {
        $this->query("
            SELECT      `users`.`group_subscription`
            FROM        `users`
            WHERE       `users`.`user_id` = '$id'
        ");
        return $this->rows();
    }

    public function fetchgrpusers($grpid) {
        $this->query("
            SELECT      `groups`.`users_grp`
            FROM        `groups`
            WHERE       `groups`.`group_id` = '$grpid'
        ");
        return $this->rows();
    }

    public function numberofusers($grpid) {
        $this->query("
            SELECT      `groups`.`users_count`
            FROM        `groups`
            WHERE       `groups`.`group_id` = '$grpid'
        ");
        return $this->rows();
    }

    public function getAdminRights($id) {
        $this->query("
            SELECT      `users`.`admin_rights`
            FROM        `users`
            WHERE       `users`.`user_id` = '$id'
        ");
        return $this->rows();
    }

    public function getGroups($id) {
        $this->query("
            SELECT      `users`.`group_subscription`
            FROM        `users`
            WHERE       `users`.`user_id` = '$id'
        ");
        return $this->rows();
    }

    public function getDataFromGrpId($grpid) {
        $this->query("
            SELECT      `groups`.`group_id`,
                        `groups`.`group_name`,
                        `groups`.`category`,
                        `groups`.`users_count`,
                        `groups`.`users_grp`,
                        `groups`.`created_by_name`,
                        `groups`.`admins`
            FROM        `groups`
            WHERE       `groups`.`group_id` = '$grpid'

        ");
        return $this->rows();
    }

    /*public function getDataFromGrpId($grpid) {
        $this->query("
            SELECT      *
            FROM        `groups`
            WHERE       `groups`.`group_id` = '$grpid'

        ");
        return $this->rows();
    }*/

    public function create_new_group($group_id,$group_name, $category, $users_count, $users_grp, $created_by_name, $admins, $created_by_id, $user_id, $subscription_list, $admin_rights) {
        //insert into db
        $this->query("
            INSERT INTO `GROUPS` (`group_id`,`group_name`,`category`,`users_count`,`users_grp`,`created_at`,`created_by_name`,`created_by_id`,`admins`)
            VALUES ('".$group_id."','" . $this->db->real_escape_string(htmlentities($group_name)) . "','". $this->db->real_escape_string(htmlentities($category)) ."',". (int)$users_count .",'" . $this->db->real_escape_string(htmlentities($users_grp)) . "',CURRENT_TIMESTAMP,'" . $this->db->real_escape_string(htmlentities($created_by_name)) . "',". (int)$created_by_id .",'" . $this->db->real_escape_string(htmlentities($admins)) . "')
        ");

        $this->query("
            UPDATE `USERS` SET `group_subscription` = '". $this->db->real_escape_string(htmlentities($subscription_list)) ."',
                               `admin_rights`       = '". $this->db->real_escape_string(htmlentities($admin_rights)) ."'
                                WHERE `user_id` = ". (int)$user_id ."
        ");

    }

    public function add_member_to_the_group($users_count, $group_id, $users_grp, $user_id,$subscription_list) {
        //statement
        $this->query("
            UPDATE `GROUPS` SET `users_count` = ". (int)$users_count .",
                                `users_grp`   = '". $this->db->real_escape_string(htmlentities($users_grp)) ."'
                                 WHERE `group_id` = '". $this->db->real_escape_string(htmlentities($group_id)) ."'
        ");

        $this->query("
            UPDATE `USERS` SET `group_subscription` = '". $this->db->real_escape_string(htmlentities($subscription_list)) ."'
                                WHERE `user_id` = ". (int)$user_id ."
        ");
    }

    /**
     * group functions end
     */









    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefg4549845798hiserg56jklmnopqrstsrgdfversfdgv^*aporla13%rfdsggfdrg^$^^(()sdhfuuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//use no underscore(__) ;):)//in random string //it is a spliter
        $charactersLength = strlen($characters);
        $rS = '';
        for ($i = 0; $i < $length; $i++) {
            $rS .= $characters[rand(0, $charactersLength - 1)];
        }
        return $rS;
    }



    public function fetchUsers() {
        $this->query("
            SELECT      `users`.`username`,
                        `users`.`user_id`
            FROM        `users`
        ");
        return $this->rows();
    }

    public function fetchOnlineUsers() {
        $this->query("
            SELECT      `users`.`username`,
                        `users`.`user_id`
            FROM        `users`
            WHERE       `status` = 1
        ");
        return $this->rows();
    }

    public function throwMessages($user_id,$send_id, $message) {
        //insert into db
        $this->query("
            INSERT INTO `CHAT` (`user_id`,`send_id`,`message`,`timestamp`,`time`,`date`)
            VALUES (" . (int)$user_id . "," . (int)$send_id . ",'". $this->db->real_escape_string(htmlentities($message)) ."',UNIX_TIMESTAMP(),CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)
        ");
    }
    //created by id is now, same as session id
    public function throwMessagesGRP($user_id,$send_id,$senders_nameGRP ,$message) {
        //insert into db
        $this->query("
            INSERT INTO `CHAT` (`user_id`,`send_id`,`senders_nameGRP`,`message`,`timestamp`,`time`,`date`)
            VALUES (" . (int)$user_id . ",'" . $send_id . "', '" . $this->db->real_escape_string(htmlentities($senders_nameGRP)) . "' ,'". $this->db->real_escape_string(htmlentities($message)) ."',UNIX_TIMESTAMP(),CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)
        ");
    }

    public function hashId($id) {
        //
    }

    public function hashIdCheck($id) {
        //
    }

    public function reply($message) {
        $source = 'en';
        $target = 'es';

        $trans = new GoogleTranslate();
        $result = $trans->translate($source, $target, $message);

        return $result;
    }

    public function delete($id) {
        $this->query("
            DELETE FROM `CHAT` WHERE `chat`.`message_id` = '$id';
        ");
    }
    //make use of jquery to call php post
    /*public function upload() {

            //$file = $_FILES['file'];

            $fileName = $file['name'];
            $fileType = $file['type'];
            $fileTmpName = $file['tmp_name'];
            $fileError = $file['error'];
            $fileSize = $file['size'];

            $fileExt = explode('.', $fileName);


            $fileActualExt = strtolower($fileExt[1]);


            $allowed = array('jpg','jpeg','pdf','bat','c','py');

            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0){
                    if($fileSize<100000000){
                        $fileNewName = uniqid('',true).'.'.$fileActualExt;
                        $fileDestination = '../../uploads/'.$fileNewName;
                        $urlto = 'http://localhost/letschatoneonone/uploads/'.$fileNewName;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $chat->throwMessages($_SESSION['u_id'], 6, $urlto);
                        header("Location: ../../index.php?fileUpload==success");

                    }else{
                        echo 'File is Too Big';
                    }
                }else{
                    echo 'There Was An Error in Uploading File';
                }
    }else{
                echo 'Format Not Supported';
            }

            }*/
}
