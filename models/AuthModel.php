<?php

class RunModel extends CModel {

    function __construct() {
        echo "DB: " . self::$db . "<br/>\n";
    }

}