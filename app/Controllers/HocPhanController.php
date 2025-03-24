<?php
require_once 'DB.php';


class HocPhanController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit();
        }

        global $conn;
        $hocphans = $conn->query("SELECT * FROM HocPhan");
        include 'app/Views/hocphan/index.php';
    }
}
