<?php
function pathUrl($dir = __DIR__)
{

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    //HTTPS or HTTP
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    //HOST
    //empty when accessed by cron
    if (isset($_SERVER['HTTP_HOST'])) {
        $root .= '://' . $_SERVER['HTTP_HOST'];
    } else {
        $root = "";
    }

    //ALIAS
    if (!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
    } else {
        $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
    }

    $root .= '/';

    return $root;
}

//URLROOT
define('URLROOT', pathUrl(__DIR__ . '/../'));
//APPROOT
define('APPROOT', dirname(dirname(__FILE__)));

//timezone
define('TIMEZONE', 'Asia/Singapore');
date_default_timezone_set(TIMEZONE);

echo str_replace('\\','/',dirname(__DIR__,1));