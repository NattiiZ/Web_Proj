<?php
session_start(); // เริ่มต้น session ก่อนทุกอย่าง

// ถ้าผู้ใช้ล็อกอินอยู่แล้ว ให้เปลี่ยนเส้นทางไปหน้าที่เหมาะสม
if (isset($_SESSION['Username'])) {
    if ($_SESSION['role_id'] == 1) {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

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
            $_SESSION['role_id'] = $row['role_id']; // เก็บ role_id ไว้ใน session

            // ถ้า role_id = 1 ให้ไปหน้า admin_dashboard.php
            if ($row['role_id'] == 1) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ไม่พบชื่อผู้ใช้";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
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
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
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
        .error {
            color: red;
            margin-top: 10px;
        }
        .register-btn {
            background: #4caf50;
            margin-top: 10px;
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

    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <form method="post">
            <div class="input-group">
                <i>👤</i>
                <input type="text" name="Username" placeholder="ชื่อผู้ใช้" required>
            </div>
            <div class="input-group">
                <i>🔒</i>
                <input type="password" name="Password" placeholder="รหัสผ่าน" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <a href="register.php"><button class="btn register-btn">สมัครสมาชิก</button></a>
    </div>

</body>
</html>
