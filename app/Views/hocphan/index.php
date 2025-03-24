<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error'] ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<h2>Danh sách học phần</h2>

<a href="<?= BASE_URL ?>dangky/cart">Xem giỏ học phần</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Mã HP</th>
        <th>Tên học phần</th>
        <th>Số tín chỉ</th>
        <th>Số lượng còn</th>
        <th>Hành động</th>
    </tr>
    <?php while ($hp = $hocphans->fetch_assoc()): ?>
    <tr>
        <td><?= $hp['MaHP'] ?></td>
        <td><?= $hp['TenHP'] ?></td>
        <td><?= $hp['SoTinChi'] ?></td>
        <td><?= $hp['SoLuong'] ?></td>
        <td>
            <a href="<?= BASE_URL ?>dangky/add&MaHP=<?= $hp['MaHP'] ?>">Đăng ký</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
