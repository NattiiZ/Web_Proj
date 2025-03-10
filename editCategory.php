<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// เพิ่มหมวดหมู่
if (isset($_POST['add_category'])) {
    $category = $_POST['category_name'] ?? '';
    if ($category != '') {
        $sql = "INSERT INTO category (name) VALUES ('$category')";
        if ($conn->query($sql)) {
            echo "<script>alert('เพิ่มหมวดหมู่สำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่');</script>";
        }
    } else {
        echo "<script>alert('กรุณากรอกชื่อหมวดหมู่');</script>";
    }
}

// แก้ไขหมวดหมู่
if (isset($_POST['edit_category'])) {
    $id = $_POST['edit_id'] ?? '';
    $category = $_POST['edit_category_name'] ?? '';
    if ($id != '' && $category != '') {
        $sql = "UPDATE category SET name = '$category' WHERE category_id = '$id'";
        if ($conn->query($sql)) {
            echo "<script>alert('แก้ไขหมวดหมู่สำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการแก้ไขหมวดหมู่');</script>";
        }
    }
}

// ลบหมวดหมู่
if (isset($_POST['delete_category'])) {
    $id = $_POST['delete_id'] ?? '';
    if ($id != '') {
        $sql = "DELETE FROM category WHERE category_id = '$id'";
        if ($conn->query($sql)) {
            echo "<script>alert('ลบหมวดหมู่สำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบหมวดหมู่');</script>";
        }
    }
}

// ดึงข้อมูลหมวดหมู่
$sqltxt = "SELECT * FROM category";
$result = mysqli_query($conn, $sqltxt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่หนัง</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #ff9a9e, #fad0c4); text-align: center; margin: 0; padding: 0; }
        .container { width: 80%; background: white; padding: 20px; margin: 50px auto; border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); }
        h1, h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"] { width: 60%; padding: 10px; border: 2px solid #ff758c; border-radius: 5px; font-size: 16px; }
        button { background: #ff758c; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        button:hover { background: #ff5c75; }
        .category-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        .category-table th, .category-table td { border: 1px solid #ddd; padding: 10px; }
        .category-table th { background: #f2f2f2; }
        .edit-form input[type="text"] { width: auto; padding: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .delete-btn { background: #ff4d4d; }
        .delete-btn:hover { background: #e60000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>จัดการหมวดหมู่หนัง</h1>
        <h2>เพิ่มหมวดหมู่</h2>
        <form method="POST">
            <input type="text" name="category_name" placeholder="ชื่อหมวดหมู่" required>
            <button type="submit" name="add_category">เพิ่มหมวดหมู่</button>
        </form>
        <h2>รายการหมวดหมู่</h2>
        <table class="category-table">
            <tr>
                <th>ชื่อหมวดหมู่</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
            <?php while ($rs = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $rs['name']; ?></td>
                    <td>
                        <form method="POST" class="edit-form">
                            <input type="hidden" name="edit_id" value="<?php echo $rs['category_id']; ?>">
                            <input type="text" name="edit_category_name" value="<?php echo $rs['name']; ?>" required>
                            <button type="submit" name="edit_category">แก้ไข</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="delete_id" value="<?php echo $rs['category_id']; ?>">
                            <button type="submit" name="delete_category" class="delete-btn" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบหมวดหมู่นี้?');">ลบ</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <div class="back-button">
            <a href="javascript:history.back()">กลับ</a>
        </div>
    </div>
</body>
</html>
