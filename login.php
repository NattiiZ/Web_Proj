<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";
$conn = mysqli_connect($hostname, $username, $password);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// รับค่าจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['Username']);
    $pass = mysqli_real_escape_string($conn, $_POST['Password']);

    // ใช้ prepared statement ป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบผลลัพธ์
    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) { // ตรวจสอบรหัสผ่าน
            $_SESSION['Username'] = $user;
            header("Location: showtime.php?username=$user");
            exit();
        } else {
            echo "<p style='color:red;'>รหัสผ่านไม่ถูกต้อง</p>";
        }
    } else {
        echo "<p style='color:red;'>ไม่พบชื่อผู้ใช้ " . htmlspecialchars($user) . "</p>";
    }
    echo "<br><a href='login.php'>คลิกกลับไปเพื่อ login</a>";

    // ปิด statement
    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <center>
        <h1>Login</h1>
        <form action="" method="post">
            <table border='1' width='300'>
                <tr>
                    <td colspan='2' align='center'>กรุณาป้อนชื่อผู้ใช้งานและรหัสผ่าน</td>
                </tr>
                <tr>
                    <td>Username :</td>
                    <td><input type="text" name="Username" required></td>
                </tr>
                <tr>
                    <td>Password :</td>
                    <td><input type="password" name="Password" required></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><input type="submit" value=" OK "></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>
