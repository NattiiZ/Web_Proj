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

// เพิ่มผู้ใช้
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);
}

// แก้ไขผู้ใช้
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    $conn->query($sql);
}

// ลบผู้ใช้
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
// $users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 60%;
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
    <h1>จัดการผู้ใช้</h1>

    <!-- ฟอร์มเพิ่มผู้ใช้ -->
    <h2>เพิ่มผู้ใช้</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="ชื่อผู้ใช้" required>
        <input type="email" name="email" placeholder="อีเมล" required>
        <button type="submit" name="add_user">เพิ่มผู้ใช้</button>
    </form>

    <!-- ตารางแสดงรายการผู้ใช้ -->
    <h2>รายการผู้ใช้</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อ</th>
            <th>อีเมล</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <!-- <?php while ($row = $users->fetch_assoc()): ?> -->
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['name'] ?>', '<?= $row['email'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ฟอร์มแก้ไขผู้ใช้ -->
    <div id="editFormContainer" style="display: none;">
        <h2>แก้ไขผู้ใช้</h2>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="name" id="edit_name" required>
            <input type="email" name="email" id="edit_email" required>
            <button type="submit" name="edit_user">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>

    <script>
        function showEditForm(id, name, email) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
        }
    </script>
</body>
</html>
