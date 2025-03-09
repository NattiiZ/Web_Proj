<?php
// เริ่มต้น session
session_start();

// ลบข้อมูล session ทั้งหมด
session_unset();

// ลdestroy session
session_destroy();

// เปลี่ยนเส้นทางไปที่หน้าแรกหรือหน้าอื่น ๆ ที่ต้องการ
header("Location: index.php");
exit();
?>
