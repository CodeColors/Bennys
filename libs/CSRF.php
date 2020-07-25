<?php

/*
 * Author: piaf
 * Description: anti-CSRF injection class
 */

class CSRF
{

    public function generateCSRF(){ // Generate new random CSRF
        return time() + rand();
    }

    public function checkCSRF($session, $get, $post){ // Check CSRF function
        if(isset($session['csrf']) AND ($session['csrf'] == $get['csrf'] || $session['csrf'] == $post['csrf'])){
            return true;
        }else {
            return false;
        }
    }

    public function addHiddenCSRFButton($csrf){ // Hidden button for HTML form and post management
        return '<input type="hidden" value="'. $csrf . '" name="csrf" />';
    }

}