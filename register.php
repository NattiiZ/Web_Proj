<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
</head>
<body>
    <h1>📝 สมัครสมาชิก</h1>
    <form action="process_register.php" method="POST">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required><br>
        <input type="email" name="email" placeholder="อีเมล" required><br>
        <input type="password" name="password" placeholder="รหัสผ่าน" required><br>
        <button type="submit">สมัครสมาชิก</button>
    </form>
    <a href="login.php">เข้าสู่ระบบ</a>
</body>
</html>
