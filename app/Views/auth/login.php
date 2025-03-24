<h2>Đăng nhập bằng MSSV</h2>
<form method="post">
    Mã sinh viên: <input type="text" name="MaSV" required><br><br>
    <button type="submit">Đăng nhập</button>
</form>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>
