<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controller/AuthController.php';

// تحديد المسار (Route) بناءً على متغير GET
$route = isset($_GET['route']) ? $_GET['route'] : 'calculator';

switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new AuthController($pdo);
            $auth->login();
        } else {
            require __DIR__ . '/app/view/auth/login.php';
        }
        break;
        
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new AuthController($pdo);
            $auth->register();
        } else {
            require __DIR__ . '/app/view/auth/register.php';
        }
        break;
        
    case 'logout':
        $auth = new AuthController($pdo);
        $auth->logout();
        break;
        
    case 'calculator':
    default:
        // حماية الصفحة: التأكد من تسجيل دخول المستخدم
        if (!isset($_SESSION['user'])) {
            header("Location: /crypto-project/?route=login");
            exit;
        }
        require __DIR__ . '/app/view/calculator.php';
        break;
}
?>
