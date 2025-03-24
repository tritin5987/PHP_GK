<h2>Giỏ học phần đã chọn</h2>

<?php if (empty($dsMaHP)): ?>
    <p>Chưa chọn học phần nào!</p>
<?php else: ?>
<table border="1" cellpadding="10">
    <tr><th>Mã HP</th><th>Tên HP</th><th>Tín chỉ</th><th>Hành động</th></tr>
    <?php
    $tongTinChi = 0;
    while ($row = $hocphans->fetch_assoc()):
        $tongTinChi += $row['SoTinChi'];
    ?>
    <tr>
        <td><?= $row['MaHP'] ?></td>
        <td><?= $row['TenHP'] ?></td>
        <td><?= $row['SoTinChi'] ?></td>
        <td><a href="<?= BASE_URL ?>dangky/remove&MaHP=<?= $row['MaHP'] ?>">Xoá</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<p><strong>Số lượng học phần:</strong> <?= count($dsMaHP) ?></p>
<p><strong>Tổng số tín chỉ:</strong> <?= $tongTinChi ?></p>

<hr>

<h3>Thông tin Đăng ký</h3>
<p><strong>Mã số sinh viên:</strong> <?= $sv['MaSV'] ?></p>
<p><strong>Họ tên sinh viên:</strong> <?= $sv['HoTen'] ?></p>
<p><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($sv['NgaySinh'])) ?></p>
<p><strong>Ngành học:</strong> <?= $sv['TenNganh'] ?></p>
<p><strong>Ngày đăng ký:</strong> <?= date('d/m/Y') ?></p>

<a href="<?= BASE_URL ?>dangky/save"><button>Xác nhận</button></a> |
<a href="<?= BASE_URL ?>dangky/clear" onclick="return confirm('Xoá toàn bộ học phần?')">Xoá tất cả</a>
<?php endif; ?>
