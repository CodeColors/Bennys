<?php

/*
 * Author: piaf
 * Description: Locale manager
 */

class Locale
{

    private $selected = "";
    private $Locale = [];

    function  __construct($locale)
    {
        $this->selected = $locale;
        return $this;
    }

    public function getTranslate($nameIndex){
        $expectedTranslate = $this->Locale[$this->selected][$nameIndex];
        if($expectedTranslate != null){
            return $expectedTranslate;
        }else {
            return "Bennys>Libs>Locale: translate $nameIndex cannot be found.";
        }
    }



}