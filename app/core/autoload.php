<?php

/**
 * Create a hash 
 * @param string $string
 * @return string
 */
function getHash($string){
    return hash('sha256', $string);
}

/**
 * PSR-0 autoloader
 * @param string $className
 */
function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    //require $fileName;

    $classDirs = array('./', '../models/', '../models/DAO/', '../models/VO/');
    
    foreach ($classDirs as $classDir) {

        $tempFileName = __DIR__ . '/' . $classDir . $fileName;

        if(file_exists($tempFileName))
        {
            require_once $tempFileName;
            break;
        }
    }
 
}

/**
 * Register the PSR-0 autoloader
 */
spl_autoload_register('autoload');