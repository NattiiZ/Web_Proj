<?php
session_start();

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
$showtime_stmt = $conn->prepare("SELECT show_id, time, date, movie_id, seats FROM showtimes WHERE movie_id = ?");
$showtime_stmt->bind_param("i", $movie_id);
$showtime_stmt->execute();
$showtime_result = $showtime_stmt->get_result(); // ดึงผลลัพธ์ของ showtimes query

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
$loggedIn = isset($_SESSION['Username']);
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
    <form method="POST" action="confirm.php" onsubmit="return checkLogin();">
        <input type="hidden" name="movie_id" value="<?= (int)$movie['movie_id'] ?>">
        <input type="hidden" name="user_id" value="<?= isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0 ?>"> <!-- ส่ง user_id ไปด้วย -->
        <input type="hidden" name="ticket_price" value="<?= number_format($movie['price'], 2) ?>"> <!-- ส่งราคาตั๋วไปด้วย -->

        <!-- ดรอปดาวน์เลือกเวลาและวัน -->
        <label for="showtime">เลือกเวลารอบฉาย:</label>
        <select name="showtime" id="showtime" required>
            <option value="">เลือกเวลา</option>
            <?php while ($showtime = $showtime_result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($showtime['show_id']) ?>" data-time="<?= htmlspecialchars($showtime['time']) ?>" data-date="<?= htmlspecialchars($showtime['date']) ?>">
                    <?= htmlspecialchars($showtime['time']) ?> (<?= htmlspecialchars($showtime['date']) ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        <label for="tickets">จำนวนตั๋ว:</label>
        <input type="number" name="tickets" id="tickets" value="1" min="1" required>
        <button type="submit">ยืนยันการจอง</button>
    </form>

    <script>
        // กำหนดตัวแปรจาก PHP เพื่อตรวจสอบสถานะล็อกอิน
        var isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;

        function checkLogin(){
            if (!isLoggedIn) {
                // Redirect ไปที่หน้า login พร้อมส่งพารามิเตอร์ redirect_url กลับมาหน้าเดิม
                window.location.href = "login.php?redirect_url=" + encodeURIComponent(window.location.href);
                return false; // ป้องกันการส่งฟอร์ม
            }

            // ส่งค่า show_id ไปยัง confirm.php
            var selectedOption = document.getElementById('showtime').selectedOptions[0];
            var show_id = selectedOption.value;  // รับค่า show_id จาก option ที่ถูกเลือก

            // เพิ่ม show_id ในฟอร์ม
            var showtimeInput = document.createElement('input');
            showtimeInput.type = 'hidden';
            showtimeInput.name = 'show_id';  // ตั้งชื่อให้ตรงกับที่ใช้ใน confirm.php
            showtimeInput.value = show_id;
            document.forms[0].appendChild(showtimeInput);

            return true;
        }
    </script>
</body>

</html>

<?php 
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close(); 
?>
