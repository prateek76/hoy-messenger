<?php
namespace ChatApp;

//require_once('../../vendor/autoload.php');

use Firebase\JWT\JWT;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $cookies = $conn->httpRequest->getHeader('Cookie');
        $this->clients->attach($conn);//store this $conn as cookie onOpen of connection and check//will not work
        echo "New connection! ({$conn->resourceId})\n";
        //print_r($cookies);
        $kt = (explode(';',$cookies[0]) );
        //security concern
        for ($i=0; $i < sizeof($kt); $i++) {
          $temp = explode('=',$kt[$i]);
          $checkSt = "Waste";
          if(strlen(trim($temp[0])) == 5 ) {
            echo $temp[1];
            break;
          }
        }
        //var_dump(explode('=',$rj[0])[1]);
        //$kt = json_encode($cookies);

    }

    public function onMessage(ConnectionInterface $from, $msg) {
        var_dump($msg);
        $msg = json_decode($msg, true);
        var_dump($msg["id"]);
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $cookies = $client->httpRequest->getHeader('Cookie');
                $kt = (explode(';',$cookies[0]) );
                for ($i=0; $i < sizeof($kt); $i++) {
                  $temp = explode('=',$kt[$i]);
                  $checkSt = "Waste";
                  if((trim($temp[0])) == $checkSt ) {
                    echo $temp[1];
                    $decoded = JWT::decode($temp[1], "2002__solo__DeadMenTellNoLie__AMillionDreams__TheGreatestShow", array('HS512'));
                    $xyz = ((array)$decoded);
                    $XyZ = ( (array)$xyz['data'] );
                    $user_id = $XyZ['userId'];
                    //$password = $XyZ['password'];//make for groupChat also
                    if($user_id == $msg["id"] && $msg["send_by"] != null){
                      $client->send(json_encode($msg));
                      var_dump($msg);
                    break;
                  }
                  }
                }
                //if($client->httpRequest->getHeader('Cookie')['username'])

            }
        }
    }

    public function onClose(ConnectionInterface $conn) {

        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
