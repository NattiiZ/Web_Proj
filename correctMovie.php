<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($hostname, $username, $password);

if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// เลือกฐานข้อมูล
if (!mysqli_select_db($conn, $dbname)) {
    die("ไม่สามารถเลือกฐานข้อมูล: " . mysqli_error($conn));
}

// ตรวจสอบว่ามีการส่งค่า POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์มและป้องกัน SQL Injection
    $nameM = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $category_Id = mysqli_real_escape_string($conn, $_POST['category_Id']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    // ตรวจสอบว่ากรอกค่าครบหรือไม่
    if (!empty($nameM) && !empty($details) && !empty($price) && !empty($director) && !empty($category_Id) && !empty($image)) {
        // แก้ไข SQL โดยใช้ค่าตัวแปรถูกต้อง
        $sql = "INSERT INTO movies (name, price, director, category_Id, description, image) VALUES ('$nameM', '$price', '$director', '$category_Id', '$details', '$image')";


        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>✅ เพิ่มหนังสำเร็จ!</p>";
        } else {
            echo "<p style='color: red;'>❌ เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>⚠ กรุณากรอกข้อมูลให้ครบ</p>";
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มหนัง</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 40%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #333;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #218838;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
<body>
<h1>เพิ่มหนัง</h1>
<form method="post">
    <p><input type="text" name="name" placeholder="ชื่อหนัง" required></p>
    <p><input type="text" name="details" placeholder="รายละเอียด" required></p>
    <p><input type="number" name="price" placeholder="ราคา" required></p>
    <p><input type="text" name="director" placeholder="ผู้กำกับ" required></p>
    <p><input type="text" name="category_Id" placeholder="หมวดหมู่" required></p>
    <p><input type="text" name="image" placeholder="ภาพ" required></p>

    <button type="submit">เพิ่มหนัง</button>
</form>
</body>
</html>