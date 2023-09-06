<?php
class SimpleMethodHelper{
    /**
     * A simple method helper, just pass the name of the class, the name of the method, and the parameters (default is null) and you are all set
     * @param string $class Pass the class name here
     * @param string $method Pass the method name here
     * @param mixed $parameters Pass the parameters or arguments here, default value is null
     * @return void calls the function for you
     */
    public static function executeMethod(string $class, string $method, mixed $parameters=null){
        if(method_exists($class, $method)){
            $init = new $class();
            return $init->$method($parameters);
        }else{
            echo "Method Not Found";
        }
    }
}