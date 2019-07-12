<?php

/*function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}*/

	

require 'init.php';
session_start();

$chat = new Chat();

	$file = $_FILES['file'];
	print_r($file);

	$send_id = $_GET['send_id'];
	echo $send_id;
	$fileName = $file['name'];
	$fileType = $file['type'];
	$fileTmpName = $file['tmp_name'];
	$fileError = $file['error'];
	$fileSize = $file['size'];

	$fileExt = explode('.', $fileName);
	

	$fileActualExt = strtolower($fileExt[1]);
	
	//$d = compress($fileTmpName, $fileTmpName, 20);
	$allowed = array('jpg','jpeg','png','gif','bmp','img');

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if($fileSize<100000000){
				$fileNewName = uniqid('',true).'.'.$fileActualExt;
				$fileDestination = '../uploads/'.$fileNewName;
				$urlto = 'localhost/localchatwa/letschatoneonone/uploads/'.$fileNewName;
				move_uploaded_file($fileTmpName, $fileDestination);
				$chat->throwMessages($_SESSION['u_id'], $send_id, $urlto);
				//header("Location: ../index.php?fileUpload==success");
				//print($send_id);
			}else{
				echo 'File is Too Big';
			}	
		}else{
			echo 'There Was An Error in Uploading File';
		}
	}else{
		echo 'Format Not Supported';
	}

