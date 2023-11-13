<?php 
namespace helpers;
class Session_Helper {
    public static $instance = null;
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE || session_id() == '') {
            session_start();
        }
    }
    public static function getInstance(): Session_Helper
    {
        if (!self::$instance) {
            self::$instance = new Session_Helper();
        }

        return self::$instance;
    }
    public static function killSession(){
        session_destroy();
    }
    /**
     * @return mixed|null
     */
    function getSessionData($key){
        return $_SESSION[$key] ?? null;
    }
    /**
     * @return void
     */
    function createSessionData($key, $value){
        $_SESSION[$key] = $value;
    }
}