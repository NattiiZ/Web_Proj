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
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0; // รับ user_id จากฟอร์ม
$ticket_price = isset($_POST['ticket_price']) ? floatval($_POST['ticket_price']) : 0.0; // รับราคาตั๋วจากฟอร์ม

// ตรวจสอบข้อมูลที่ได้รับ
if ($movie_id <= 0 || $show_id <= 0 || $tickets <= 0 || $user_id <= 0 || $ticket_price <= 0) {
    die("❌ ข้อมูลที่ส่งมามีความผิดพลาด");
}

// คำนวณราคาทั้งหมด
$total_price = $ticket_price * $tickets;

// สมมุติว่าในฐานข้อมูลของคุณมีตาราง orders ที่มีคอลัมน์
// order_id (auto increment), movie_id, show_id, tickets, total_price, booking_date (default CURRENT_TIMESTAMP)

$sql = "INSERT INTO orders (user_id, movie_id, ticketQty, totalPrice) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error);
}

$stmt->bind_param("iiii", $user_id, $movie_id, $tickets, $total_price); // ใช้ 'i' สำหรับทั้ง 4 ค่าที่เป็น integer



$stmt->bind_param("iiii", $user_id, $movie_id, $tickets, $total_price);

if ($stmt->execute()) {
    // การจองสำเร็จ สามารถเปลี่ยนเส้นทางไปยังหน้าสำหรับแสดงผลสำเร็จได้ เช่น booking_success.php
    header("Location: index.php");
    exit();
} else {
    echo "❌ เกิดข้อผิดพลาดในการจอง: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
