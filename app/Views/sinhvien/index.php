
<?php
require_once 'app/Models/SinhVien.php';
$tenSV = SinhVien::getNameByMaSV($_SESSION['user']);
?>

<p>
    Xin chào <strong><?= $tenSV ?></strong> |
    <a href="<?= BASE_URL ?>auth/logout">Đăng xuất</a>
</p><h2>Danh sách sinh viên</h2>
<a href="<?= BASE_URL ?>sinhvien/create">Thêm sinh viên</a>
<a href="<?= BASE_URL ?>hocphan/index">Đăng ký học phần</a>
<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <th>Mã SV</th>
    <th>Họ tên</th>
    <th>Giới tính</th>
    <th>Ngày sinh</th>
    <th>Hình</th>
    <th>Hành động</th>
</tr>
<?php while ($sv = $sinhviens->fetch_assoc()): ?>
<tr>
    <td><?= $sv['MaSV'] ?></td>
    <td><?= $sv['HoTen'] ?></td>
    <td><?= $sv['GioiTinh'] ?></td>
    <td><?= $sv['NgaySinh'] ?></td>
    <td>
        <img src="<?= BASE_URL . $sv['Hinh'] ?>" width="80" height="80" style="object-fit: cover;">
    </td>
    <td>
        <a href="<?= BASE_URL ?>sinhvien/detail&MaSV=<?= $sv['MaSV'] ?>">Chi tiết</a> |
        <a href="<?= BASE_URL ?>sinhvien/edit&MaSV=<?= $sv['MaSV'] ?>">Sửa</a> |
        <a href="<?= BASE_URL ?>sinhvien/delete&MaSV=<?= $sv['MaSV'] ?>" onclick="return confirm('Xóa?')">Xóa</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
