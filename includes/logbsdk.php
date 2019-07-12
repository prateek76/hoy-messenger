<?php
session_start();
	require_once('../vendor/autoload.php');
    use \Firebase\JWT\JWT;
    require '../core/init.php';

    if (isset($_COOKIE['Waste'])) {
        $cook = $_COOKIE['Waste'];

        $decoded = JWT::decode($cook, "2002__solo__DeadMenTellNoLie__AMillionDreams__TheGreatestShow", array('HS512'));
        $xyz = ((array)$decoded);
        $XyZ = ( (array)$xyz['data'] );
        $username = $XyZ['username'];
        $password = $XyZ['password'];
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result=mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1) {
            //header("Location: ../index.php?login=error");
            exit();
        } else if($row=mysqli_fetch_assoc($result)){
                if($password == $row['password']){
                 //user loged in
                 //$row['status'] = true;
                 $sql = "UPDATE users SET status = 1 WHERE username = '$username'";
                 mysqli_query($conn,$sql);
                 $_SESSION['u_id'] = $row['user_id'];
                 $_SESSION['username'] = $row['username'];
                 header("Location: ../chatbox.php?login=success");
                 exit();
            }
        }

} else {
    $uid=mysqli_real_escape_string($conn,$_POST['username']);
    $pwd=mysqli_real_escape_string($conn,$_POST['password']);

    //not checking for errors

    $sql = "SELECT * FROM users WHERE username='$uid'";
    $result=mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck < 1) {
        //header("Location: ../index.php?login=error");
        exit();
    }else if($row=mysqli_fetch_assoc($result)){
            if($pwd == $row['password']){

            $tokenId = base64_encode(random_bytes(32));//mcrypt_create_iv(size) is depreceated use random_bytes(length)
			$issuedAt   = time();
			$notBefore  = $issuedAt;
			$expire		= $notBefore + (86400 * 30);
			$serverName = 'serverName';

			/**
			*	Creating token
			*/
			$data = [
				'iat'  => $issuedAt,
				'jti'  => $tokenId,
				'iss'  => $serverName,
				'nbf'  => $notBefore,
				'exp'  => $expire,
				'data' => [
					'userId'   => $row['user_id'],
					'username' => $uid,
					'password' => $pwd
				]
			];

			$secretKey = "2002__solo__DeadMenTellNoLie__AMillionDreams__TheGreatestShow";//base64_decode("example");

			$jwt = JWT::encode(
				$data,
				$secretKey,
				'HS512'
			);

			//$unencodedArray = ['jwt' => $jwt];
			//echo json_encode($unencodedArray);
			setcookie('Waste',$jwt,time()+60*60*24*365, '/');
            $_SESSION['u_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../chatbox.php?login=success");
            exit();
        }
    }
}
