<?php
$url = $_GET['url'] ?? 'sinhvien/index';
[$controller, $action] = explode('/', $url);

// Map 'sinhvien' → 'StudentController'
if ($controller === 'sinhvien') {
    $controllerClass = 'StudentController';
} else {
    $controllerClass = ucfirst($controller) . 'Controller';
}

require_once "app/Controllers/$controllerClass.php";

$controllerInstance = new $controllerClass();
$controllerInstance->$action();
