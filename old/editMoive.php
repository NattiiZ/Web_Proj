<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 1) {
    header("Location: login.php"); // ถ้าไม่ใช่แอดมิน ส่งกลับหน้า login
    exit();
}


$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ดึงหมวดหมู่
$categories = mysqli_query($conn, "SELECT * FROM category");

// ดึงสถานะ
$statuses = mysqli_query($conn, "SELECT * FROM status");

// ฟังก์ชันอัปโหลดรูปภาพ
function uploadImage($file)
{
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $newFileName = basename($file["name"]);
    $target_file = $target_dir . $newFileName;

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    $allowed_types = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        return false;
    }

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
    $status_Id = mysqli_real_escape_string($conn, $_POST['status_Id']);

    $image = !empty($_FILES['image']['name']) ? uploadImage($_FILES['image']) : null;

    if ($nameM && $details && $price && $director && $category_Id && $status_Id && $image) {
        $sql = "INSERT INTO movies (name, price, director, category_Id, status_Id, description, image) VALUES ('$nameM', '$price', '$director', '$category_Id', '$status_Id', '$details', '$image')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>✅ เพิ่มหนังสำเร็จ!</p>";
        } else {
            echo "<p style='color: red;'>❌ เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>⚠ กรุณากรอกข้อมูลให้ครบถ้วน</p>";
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

            <select name="category_Id" required>
                <option value="">เลือกหมวดหมู่</option>
                <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?php echo $category['category_id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="status_Id" required>
                <option value="">เลือกสถานะ</option>
                <?php while ($status = mysqli_fetch_assoc($statuses)): ?>
                    <option value="<?php echo $status['status_id']; ?>">
                        <?php echo htmlspecialchars($status['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="file" name="image" required>
            <button type="submit" name="add_movie">เพิ่มหนัง</button>
        </form>
    </div>
</body>

</html>