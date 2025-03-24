
<h2>Sửa sinh viên</h2>
<form method="post" enctype="multipart/form-data">
    Họ tên: <input name="HoTen" value="<?= $sv['HoTen'] ?>"><br>
    Giới tính:
    <select name="GioiTinh">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select><br>
    Ngày sinh: <input type="date" name="NgaySinh" value="<?= $sv['NgaySinh'] ?>"><br>
    Ảnh: <input type="file" name="Hinh"><br>
    (Ảnh hiện tại: <img src="<?= BASE_URL . $sv['Hinh'] ?>" width="60">)<br>
    Mã ngành:
    <select name="MaNganh">
        <?php while ($n = $nganhs->fetch_assoc()): ?>
            <option value="<?= $n['MaNganh'] ?>" <?= $sv['MaNganh'] == $n['MaNganh'] ? 'selected' : '' ?>>
                <?= $n['TenNganh'] ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Cập nhật</button>
</form>
