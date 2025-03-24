<h2>Thêm sinh viên</h2>
<form method="post" enctype="multipart/form-data">
    Mã SV: <input name="MaSV"><br>
    Họ tên: <input name="HoTen"><br>
    Giới tính: <input name="GioiTinh"><br>
    Ngày sinh: <input type="date" name="NgaySinh"><br>
    Ảnh: <input type="file" name="Hinh"><br>
    Mã ngành:
    <select name="MaNganh">
        <?php while ($n = $nganhs->fetch_assoc()): ?>
            <option value="<?= $n['MaNganh'] ?>"><?= $n['TenNganh'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Thêm</button>
</form>
