<?php
// class autoloader 


spl_autoload_register('classAutoloader');

function classAutoloader($className)
{
    $controllerPath = ROOT_DIR . 'src/controllers/';
    $modelPath = ROOT_DIR . 'src/models/';
    $utilsPath = ROOT_DIR . 'src/utils/';
    $middlewarePath = ROOT_DIR . 'src/middlewares/';

    $controllerFile = $controllerPath . $className . '.class.php';
    $modelFile = $modelPath . $className . '.class.php';
    $utilsFile = $utilsPath . $className . '.class.php';
    $middlewareFile = $middlewarePath . $className . '.php';

    if (file_exists($middlewareFile)) {
        require_once $middlewareFile;
    } else if (file_exists($utilsFile)) {
        require_once $utilsFile;
    } elseif (file_exists($controllerFile)) {
        require_once $controllerFile;
    } elseif (file_exists($modelFile)) {
        require_once $modelFile;
    } else {
        echo 'Class ' . $className . ' not found';
    }

}
