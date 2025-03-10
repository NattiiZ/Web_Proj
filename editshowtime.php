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
    /* ตั้งค่าพื้นฐาน */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #2d3b55;
        color: white;
        text-align: center;
        padding: 20px 0;
    }

    h1 {
        font-size: 2.5em;
        margin: 0;
    }

    main {
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    h2 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 20px;
    }

    h3 {
        font-size: 1.5em;
        color: #333;
        margin-top: 40px;
    }

    label {
        font-size: 1.1em;
        margin: 10px 0;
        display: block;
        color: #555;
    }

    select, input[type="date"], input[type="time"], button {
        width: 100%;
        padding: 12px;
        font-size: 1em;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    select, input[type="date"], input[type="time"] {
        background-color: #fff;
        transition: all 0.3s ease;
    }

    select:focus, input[type="date"]:focus, input[type="time"]:focus {
        border-color: #2d3b55;
        outline: none;
    }

    button {
        background-color: #2d3b55;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #3c4d70;
    }

    button:active {
        background-color: #1c2d44;
    }

    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    /* การตกแต่งสำหรับปุ่มลบ */
    .delete-btn {
        background-color: #ff4e4e;
        color: white;
        border: none;
        padding: 12px;
        font-size: 1.2em;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #ff3232;
    }

    .delete-btn:active {
        background-color: #e62424;
    }

    /* ให้ dropdown ดูดีขึ้น */
    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"><path fill="none" stroke="%23333" stroke-width="2" d="M1 1l4 4 4-4"/></svg>');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
    }

    /* เพิ่มการเคลื่อนไหวให้กับ select */
    select:focus {
        box-shadow: 0 0 8px rgba(45, 59, 85, 0.5);
    }

    /* ฟอร์มที่แสดงข้อมูล */
    form {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    form input[type="hidden"] {
        display: none;
    }

    form .form-actions {
        display: flex;
        justify-content: space-between;
    }

    /* ปรับแต่งการตั้งค่าของ dropdown และ input */
    select, input[type="date"], input[type="time"] {
        width: 48%;
    }

    /* ทำให้ปุ่มบันทึกกับปุ่มลบดูดีขึ้น */
    .form-actions button {
        width: 48%;
    }

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
