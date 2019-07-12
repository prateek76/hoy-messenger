<?php

//session_start();

$dbServername ="localhost";
$dbUsername ="root";//id2132237";
$dbPassword ="";//letschatapp_14505";
$dbName ="chat_app";//prateek_";

$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

define('LOGGED_IN',true);

require 'classes/core.php';
require 'classes/Chat.php';
