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

// ดึงรายชื่อหนังจากฐานข้อมูล
// $movies = $conn->query("SELECT * FROM movies");

// เพิ่มรอบฉาย
if (isset($_POST['add_showtime'])) {
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $sql = "INSERT INTO showtimes (movie_id, show_date, show_time) VALUES ('$movie_id', '$show_date', '$show_time')";
    $conn->query($sql);
}

// แก้ไขรอบฉาย
if (isset($_POST['edit_showtime'])) {
    $id = $_POST['id'];
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $sql = "UPDATE showtimes SET movie_id='$movie_id', show_date='$show_date', show_time='$show_time' WHERE id=$id";
    $conn->query($sql);
}

// ลบรอบฉาย
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM showtimes WHERE id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลรอบฉายทั้งหมด
// $showtimes = $conn->query("SELECT showtimes.id, movies.title, showtimes.show_date, showtimes.show_time 
//                            FROM showtimes JOIN movies ON showtimes.movie_id = movies.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรอบฉายหนัง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 80%;
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
        input, select, button {
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
    <h1>จัดการรอบฉายหนัง</h1>

    <!-- ฟอร์มเพิ่มรอบฉาย -->
    <h2>เพิ่มรอบฉาย</h2>
    <form method="POST">
        <select name="movie_id" required>
            <option value="">เลือกหนัง</option>
            <?php while ($row = $movies->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="date" name="show_date" required>
        <input type="time" name="show_time" required>
        <button type="submit" name="add_showtime">เพิ่มรอบฉาย</button>
    </form>

    <!-- ตารางแสดงรายการรอบฉาย -->
    <h2>รายการรอบฉาย</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อหนัง</th>
            <th>วันที่ฉาย</th>
            <th>เวลาฉาย</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <?php while ($row = $showtimes->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['show_date'] ?></td>
                <td><?= $row['show_time'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['title'] ?>', '<?= $row['show_date'] ?>', '<?= $row['show_time'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ฟอร์มแก้ไขรอบฉาย -->
    <div id="editFormContainer" style="display: none;">
        <h2>แก้ไขรอบฉาย</h2>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <select name="movie_id" id="edit_movie_id" required>
                <option value="">เลือกหนัง</option>
                <?php
                $movies->data_seek(0); // รีเซ็ต pointer ของ query
                while ($row = $movies->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                <?php endwhile; ?>
            </select>
            <input type="date" name="show_date" id="edit_show_date" required>
            <input type="time" name="show_time" id="edit_show_time" required>
            <button type="submit" name="edit_showtime">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>

    <script>
        function showEditForm(id, title, date, time) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_show_date').value = date;
            document.getElementById('edit_show_time').value = time;
        }
    </script>
</body>
</html>
