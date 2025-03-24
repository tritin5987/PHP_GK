<?php
// Lấy URL hoặc mặc định
$url = $_GET['url'] ?? 'sinhvien/index';

// Tách controller và action
$parts = explode('/', $url);
$controller = $parts[0] ?? 'sinhvien';
$action = $parts[1] ?? 'index';

// Map controller
if ($controller === 'sinhvien') {
    $controllerClass = 'StudentController';
} elseif ($controller === 'auth') {
    $controllerClass = 'AuthController';
} elseif ($controller === 'hocphan') {
    $controllerClass = 'HocPhanController';
} else {
    $controllerClass = ucfirst($controller) . 'Controller';
}

$controllerPath = "app/Controllers/$controllerClass.php";

// Kiểm tra file controller tồn tại
if (!file_exists($controllerPath)) {
    die("Không tìm thấy controller: $controllerClass");
}
require_once $controllerPath;

// Tạo instance controller
$controllerInstance = new $controllerClass();

// Kiểm tra phương thức (action) có tồn tại không
if (!method_exists($controllerInstance, $action)) {
    die("Không tìm thấy action: $action trong $controllerClass");
}

// Gọi action
$controllerInstance->$action();
