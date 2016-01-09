<?php
/** The bootstrap file, intercepting all requests that are not matched to a directory or file
 *  @see        .htaccess
 *  @package    Framework
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @copyright  Copyright (c) 2013 Jos Nienhuis
 *  @since      04-04-2014
 */

require('config.php');
ini_set('display_errors', $settings['debug'] ? 'On' : 'Off');
die(new VideoController($settings));

/** Autoloads class files for controllers and models
 *  @param      string      $className      The classname to try and load a file for.
 *
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @since      04-04-2014
 */
function __autoload($className){
    if($className == 'Controller'){
        require_once(getcwd() . '/controllers/controller.php');
    }
    else if($className == 'Model'){
        require_once(getcwd() . '/models/model.php');
    }
    else if(strpos($className, 'Controller') !== false){
        $filename = strtolower(substr($className, 0, strripos($className, 'Controller'))) . '.php';

        if(file_exists(getcwd() . '/controllers/' . $filename)){
            require_once(getcwd() . '/controllers/' . $filename);
        }
    }
    else if(strpos($className, 'Model') !== false){
        $filename = strtolower(substr($className, 0, strripos($className, 'Model'))) . '.php';

        if(file_exists(getcwd() . '/models/' . $filename)){
            require_once(getcwd() . '/models/' . $filename);
        }
    }
}

/** A wrapper function of die() and var_dump() to easily dump values.
 *  @param      mixed       $value      The value to dump;
 *
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @since      04-04-2014
 */
function dump($value){
    die(var_dump($value));
}

/** Wrapper for header('location:')
 * @param String $url = relative or absolute URI
 *
 *  @version    0.1
 *  @author     Jos Nienhuis
 *  @since      09-04-2014
 */
function redir($url){
    die(header('location:' . $url));
}


?>