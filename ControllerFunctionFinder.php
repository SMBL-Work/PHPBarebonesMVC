<?php 
function executeMethod(string $class, string $method, mixed $parameters=null){
    if(method_exists($class, $method)){
        $init = new $class();
        return $init->$method($parameters);
    }else{
        echo "Command Not Found";
    }
}

$file = $_SERVER["SCRIPT_NAME"];
$baseScriptLoc = str_replace(dirname($file,2),'',$file);
$baseFolder = explode('/',$baseScriptLoc);

if(array_search('controllers',$baseFolder) != false){
    if(isset($_POST['cmd'])){
        $classToRun = str_replace('/','\\', str_replace('.php','',$baseScriptLoc));
        $methodCaught = filter_input(INPUT_POST, "cmd", FILTER_SANITIZE_SPECIAL_CHARS);
        executeMethod($classToRun, $methodCaught);
    }
}