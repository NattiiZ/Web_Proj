<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

// ดึงข้อมูลรอบฉายที่ต้องการแก้ไข
if (isset($_GET['showtime_id'])) {
    $showtime_id = $_GET['showtime_id'];
    $showtime_result = $conn->query("SELECT * FROM showtimes WHERE show_id = $showtime_id");
    $showtime = $showtime_result->fetch_assoc();
}

// แก้ไขข้อมูลรอบฉาย
if (isset($_POST['edit_showtime'])) {
    $showtime_id = $_POST['showtime_id'];
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $stmt = $conn->prepare("UPDATE showtimes SET movie_id=?, date=?, time=? WHERE show_id=?");
    $stmt->bind_param("issi", $movie_id, $show_date, $show_time, $showtime_id);
    $stmt->execute();
    $stmt->close();

    header("Location: showtimes.php");
    exit;
}

// ดึงข้อมูลหนังทั้งหมด
$movies = $conn->query("SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรอบฉาย</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 30px;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        select, input[type="date"], input[type="time"], button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .cancel-btn {
            background-color: #dc3545;
        }
        .cancel-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <header>
        <h1>แก้ไขรอบฉาย</h1>
    </header>

    <main>
        <h2>แก้ไขรอบฉาย: <?= htmlspecialchars($showtime['show_id']) ?></h2>

        <form method="POST">
            <!-- <input type="hidden" name="showtime_id" value="<?= $showtime['show_id'] ?>"> -->

            <label for="movie_id">เลือกหนัง:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">เลือกหนัง</option>
                <?php while ($row = $movies->fetch_assoc()): ?>
                    <option value="<?= $row['movie_id'] ?>" <?= $row['movie_id'] == $showtime['movie_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="show_date">วันที่:</label>
            <input type="date" name="show_date" id="show_date" value="<?= $showtime['date'] ?>" required>

            <label for="show_time">เวลา:</label>
            <input type="time" name="show_time" id="show_time" value="<?= $showtime['time'] ?>" required>

            <button type="submit" name="edit_showtime">บันทึกการแก้ไข</button>
            <a href="showtimes.php" class="cancel-btn"><button type="button">ยกเลิก</button></a>
        </form>
    </main>

</body>
</html>
