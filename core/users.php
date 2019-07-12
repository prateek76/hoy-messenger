<?php

header('Content-Type: application/json');//this changes the way of content be treated

if (!isset($_GET['query'])) {
	echo json_encode([]);
	exit();
}

$db = new PDO('mysql:host=localhost;dbname=chat_app','root','');

$users = $db->prepare("
		SELECT user_id,username
		FROM users
		WHERE username LIKE :query
	");

$users->execute([
	'query' => "{$_GET['query']}%"
]);

echo json_encode($users->fetchAll());