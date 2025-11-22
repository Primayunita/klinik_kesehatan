<?php
session_start();

require_once "../app/config.php";
require_once "../app/db.php";

$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerFile = "../app/controllers/" . ucfirst($page) . "Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $class = ucfirst($page) . "Controller";

    $controller = new $class();

    if (method_exists($controller, $action)) {
        $controller->$action();
        exit;
    }
}

echo "404 - Page Not Found";
