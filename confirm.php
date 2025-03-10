<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "movie_ticket");
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับค่าจากแบบฟอร์ม
$movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
$show_id = isset($_POST['showtime']) ? intval($_POST['showtime']) : 0;
$tickets = isset($_POST['tickets']) ? intval($_POST['tickets']) : 0;

// ตรวจสอบข้อมูลที่ได้รับ
if ($movie_id <= 0 || $show_id <= 0 || $tickets <= 0) {
    die("❌ ข้อมูลที่ส่งมามีความผิดพลาด");
}

// สมมุติว่าในฐานข้อมูลของคุณมีตาราง orders ที่มีคอลัมน์
// order_id (auto increment), movie_id, show_id, tickets, booking_date (default CURRENT_TIMESTAMP)
// หากชื่อตารางหรือคอลัมน์แตกต่างกัน ให้ปรับเปลี่ยนตามที่คุณกำหนด

$sql = "INSERT INTO orders (order_id, user_id, movie_id, ticketQty) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error);
}

$stmt->bind_param("iiii", $order_id, $user_id, $movie_id, $ticketQty);

if ($stmt->execute()) {
    // การจองสำเร็จ สามารถเปลี่ยนเส้นทางไปยังหน้าสำหรับแสดงผลสำเร็จได้ เช่น booking_success.php
    header("Location: booking_success.php");
    exit();
} else {
    echo "❌ เกิดข้อผิดพลาดในการจอง: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>