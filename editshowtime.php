<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงรายชื่อหนังจากฐานข้อมูล
$movies = $conn->query("SELECT * FROM movies");

// เพิ่มรอบฉาย
if (isset($_POST['add_showtime'])) {
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $stmt = $conn->prepare("INSERT INTO showtimes (movie_id, show_date, show_time) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $movie_id, $show_date, $show_time);
    $stmt->execute();
    $stmt->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// แก้ไขรอบฉาย
if (isset($_POST['edit_showtime'])) {
    $show_id = $_POST['showtime_id'];
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $stmt = $conn->prepare("UPDATE showtimes SET movie_id=?, show_date=?, show_time=? WHERE show_id=?");
    $stmt->bind_param("issi", $movie_id, $show_date, $show_time, $show_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// ลบรอบฉาย
if (isset($_GET['delete'])) {
    $show_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM showtimes WHERE show_id=?");
    $stmt->bind_param("i", $show_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// ดึงข้อมูลรอบฉายทั้งหมด
$showtimes = $conn->query("
    SELECT show_id AS showtime_id, movies.name AS title, showtimes.time 
    FROM showtimes 
    JOIN movies ON showtimes.movie_id = movies.movie_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการรอบฉายหนัง</title>
</head>
<body>
    <h1>จัดการรอบฉายหนัง</h1>
    <h2>เพิ่มรอบฉาย</h2>
    <form method="POST">
        <select name="movie_id" required>
            <option value="">เลือกหนัง</option>
            <?php while ($row = $movies->fetch_assoc()): ?>
                <option value="<?= $row['movie_id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="date" name="show_date" required>
        <input type="time" name="show_time" required>
        <button type="submit" name="add_showtime">เพิ่มรอบฉาย</button>
    </form>
    <h2>รายการรอบฉาย</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ชื่อหนัง</th>
            <th>เวลาฉาย</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <?php while ($row = $showtimes->fetch_assoc()): ?>
            <tr>
            <td>
            <button onclick="showEditForm(
                '<?= $row['showtime_id'] ?>', 
                '<?= isset($row['movie_id']) ? $row['movie_id'] : '' ?>', 
                '<?= isset($row['time']) ? $row['time'] : '' ?>'
                )">
        ✏ แก้ไข
    </button>
</td>
        <?php endwhile; ?>
    </table>
</body>
</html>