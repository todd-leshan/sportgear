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

    
    /*else if(file_exists($_SERVER['DOCUMENT_ROOT']."/sportsgear/app/core/".$fileName))
    {
        require $_SERVER['DOCUMENT_ROOT']."/sportsgear/app/core/".$fileName;
    }
    else if(file_exists($_SERVER['DOCUMENT_ROOT']."/sportsgear/app/models/DAO/".$fileName))
    {
        require $_SERVER['DOCUMENT_ROOT']."/sportsgear/app/models/DAO/".$fileName;
    }
    else if(file_exists($_SERVER['DOCUMENT_ROOT']."/sportsgear/app/models/VO/".$fileName))
    {
        require $_SERVER['DOCUMENT_ROOT']."/sportsgear/app/models/VO/".$fileName;
    }
    else 
    {
       // die($_SERVER['DOCUMENT_ROOT']);
        require $_SERVER['DOCUMENT_ROOT']."/sportsgear/app/core/".$fileName;
    }*/
    
    
}

/**
 * Register the PSR-0 autoloader
 */
spl_autoload_register('autoload');