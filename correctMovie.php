<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีการส่งค่า POST มาหรือไม่ (เพิ่มหนัง)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_movie'])) {
    $nameM = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $category_Id = mysqli_real_escape_string($conn, $_POST['category_Id']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    if (!empty($nameM) && !empty($details) && !empty($price) && !empty($director) && !empty($category_Id) && !empty($image)) {
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

// ฟังก์ชันลบหนัง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_movie'])) {
    $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $sql = "DELETE FROM movies WHERE id='$movie_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>✅ ลบหนังสำเร็จ!</p>";
    } else {
        echo "<p style='color: red;'>❌ ไม่สามารถลบหนังได้: " . mysqli_error($conn) . "</p>";
    }
}

// ฟังก์ชันแก้ไขหนัง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_movie'])) {
    $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $nameM = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $category_Id = mysqli_real_escape_string($conn, $_POST['category_Id']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $sql = "UPDATE movies SET name='$nameM', price='$price', director='$director', category_Id='$category_Id', description='$details', image='$image' WHERE id='$movie_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>✅ แก้ไขหนังสำเร็จ!</p>";
    } else {
        echo "<p style='color: red;'>❌ ไม่สามารถแก้ไขหนังได้: " . mysqli_error($conn) . "</p>";
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหนัง</title>
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
    </style>
</head>
<body>
<div class="container">
    <h1>เพิ่มหนัง</h1>
    <form method="post">
        <input type="text" name="name" placeholder="ชื่อหนัง" required>
        <input type="text" name="details" placeholder="รายละเอียด" required>
        <input type="number" name="price" placeholder="ราคา" required>
        <input type="text" name="director" placeholder="ผู้กำกับ" required>
        <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
        <input type="text" name="image" placeholder="ภาพ" required>
        <button type="submit" name="add_movie">เพิ่มหนัง</button>
    </form>

    <h1>ลบหนัง</h1>
    <form method="post">
        <input type="number" name="movie_id" placeholder="รหัสหนัง" required>
        <button type="submit" name="delete_movie">ลบหนัง</button>
    </form>

    <h1>แก้ไขหนัง</h1>
    <form method="post">
        <input type="number" name="movie_id" placeholder="รหัสหนัง" required>
        <input type="text" name="name" placeholder="ชื่อหนัง" required>
        <input type="text" name="details" placeholder="รายละเอียด" required>
        <input type="number" name="price" placeholder="ราคา" required>
        <input type="text" name="director" placeholder="ผู้กำกับ" required>
        <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
        <input type="text" name="image" placeholder="ภาพ" required>
        <button type="submit" name="edit_movie">แก้ไขหนัง</button>
    </form>
</div>
</body>
</html>
