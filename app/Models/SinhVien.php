<?php
require_once 'DB.php';

class SinhVien {
    public static function all() {
        global $conn;
        return $conn->query("SELECT * FROM SinhVien");
    }

    public static function find($maSV) {
        global $conn;
        $result = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$maSV'");
        return $result->fetch_assoc();
    }

    public static function create($data) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $data['MaSV'], $data['HoTen'], $data['GioiTinh'], $data['NgaySinh'], $data['Hinh'], $data['MaNganh']);
        $stmt->execute();
    }

    public static function update($maSV, $data) {
        global $conn;
        $stmt = $conn->prepare("UPDATE SinhVien SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? WHERE MaSV=?");
        $stmt->bind_param("ssssss", $data['HoTen'], $data['GioiTinh'], $data['NgaySinh'], $data['Hinh'], $data['MaNganh'], $maSV);
        $stmt->execute();
    }

    public static function delete($maSV) {
        global $conn;
        $conn->query("DELETE FROM SinhVien WHERE MaSV='$maSV'");
    }
}
