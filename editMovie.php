<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลหมวดหมู่จากตาราง category
$category_query = "SELECT * FROM category";
$category_result = mysqli_query($conn, $category_query);
$categories = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
}

// ดึงข้อมูลสถานะจากตาราง status
$status_query = "SELECT * FROM status";
$status_result = mysqli_query($conn, $status_query);
$statuses = [];
while ($row = mysqli_fetch_assoc($status_result)) {
    $statuses[] = $row;
}

// ดึงข้อมูลหนังทั้งหมดสำหรับเลือกใน dropdown
$movie_query = "SELECT * FROM movies";
$movie_result = mysqli_query($conn, $movie_query);
$movies = [];
while ($row = mysqli_fetch_assoc($movie_result)) {
    $movies[] = $row;
}

// ฟังก์ชันอัปโหลดรูปภาพ
function uploadImage($file) {
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $newFileName = basename($file["name"]);
    $target_file = $target_dir . $newFileName;

    // ตรวจสอบว่าเป็นไฟล์รูปภาพจริงหรือไม่
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // จำกัดประเภทไฟล์
    $allowed_types = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        return false;
    }

    // อัปโหลดไฟล์
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $newFileName;
    } else {
        return false;
    }
}

// เพิ่มหนัง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_movie'])) {
    $nameM = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $category_Id = mysqli_real_escape_string($conn, $_POST['category_Id']);
    $status_id = mysqli_real_escape_string($conn, $_POST['status_id']);
    
    // อัปโหลดรูปภาพ
    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image']);
    } else {
        $image = null;
    }

    if (!empty($nameM) && !empty($details) && !empty($price) && !empty($director) && !empty($category_Id) && $image && !empty($status_id)) {
        $sql = "INSERT INTO movies (name, price, director, category_Id, description, image, status_id) 
                VALUES ('$nameM', '$price', '$director', '$category_Id', '$details', '$image', '$status_id')";
        if (mysqli_query($conn, $sql)) {
            echo "<p class='green'>✅ เพิ่มหนังสำเร็จ!</p>";
        } else {
            echo "<p class='red'>❌ เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='red'>⚠ กรุณากรอกข้อมูลให้ครบ และเลือกไฟล์รูปภาพที่ถูกต้อง</p>";
    }
}

// แก้ไขหนัง
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_movie'])) {
    $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $nameM = mysqli_real_escape_string($conn, $_POST['name']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $category_Id = mysqli_real_escape_string($conn, $_POST['category_Id']);
    $status_id = mysqli_real_escape_string($conn, $_POST['status_id']);

    // ตรวจสอบว่า category_Id มีอยู่ในตาราง category หรือไม่
    $category_check = mysqli_query($conn, "SELECT * FROM category WHERE category_id = '$category_Id'");
    if (mysqli_num_rows($category_check) > 0) {
        if (!empty($_FILES['image']['name'])) {
            $image = uploadImage($_FILES['image']);
            $sql = "UPDATE movies SET name='$nameM', price='$price', director='$director', category_Id='$category_Id', description='$details', image='$image', status_id='$status_id' WHERE movie_id='$movie_id'";
        } else {
            $sql = "UPDATE movies SET name='$nameM', price='$price', director='$director', category_Id='$category_Id', description='$details', status_id='$status_id' WHERE movie_id='$movie_id'";
        }
        if (mysqli_query($conn, $sql)) {
            echo "<p class='green'>✅ แก้ไขหนังสำเร็จ!</p>";
        } else {
            echo "<p class='red'>❌ ไม่สามารถแก้ไขหนังได้: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='red'>❌ หมวดหมู่ที่เลือกไม่มีอยู่ในระบบ!</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหนัง</title>
    <style>
        /* CSS เดิมทั้งหมด */
    </style>
    <script>
        // ฟังก์ชันดึงข้อมูลหนังมาแสดงในช่อง input
        function loadMovieDetails(movieId) {
            if (movieId == "") return;

            const movies = <?php echo json_encode($movies); ?>;
            const movie = movies.find(m => m.movie_id == movieId);
            if (movie) {
                document.getElementById('name').value = movie.name;
                document.getElementById('details').value = movie.description;
                document.getElementById('price').value = movie.price;
                document.getElementById('director').value = movie.director;
                document.getElementById('category_Id').value = movie.category_Id;
                document.getElementById('status_id').value = movie.status_id;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <<div class="form-container">
    <div class="form-box add-movie">
        <h1>เพิ่มหนัง</h1>
        <form method="post" enctype="multipart/form-data">
            <!-- ซ้าย -->
            <div class="left-side">
                <div class="form-group">
                    <label for="name">ชื่อหนัง</label>
                    <input type="text" name="name" id="name" placeholder="ชื่อหนัง" required>
                </div>
                <div class="form-group">
                    <label for="details">รายละเอียด</label>
                    <input type="text" name="details" id="details" placeholder="รายละเอียด" required>
                </div>
                <div class="form-group">
                    <label for="price">ราคา</label>
                    <input type="number" name="price" id="price" placeholder="ราคา" required>
                </div>
                <div class="form-group">
                    <label for="director">ผู้กำกับ</label>
                    <input type="text" name="director" id="director" placeholder="ผู้กำกับ" required>
                </div>
            </div>

            <!-- ขวา -->
            <div class="right-side">
                <div class="form-group">
                    <label for="category_Id">หมวดหมู่</label>
                    <select name="category_Id" id="category_Id" required>
                        <option value="">เลือกหมวดหมู่</option>
                        <!-- เติมหมวดหมู่ที่ดึงมาจากฐานข้อมูล -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_id">สถานะ</label>
                    <select name="status_id" id="status_id" required>
                        <option value="">เลือกสถานะ</option>
                        <!-- เติมสถานะที่ดึงมาจากฐานข้อมูล -->
                    </select>
                </div>
                <div class="form-group full-width">
                    <label for="image">อัปโหลดรูปภาพ</label>
                    <input type="file" name="image" id="image" required>
                </div>
                <div class="form-group full-width">
                    <button type="submit" name="add_movie">เพิ่มหนัง</button>
                </div>
            </div>
        </form>
    </div>

    <div class="form-box edit-movie">
        <h1>แก้ไขหนัง</h1>
        <form method="post" enctype="multipart/form-data">
            <!-- ซ้าย -->
            <div class="left-side">
                <div class="form-group">
                    <label for="movie_id">รหัสหนัง</label>
                    <input type="number" name="movie_id" id="movie_id" placeholder="รหัสหนัง" required>
                </div>
                <div class="form-group">
                    <label for="name">ชื่อหนัง</label>
                    <input type="text" name="name" id="name" placeholder="ชื่อหนัง" required>
                </div>
                <div class="form-group">
                    <label for="details">รายละเอียด</label>
                    <input type="text" name="details" id="details" placeholder="รายละเอียด" required>
                </div>
                <div class="form-group">
                    <label for="price">ราคา</label>
                    <input type="number" name="price" id="price" placeholder="ราคา" required>
                </div>
            </div>

            <!-- ขวา -->
            <div class="right-side">
                <div class="form-group">
                    <label for="category_Id">หมวดหมู่</label>
                    <select name="category_Id" id="category_Id" required>
                        <option value="">เลือกหมวดหมู่</option>
                        <!-- เติมหมวดหมู่ที่ดึงมาจากฐานข้อมูล -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_id">สถานะ</label>
                    <select name="status_id" id="status_id">
                        <option value="">เลือกสถานะ</option>
                        <!-- เติมสถานะที่ดึงมาจากฐานข้อมูล -->
                    </select>
                </div>
                <div class="form-group full-width">
                    <label for="image">อัปโหลดรูปภาพ</label>
                    <input type="file" name="image" id="image">
                </div>
                <div class="form-group full-width">
                    <button type="submit" name="edit_movie">แก้ไขหนัง</button>
                </div>
            </div>
        </form>
    </div>

    <!-- ปุ่มกลับ -->
    <div class="back-button">
        <a href="javascript:history.back()">กลับ</a>
    </div>
</div>


</body>

<style>

    /* คอนเทนเนอร์ของทั้งสองฟอร์ม */
.form-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
}

/* กล่องฟอร์ม */
.form-box {
    background-color: white;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 48%;
}

/* ปรับหัวเรื่อง */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* การจัดการกับฟอร์ม */
form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

input, select, button {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 100%;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"], input[type="number"], select {
    width: 100%;
}

button {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

/* ช่องกรอกข้อมูลระหว่างซ้ายขวา */
form .left-side, form .right-side {
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

.full-width {
    width: 100%;
}

button {
    width: 100%;
}

/* ปุ่มกลับ */
.back-button {
    text-align: center;
    margin-top: 20px;
}

.back-button a {
    text-decoration: none;
    color: #007BFF;
    font-size: 16px;
    font-weight: bold;
}

.back-button a:hover {
    text-decoration: underline;
}

</style>


</html>
