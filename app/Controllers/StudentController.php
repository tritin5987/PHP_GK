<?php
require_once 'app/Models/SinhVien.php';
require_once 'app/Models/NganhHoc.php';


class StudentController {
    public function index() {
        $sinhviens = SinhVien::all();
        include 'app/Views/sinhvien/index.php';
    }

    public function create() {
        $nganhs = NganhHoc::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = '';
            if ($_FILES['Hinh']['name']) {
                $fileName = basename($_FILES['Hinh']['name']);
                $targetPath = 'Content/images/' . $fileName;
                move_uploaded_file($_FILES['Hinh']['tmp_name'], $targetPath);
                $imagePath = $targetPath;
            }
            $_POST['Hinh'] = $imagePath;
            SinhVien::create($_POST);
            header("Location: " . BASE_URL . "sinhvien/index");
            exit();
        }
        include 'app/Views/sinhvien/create.php';
    }

    public function edit() {
        $maSV = $_GET['MaSV'];
        $sv = SinhVien::find($maSV); 
    
        $nganhs = NganhHoc::all(); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $sv['Hinh']; 
    
            if (!empty($_FILES['Hinh']['name'])) {
                $fileName = basename($_FILES['Hinh']['name']);
                $targetPath = 'Content/images/' . $fileName;
                move_uploaded_file($_FILES['Hinh']['tmp_name'], $targetPath);
                $imagePath = $targetPath;
            }
    
            $_POST['Hinh'] = $imagePath;
            SinhVien::update($maSV, $_POST);
    
            header("Location: " . BASE_URL . "sinhvien/index");
            exit();
        }
    
        include 'app/Views/sinhvien/edit.php';
    }
    
    

    public function delete() {
        
        $maSV = $_GET['MaSV'];
        SinhVien::delete($maSV);
        header("Location: " . BASE_URL . "sinhvien/index");
    }

    public function detail() {
        $maSV = $_GET['MaSV'];
        $sv = SinhVien::find($maSV);
        include 'app/Views/sinhvien/detail.php';
    }
}
