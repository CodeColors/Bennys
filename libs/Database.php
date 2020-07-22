<?php

/*
 * Author: piaf
 * Source: Members, open-source member area management
 * Description: Database class for use and do SQL request
 */

class Database
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "bennys";

    function __construct(){
        return $this->GetDatabase();
    }

    public function GetDatabase(){
        try{
            $db = new PDO('mysql:host='. $this->host .';dbname='. $this->database .', '. $this->username .',' . $this->password );
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $db;
        }catch(Exception $e){
            return false;
        }
    }

}