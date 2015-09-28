<?php

class CModel {

    private static $db = null;
    
    function __construct() {
        
        echo "MODEL CONSTRUCT ($this->db) <br/>\n";
        
    }

}