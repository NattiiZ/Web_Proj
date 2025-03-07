<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// รับค่าจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p style='color:red;'>ชื่อผู้ใช้นี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น</p>";
    } else {
        // บันทึกข้อมูลลงฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $name, $email);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>สมัครสมาชิกสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a></p>";
        } else {
            echo "<p style='color:red;'>เกิดข้อผิดพลาด: " . $stmt->error . "</p>";
        }
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 320px;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Register</h1>
    <form action="register.php" method="post"> 
        <p><input type="text" name="name" placeholder="Name" required></p>
        <p><input type="email" name="email" placeholder="Email" required></p>
        <p><input type="text" name="username" placeholder="Username" required></p>
        <p><input type="password" name="password" placeholder="Password" required></p>
        <input type="submit" value="สมัครสมาชิก">
    </form>
</body>
</html>
