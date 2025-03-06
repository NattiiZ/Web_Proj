<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
</head>
<body>
    <h1>🔑 เข้าสู่ระบบ</h1>
    <form action="process_login.php" method="POST">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required><br>
        <input type="password" name="password" placeholder="รหัสผ่าน" required><br>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
    <a href="register.php">สมัครสมาชิก</a>
</body>
</html>