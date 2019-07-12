<?php

class Core {

    protected $db, $result;         #protected property
    private $rows;                  #is used as array

    public function __construct() { #method
        $this->db = new mysqli('localhost','root','','chat_app');
    }

    public function query($sql) {   #query method
        $this->result = $this->db->query($sql);
    }
    #rows method
    public function rows() {        #loop through data and spit out
        for($x = 1; $x <= $this->db->affected_rows; $x++) {
            $this->rows[] = $this->result->fetch_assoc();
        }
        return $this->rows;
    }

    /*public function rowspecific($key) {        #loop through data and spit out
        for($x = 1; $x <= $this->db->affected_rows; $x++) {
            $this->rows[] = $this->result->fetch_assoc();
        }
        return $this->rows[$key];
    }*/
}
