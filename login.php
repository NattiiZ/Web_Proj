<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "movie_ticket");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบเมื่อกดปุ่ม login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['Username'];
    $pass = $_POST['Password'];

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($pass == $row['password']) { // ตรวจสอบรหัสผ่าน (เวอร์ชันง่าย)
            $_SESSION['Username'] = $user;
            header("Location: showtime.php");
            exit();
        } else {
            echo "<p style='color:red;'>รหัสผ่านไม่ถูกต้อง</p>";
        }
    } else {
        echo "<p style='color:red;'>ไม่พบชื่อผู้ใช้</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>เข้าสู่ระบบ</h2>
    <form method="post">
        ชื่อผู้ใช้: <input type="text" name="Username" required><br>
        รหัสผ่าน: <input type="password" name="Password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
