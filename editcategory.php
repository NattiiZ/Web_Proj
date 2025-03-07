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
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
    if ($conn->query($sql)) {
        echo "<script>alert('เพิ่มหมวดหมู่เรียบร้อยแล้ว');</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่');</script>";
    }
}

// แก้ไขหมวดหมู่
if (isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];
    $sql = "UPDATE categories SET name='$category_name' WHERE id=$id";
    $conn->query($sql);
}

// ลบหมวดหมู่
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่หนัง</title>
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
        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .category-table th, .category-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .category-table th {
            background: #f2f2f2;
        }
    </style>
</head>
<div class="container">
        <h1>จัดการหมวดหมู่หนัง</h1>

        <!-- ฟอร์มเพิ่มหมวดหมู่ -->
        <h2>เพิ่มหมวดหมู่</h2>
        <form method="POST" class="form-group">
            <th><input type="text" name="category_name" placeholder="ชื่อหมวดหมู่" required class="form-input"></th>
            <button type="submit" name="add_category" class="form-button">เพิ่มหมวดหมู่</button>
        </form>

        <!-- ตารางแสดงรายการหมวดหมู่ -->
        <h2>รายการหมวดหมู่</h2>
        <table class="category-table">
            <tr>
                <th>ID</th>
                <th>ชื่อหมวดหมู่</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td>
                        <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['name'] ?>')" class="edit-button">
                            ✏ แก้ไข
                        </button>
                    </td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- ฟอร์มแก้ไขหมวดหมู่ -->
        <div id="editFormContainer" class="edit-form-container" style="display: none;">
            <h2>แก้ไขหมวดหมู่</h2>
            <form class="edit-form" method="POST">
                <input type="hidden" name="id" id="edit_id" class="form-input">
                <input type="text" name="category_name" id="edit_category_name" required class="form-input">
                <button type="submit" name="edit_category" class="form-button">บันทึกการเปลี่ยนแปลง</button>
            </form>
        </div>
    </div>

    <script>
        function showEditForm(id, name) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_category_name').value = name;
        }
    </script>
</body>
</html>
