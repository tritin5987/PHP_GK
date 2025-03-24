<?php
require_once 'DB.php';

class DangKyController {
    public function add() {
        session_start();
        if (!isset($_SESSION['user'])) header("Location: " . BASE_URL . "auth/login");

        $maHP = $_GET['MaHP'] ?? null;
        if ($maHP) {
            $_SESSION['cart'][] = $maHP;
        }
        header("Location: " . BASE_URL . "dangky/cart");
    }

    public function cart() {
        session_start();
        if (!isset($_SESSION['user'])) header("Location: " . BASE_URL . "auth/login");

        global $conn;
        $dsMaHP = $_SESSION['cart'] ?? [];
        $hocphans = [];

        if (!empty($dsMaHP)) {
            $in = "'" . implode("','", array_unique($dsMaHP)) . "'";
            $hocphans = $conn->query("SELECT * FROM HocPhan WHERE MaHP IN ($in)");
        }

        include 'app/Views/dangky/cart.php';
    }

    public function remove() {
        session_start();
        $maHP = $_GET['MaHP'] ?? '';
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $maHP);
        header("Location: " . BASE_URL . "dangky/cart");
    }

    public function clear() {
        session_start();
        unset($_SESSION['cart']);
        header("Location: " . BASE_URL . "dangky/cart");
    }

    public function save() {
        session_start();
        global $conn;

        $maSV = $_SESSION['user'];
        $ngayDK = date('Y-m-d');
        $dsMaHP = $_SESSION['cart'] ?? [];

        if (empty($dsMaHP)) {
            header("Location: " . BASE_URL . "dangky/cart");
            exit();
        }

        // 1. Tạo bản ghi đăng ký
        $conn->query("INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$ngayDK', '$maSV')");
        $maDK = $conn->insert_id;

        // 2. Thêm vào chi tiết đăng ký & giảm số lượng
        foreach ($dsMaHP as $maHP) {
            $conn->query("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ($maDK, '$maHP')");
            $conn->query("UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = '$maHP' AND SoLuong > 0");
        }

        unset($_SESSION['cart']);
        $_SESSION['success'] = "Đăng ký thành công!";
        header("Location: " . BASE_URL . "dangky/success");
    }

    public function success() {
        session_start();
        $msg = $_SESSION['success'] ?? 'Không có nội dung!';
        unset($_SESSION['success']);
        echo "<h3>$msg</h3>";
        echo "<a href='" . BASE_URL . "sinhvien/index'>Về danh sách sinh viên</a>";
    }
}
