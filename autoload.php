<?php
spl_autoload_register(function($class){
    $path = dirname(__FILE__). '/'. lcfirst(str_replace('\\','/',$class)) . '.php';
    require $path;
});