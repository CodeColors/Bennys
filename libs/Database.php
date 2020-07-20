<?php

/*
 * Author: piaf
 * Source: Members, open-source member area management
 * Description: Database class for use and do SQL request
 */

class Database
{

    private $host = "";
    private $username = "";
    private $password = "";
    private $database = "";

    function __construct(){
        return $this;
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

    public function DoSQLRequest($request, $array){ // SQL Request + Array of index champs
        $db = $this->GetDatabase();
        if($db){
            $s = $db->prepare($request);
            $s-execute($array);
            return $s;
        }

    }

}