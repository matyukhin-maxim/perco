<?php

class AuthModel extends CModel {

    function __construct() {
        echo "DB: " . self::$db . "<br/>\n";
    }

}