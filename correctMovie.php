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
        $sql = "INSERT INTO movies (name, price, director ,category_Id, description, image) VALUES ('$nameM', '$price', '$director','$category_Id','$description','$image')";

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