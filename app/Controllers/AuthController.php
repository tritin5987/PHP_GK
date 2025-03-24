<?php
require_once 'DB.php';

class AuthController {
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mssv = $_POST['MaSV'];
            $result = $GLOBALS['conn']->query("SELECT * FROM SinhVien WHERE MaSV = '$mssv'");

            if ($result && $result->num_rows > 0) {
                $_SESSION['user'] = $mssv;
                header("Location: " . BASE_URL . "sinhvien/index");
                exit();
            } else {
                $error = "Mã sinh viên không tồn tại!";
            }
        }

        include 'app/Views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL . "auth/login");
        exit();
    }
}
