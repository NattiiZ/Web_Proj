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
        $error = "ชื่อผู้ใช้นี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น";
    } else {
        // บันทึกข้อมูลลงฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $name, $email);

        if ($stmt->execute()) {
            $success = "สมัครสมาชิกสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a>";
        } else {
            $error = "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            width: 350px;
        }

        h2 {
            color: #ff4081;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .input-group {
            margin: 15px 0;
            position: relative;
        }

        input {
            width: 100%;
            padding: 12px;
            padding-left: 40px;
            border: 2px solid #ff4081;
            border-radius: 25px;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #d81b60;
            box-shadow: 0px 0px 10px rgba(216, 27, 96, 0.3);
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff4081;
        }

        .btn {
            background: #ff4081;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 5px 15px rgba(255, 64, 129, 0.3);
        }

        .btn:hover {
            background: #d81b60;
            box-shadow: 0px 7px 20px rgba(216, 27, 96, 0.5);
        }

        .btn:active {
            transform: scale(0.95);
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>REGISTER</h2>
        <form method="post">
            <div class="input-group">
                <i>👤</i>
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="input-group">
                <i>📧</i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i>👤</i>
                <input type="text" name="username" placeholder="User" required>
            </div>
            <div class="input-group">
                <i>🔒</i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">REGISTER</button>
        </form>

        <?php if (isset($error)) { ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <p class="message success"><?php echo $success; ?></p>
        <?php } ?>
    </div>

</body>
</html>
