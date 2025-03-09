<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // เปลี่ยนเป็นของคุณ
$password = "";
$dbname = "movie_db";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
// }

// เพิ่มหนัง
if (isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];

    $sql = "INSERT INTO movies (title, genre, release_year) VALUES ('$title', '$genre', '$release_year')";
    $conn->query($sql);
}

// แก้ไขหนัง
if (isset($_POST['edit_movie'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];

    $sql = "UPDATE movies SET title='$title', genre='$genre', release_year='$release_year' WHERE id=$id";
    $conn->query($sql);
}

// ลบหนัง
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM movies WHERE id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลหนังทั้งหมด
// $movies = $conn->query("SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แอดมินจัดการหนัง</title>
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
    <h1>แอดมินจัดการหนัง</h1>

    <!-- ฟอร์มเพิ่มหนัง -->
    <h2>เพิ่มหนังใหม่</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="ชื่อหนัง" required>
        <input type="text" name="genre" placeholder="แนวหนัง" required>
        <input type="number" name="release_year" placeholder="ปีที่ออกฉาย" required>
        <button type="submit" name="add_movie">เพิ่มหนัง</button>
    </form>

    <!-- ตารางแสดงรายการหนัง -->
    <h2>รายการหนัง</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อหนัง</th>
            <th>แนวหนัง</th>
            <th>ปีที่ออกฉาย</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <!-- <?php while ($row = $movies->fetch_assoc()): ?> -->
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['genre'] ?></td>
                <td><?= $row['release_year'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['title'] ?>', '<?= $row['genre'] ?>', '<?= $row['release_year'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('ยืนยันการลบ?');">🗑 ลบ</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ฟอร์มแก้ไขหนัง -->
    <div id="editFormContainer" style="display: none;">
        <h2>แก้ไขหนัง</h2>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="title" id="edit_title" required>
            <input type="text" name="genre" id="edit_genre" required>
            <input type="number" name="release_year" id="edit_release_year" required>
            <button type="submit" name="edit_movie">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>

    <script>
        function showEditForm(id, title, genre, year) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_genre').value = genre;
            document.getElementById('edit_release_year').value = year;
        }
    </script>
</body>
</html>
