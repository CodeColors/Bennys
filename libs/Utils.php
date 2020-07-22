<?php


class Utils
{

    public function checkSession($session){
        if(isset($session['user']['id'])){
            return true;
        }else{
            return false;
        }
    }

}