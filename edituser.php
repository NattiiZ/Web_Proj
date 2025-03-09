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

    $sql = "UPDATE users SET name='$name', email='$email' WHERE user_id=$id";
    $conn->query($sql);
}

// ลบผู้ใช้
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE user_id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
            text-align: center;
            padding: 20px;
        }

        h1, h2 {
            color: white;
            margin-bottom: 10px;
        }

        table {
            width: 70%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #ff4081;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background: #ffe5ec;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 320px;
            margin: 20px auto;
            padding: 25px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        input, button {
            margin: 10px 0;
            padding: 12px;
            border: 2px solid #ff4081;
            border-radius: 25px;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #d81b60;
            box-shadow: 0px 0px 10px rgba(216, 27, 96, 0.3);
        }

        button {
            background-color: #ff4081;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 5px 15px rgba(255, 64, 129, 0.3);
        }

        button:hover {
            background-color: #d81b60;
            box-shadow: 0px 7px 20px rgba(216, 27, 96, 0.5);
        }

        button:active {
            transform: scale(0.95);
        }

        .edit-form {
            background: rgba(255, 255, 255, 0.8);
        }

        a {
            text-decoration: none;
            color: #ff4081;
            font-weight: bold;
            transition: 0.3s;
        }

        a:hover {
            color: #d81b60;
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
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['user_id'] ?>', '<?= $row['name'] ?>', '<?= $row['email'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['user_id'] ?>" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
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
