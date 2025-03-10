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

// ตรวจสอบการส่งฟอร์มแก้ไขข้อมูล
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // ปรับปรุงข้อมูลในฐานข้อมูล
    $update_sql = "UPDATE users SET name = '$name', email = '$email' WHERE username = '" . $_SESSION['Username'] . "'";
    if ($conn->query($update_sql) === TRUE) {
        // ถ้าข้อมูลถูกอัปเดตสำเร็จ, รีไดเรกต์ไปยังหน้าข้อมูลส่วนตัว
        header("Location: personal.php");
        exit();
    } else {
        $message = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['Username'] . "'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2e3a59;
            font-size: 36px;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 50%;
            margin: 0 auto;
        }

        input[type="text"], input[type="email"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #388e3c;
        }

        .message {
            text-align: center;
            font-size: 16px;
            color: green;
            margin-bottom: 20px;
        }

        .logout-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #f44336;
            color: white;
            text-align: center;
            font-size: 16px;
            border-radius: 25px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลส่วนตัว</h1>
        
        <?php if (isset($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <!-- ฟอร์มแก้ไขข้อมูล -->
        <form method="POST">
            <label for="name">ชื่อ:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">อีเมล์:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <input type="submit" value="บันทึกการเปลี่ยนแปลง">
        </form>

        <!-- ปุ่มออกจากระบบ -->
        <a href="logout.php" class="logout-btn">ออกจากระบบ</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
