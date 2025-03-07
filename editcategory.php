<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // เปลี่ยนเป็นของคุณ
$password = "";
$dbname = "movie_db";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// เพิ่มหมวดหมู่
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
    $conn->query($sql);
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
// $categories = $conn->query("SELECT * FROM categories");
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่หนัง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 50%;
            margin: auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        input, button {
            margin: 5px 0;
            padding: 10px;
        }
        button {
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgreen;
        }
        .edit-form {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: red;
        }
    </style>
</head>
<body>
    <h1>จัดการหมวดหมู่หนัง</h1>

    <!-- ฟอร์มเพิ่มหมวดหมู่ -->
    <h2>เพิ่มหมวดหมู่</h2>
    <form method="POST">
        <input type="text" name="category_name" placeholder="ชื่อหมวดหมู่" required>
        <button type="submit" name="add_category">เพิ่มหมวดหมู่</button>
    </form>

    <!-- ตารางแสดงรายการหมวดหมู่ -->
    <h2>รายการหมวดหมู่</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อหมวดหมู่</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <!-- <?php while ($row = $categories->fetch_assoc()): ?> -->
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['name'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ฟอร์มแก้ไขหมวดหมู่ -->
    <div id="editFormContainer" style="display: none;">
        <h2>แก้ไขหมวดหมู่</h2>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="category_name" id="edit_category_name" required>
            <button type="submit" name="edit_category">บันทึกการเปลี่ยนแปลง</button>
        </form>
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
