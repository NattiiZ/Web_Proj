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

// ดึงข้อมูลหนังทั้งหมด
$movies = $conn->query("SELECT * FROM movies");

// แก้ไขข้อมูลรอบฉาย
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_showtime'])) {
        // แก้ไขรอบฉาย
        $showtime_id = intval($_POST['showtime_id']);
        $movie_id = intval($_POST['movie_id']);
        $show_date = $_POST['show_date'];
        $show_time = $_POST['show_time'];

        $stmt = $conn->prepare("UPDATE showtimes SET movie_id=?, date=?, time=? WHERE show_id=?");
        $stmt->bind_param("issi", $movie_id, $show_date, $show_time, $showtime_id);
        $stmt->execute();
        $stmt->close();

        header("Location: edit_or_delete_showtime.php");
        exit;
    }

    if (isset($_POST['delete_showtime'])) {
        // ลบรอบฉาย
        $showtime_id = intval($_POST['showtime_id']);
        $stmt = $conn->prepare("DELETE FROM showtimes WHERE show_id=?");
        $stmt->bind_param("i", $showtime_id);
        $stmt->execute();
        $stmt->close();

        header("Location: editshowtime.php");
        exit;
    }
}

// ดึงข้อมูลรอบฉายที่ต้องการแก้ไข
$showtime = null;
if (isset($_GET['showtime_id'])) {
    $showtime_id = intval($_GET['showtime_id']);
    $stmt = $conn->prepare("SELECT * FROM showtimes WHERE show_id = ?");
    $stmt->bind_param("i", $showtime_id);
    $stmt->execute();
    $showtime_result = $stmt->get_result();
    $showtime = $showtime_result->fetch_assoc();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขหรือลบรอบฉาย</title>
    <style>
        /* Your existing CSS code */
    </style>
    <script>
        // ฟังก์ชันดึงข้อมูลที่เกี่ยวข้องกับหนัง
        function fetchShowtimeDetails(movieId) {
            if (movieId == "") {
                document.getElementById("show_date").value = "";
                document.getElementById("show_time").value = "";
                return;
            }

            // ส่งคำขอไปยัง PHP เพื่อดึงข้อมูลที่เกี่ยวข้อง
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_showtime_details.php?movie_id=" + movieId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response) {
                        document.getElementById("show_date").value = response.date;
                        document.getElementById("show_time").value = response.time;
                    }
                }
            };
            xhr.send();
        }
    </script>
</head>

<body>

    <header>
        <h1>แก้ไขหรือลบรอบฉาย</h1>
    </header>

    <main>
        <h2>เลือกหนังเพื่อแก้ไขหรือลบรอบฉาย</h2>

        <!-- เลือกหนังจาก Dropdown -->
        <form method="GET">
            <label for="showtime_id">เลือกหนังที่ต้องการแก้ไขหรือลบ:</label>
            <select name="showtime_id" id="showtime_id" onchange="this.form.submit()">
                <option value="">เลือกหนัง</option>
                <?php
                // ดึงรายการหนังทั้งหมดจากฐานข้อมูล
                $stmt = $conn->query("SELECT * FROM showtimes JOIN movies ON showtimes.movie_id = movies.movie_id");
                while ($row = $stmt->fetch_assoc()) :
                ?>
                    <option value="<?= $row['show_id'] ?>" <?= isset($showtime) && $showtime['show_id'] == $row['show_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php if ($showtime): ?>
        <!-- แสดงข้อมูลรอบฉายที่เลือก -->
        <h3>แก้ไขข้อมูลรอบฉาย:</h3>

        <form method="POST">
            <input type="hidden" name="showtime_id" value="<?= htmlspecialchars($showtime['show_id']) ?>">

            <label for="movie_id">เลือกหนัง:</label>
            <select name="movie_id" id="movie_id" required onchange="fetchShowtimeDetails(this.value)">
                <option value="">เลือกหนัง</option>
                <?php
                // ดึงรายการหนังทั้งหมด
                $movies = $conn->query("SELECT * FROM movies");
                while ($row = $movies->fetch_assoc()):
                ?>
                    <option value="<?= $row['movie_id'] ?>" <?= $row['movie_id'] == $showtime['movie_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="show_date">วันที่:</label>
            <input type="date" name="show_date" id="show_date" value="<?= htmlspecialchars($showtime['date']) ?>" required>

            <label for="show_time">เวลา:</label>
            <input type="time" name="show_time" id="show_time" value="<?= htmlspecialchars($showtime['time']) ?>" required>

            <!-- ปุ่มสำหรับแก้ไข -->
            <button type="submit" name="edit_showtime">บันทึกการแก้ไข</button>
        </form>

        <form method="POST" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบรอบฉายนี้?');">
            <input type="hidden" name="showtime_id" value="<?= htmlspecialchars($showtime['show_id']) ?>">
            <!-- ปุ่มสำหรับลบ -->
            <button type="submit" name="delete_showtime" style="background-color: red;">ลบรอบฉาย</button>
        </form>

        <?php endif; ?>
    </main>

</body>

</html>
