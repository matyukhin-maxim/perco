<?php

class CModel {

    protected static $db = null;
    
    function __construct() {
        
        if (!$this->isConnected()) {
            
            $config = include './config/config.php';
            $properties = $config['mysql'];
            
            try {
                
                // init mysql connection
                self::$db = new PDO(
                        sprintf("mysql:host=%s;dbname=%s", $properties['host'], $properties['base'])
                        , $properties['user']
                        , $properties['pass']
                        , [
                            PDO::ATTR_TIMEOUT => 5,
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',
                        ]);
                
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                //this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                
            } catch (Exception $exc) {
                
                self::$db = null;
                echo 'База данных не доступна! ' . $exc->getMessage() . "<br/>\n";
            }
                    
        }
        
    }
    
    protected function select($query, $param = array()) {

        if (!self::isConnected()) return [
            'error' => 'Not connected',
        ];
        
        $sth = self::$db->prepare($query);

        foreach ($param as $key => $value) {
            $type = strtolower(gettype($value));
            $cast = null;
            switch ($type) {
                case 'integer': $cast = PDO::PARAM_INT;     break;
                case 'null':    $cast = PDO::PARAM_NULL;    break;
                case 'boolean': $cast = PDO::PARAM_BOOL;    break;
                default:        $cast = PDO::PARAM_STR;     break;
            }
            $sth->bindValue($key, $value, $cast);
        }
        
        $sth->execute();
        $error = $sth->errorInfo();
        
        $data = $sth->fetchAll();
        
        return [
            'data' => $data,
            'error' => get_param($error, 2),
        ];
    }
    
    public static function isConnected() {
        
        return self::$db !== null;
    }

}