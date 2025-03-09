
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="banner.jpg" alt="โปสเตอร์หนัง">
</body>
</html><?php
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

$column_check = mysqli_query($conn, "SHOW COLUMNS FROM movies LIKE 'id'");
$has_id_column = mysqli_num_rows($column_check) > 0;
$primary_key = $has_id_column ? 'id' : 'movie_id';

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
    
    // อัปโหลดรูปภาพ
    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image']);
    } else {
        $image = null;
    };

    if (!empty($nameM) && !empty($details) && !empty($price) && !empty($director) && !empty($category_Id) && $image) {
        $sql = "INSERT INTO movies (name, price, director, category_Id, description, image) VALUES ('$nameM', '$price', '$director', '$category_Id', '$details', '$image')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>✅ เพิ่มหนังสำเร็จ!</p>";
         
            
            // echo "<img src="/photo/"" . $image . " alt="">";
        } else {
            echo "<p style='color: red;'>❌ เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>⚠ กรุณากรอกข้อมูลให้ครบ และเลือกไฟล์รูปภาพที่ถูกต้อง</p>";
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

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหนัง</title>
</head>
<body>
<div class="container">
    <h1>เพิ่มหนัง</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="ชื่อหนัง" required>
        <input type="text" name="details" placeholder="รายละเอียด" required>
        <input type="number" name="price" placeholder="ราคา" required>
        <input type="text" name="director" placeholder="ผู้กำกับ" required>
        <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
        <input type="file" name="image" required>
        <button type="submit" name="add_movie">เพิ่มหนัง</button>
        <img src="photo/banner.png" alt="">
    </form>

    <h1>แก้ไขหนัง</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="number" name="movie_id" placeholder="รหัสหนัง" required>
        <input type="text" name="name" placeholder="ชื่อหนัง" required>
        <input type="text" name="details" placeholder="รายละเอียด" required>
        <input type="number" name="price" placeholder="ราคา" required>
        <input type="text" name="director" placeholder="ผู้กำกับ" required>
        <input type="text" name="category_Id" placeholder="หมวดหมู่" required>
        <input type="file" name="image">
        <button type="submit" name="edit_movie">แก้ไขหนัง</button>
    </form>
</div>
</body>
</html>
