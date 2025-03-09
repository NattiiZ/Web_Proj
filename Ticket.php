<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['Username'])) {
    // ถ้ายังไม่ได้ล็อกอิน ส่งกลับไปที่หน้า login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // เก็บ URL ปัจจุบันใน session
    header("Location: login.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "movie_ticket");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับค่า movie_id จาก URL
$movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ตรวจสอบว่า movie_id ถูกต้องหรือไม่
if ($movie_id <= 0) {
    die("❌ ข้อมูลไม่ถูกต้อง");
}

// ดึงข้อมูลภาพยนตร์ตาม movie_id
$stmt = $conn->prepare("SELECT * FROM movies WHERE movie_id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ ไม่พบข้อมูลภาพยนตร์");
}

$movie = $result->fetch_assoc();

// ดึงข้อมูลรอบฉายจากตาราง showtimes
$showtime_stmt = $conn->prepare("SELECT show_id, time, movie_id, seats FROM showtimes WHERE movie_id = ?");
$showtime_stmt->bind_param("i", $movie_id);
$showtime_stmt->execute();

// ผูกผลลัพธ์
$showtime_stmt->bind_result($showtime_id, $time, $movie_id, $seats);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <title>รายละเอียดการจอง</title>
</head>

<body>
    <h1>รายละเอียดการจอง</h1>
    <p>ชื่อภาพยนตร์: <?= htmlspecialchars($movie['name']) ?></p>
    <p>ราคาตั๋ว: <?= number_format($movie['price'], 2) ?> บาท</p>

    <!-- แบบฟอร์มการจอง -->
    <form method="POST" action="confirm.php">
        <input type="hidden" name="movie_id" value="<?= (int)$movie['movie_id'] ?>">

        <!-- ดรอปดาวน์เลือกเวลา -->
        <label for="showtime">เลือกเวลารอบฉาย:</label>
        <select name="showtime" id="showtime" required>
            <option value="">เลือกเวลา</option>
            <?php while ($showtime_stmt->fetch()): ?>
                <option value="<?= htmlspecialchars($showtime_id) ?>">
                    <?= htmlspecialchars($time) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        <label for="tickets">จำนวนตั๋ว:</label>
        <input type="number" name="tickets" id="tickets" value="1" min="1" required>
        <button type="submit">ยืนยันการจอง</button>
    </form>
</body>

</html>

<?php 
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn); 
?>
