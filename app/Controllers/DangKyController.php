<?php
require_once 'DB.php';

class DangKyController {
    private function ensureSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add() {
        $this->ensureSession();
        if (!isset($_SESSION['user'])) header("Location: " . BASE_URL . "auth/login");
    
        global $conn;
    
        $maHP = $_GET['MaHP'] ?? null;
        $maSV = $_SESSION['user'];
    
        if ($maHP) {
            // 1. Kiểm tra học phần đã được đăng ký chưa
            $query = "
                SELECT ctdk.MaHP
                FROM DangKy dk
                JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
                WHERE dk.MaSV = '$maSV' AND ctdk.MaHP = '$maHP'
            ";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $_SESSION['error'] = "Học phần này đã được đăng ký trước đó!";
                header("Location: " . BASE_URL . "hocphan/index");
                exit();
            }
    
            // 2. Nếu chưa đăng ký thì thêm vào giỏ
            $_SESSION['cart'][] = $maHP;
        }
    
        header("Location: " . BASE_URL . "dangky/cart");
    }
    

    public function cart() {
        $this->ensureSession();
        if (!isset($_SESSION['user'])) header("Location: " . BASE_URL . "auth/login");
    
        global $conn;
        $maSV = $_SESSION['user'];
    
        // Lấy học phần
        $dsMaHP = $_SESSION['cart'] ?? [];
        $hocphans = [];
        if (!empty($dsMaHP)) {
            $in = "'" . implode("','", array_unique($dsMaHP)) . "'";
            $hocphans = $conn->query("SELECT * FROM HocPhan WHERE MaHP IN ($in)");
        }
    
        // Lấy thông tin sinh viên
        $sv = $conn->query("SELECT sv.*, n.TenNganh FROM SinhVien sv JOIN NganhHoc n ON sv.MaNganh = n.MaNganh WHERE MaSV = '$maSV'")->fetch_assoc();
    
        include 'app/Views/dangky/cart.php';
    }
    

    public function remove() {
        $this->ensureSession();
        $maHP = $_GET['MaHP'] ?? '';
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $maHP);
        header("Location: " . BASE_URL . "dangky/cart");
    }

    public function clear() {
        $this->ensureSession();
        unset($_SESSION['cart']);
        header("Location: " . BASE_URL . "dangky/cart");
    }

    public function save() {
        $this->ensureSession();
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
        $this->ensureSession();
        $msg = $_SESSION['success'] ?? 'Không có nội dung!';
        unset($_SESSION['success']);
        echo "<h3>$msg</h3>";
        echo "<a href='" . BASE_URL . "sinhvien/index'>Về danh sách sinh viên</a>";
    }
}
