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

// ตรวจสอบว่าตารางมีคอลัมน์ id หรือไม่
$column_check = mysqli_query($conn, "SHOW COLUMNS FROM movies LIKE 'id'");
$has_id_column = mysqli_num_rows($column_check) > 0;
$primary_key = $has_id_column ? 'id' : 'movie_id';

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
    $sql = "DELETE FROM movies WHERE $primary_key='$movie_id'";
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

    // ตรวจสอบว่า category_Id มีอยู่ในตาราง category หรือไม่
    $category_check = mysqli_query($conn, "SELECT * FROM category WHERE category_id = '$category_Id'");
    if (mysqli_num_rows($category_check) > 0) {
        // ถ้ามีการอัปโหลดรูปใหม่ให้แทนที่
        if (!empty($_FILES['image']['name'])) {
            $image = uploadImage($_FILES['image']);
            $sql = "UPDATE movies SET name='$nameM', price='$price', director='$director', category_Id='$category_Id', description='$details', image='$image' WHERE $primary_key='$movie_id'";
        } else {
            $sql = "UPDATE movies SET name='$nameM', price='$price', director='$director', category_Id='$category_Id', description='$details' WHERE $primary_key='$movie_id'";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>✅ แก้ไขหนังสำเร็จ!</p>";
            
        } else {
            echo "<p style='color: red;'>❌ ไม่สามารถแก้ไขหนังได้: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ หมวดหมู่ที่เลือกไม่มีอยู่ในระบบ!</p>";
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
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .form-group input {
            width: 48%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #ff758c;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 117, 140, 0.5);
        }
        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            background: #ff758c;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff5c75;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .container a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .container a:hover {
            color: #ff758c;
        }


    </style>
</head>
<body>
<div class="container">
    <h1>เพิ่มหนัง</h1>
    <form method="post">
        <div class="form-group">
            <input type="text" name="name" placeholder="ชื่อหนัง" required>
            <input type="text" name="details" placeholder="รายละเอียด" required>
        </div>
        <div class="form-group">
            <input type="number" name="price" placeholder="ราคา" required>
            <input type="text" name="director" placeholder="ผู้กำกับ" required>
        </div>
        <div class="form-group">
            <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
            <input type="text" name="image" placeholder="ภาพ" required>
        </div>
        <button type="submit" name="add_movie">เพิ่มหนัง</button>
    </form>

    <h1>ลบหนัง</h1>
    <form method="post">
        <div class="form-group">
            <input type="number" name="movie_id" placeholder="รหัสหนัง" required>
        </div>
        <button type="submit" name="delete_movie">ลบหนัง</button>
    </form>

    <h1>แก้ไขหนัง</h1>
    <form method="post">
        <div class="form-group">
            <input type="number" name="movie_id" placeholder="รหัสหนัง" required>
            <input type="text" name="name" placeholder="ชื่อหนัง" required>
        </div>
        <div class="form-group">
            <input type="text" name="details" placeholder="รายละเอียด" required>
            <input type="number" name="price" placeholder="ราคา" required>
        </div>
        <div class="form-group">
            <input type="text" name="director" placeholder="ผู้กำกับ" required>
            <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
        </div>
        <div class="form-group">
            <input type="text" name="image" placeholder="ภาพ" required>
        </div>
        <button type="submit" name="edit_movie">แก้ไขหนัง</button>
    </form>

</div>
</body>
</html>
