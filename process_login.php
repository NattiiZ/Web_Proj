<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
    } else {
        echo "รหัสผ่านไม่ถูกต้อง!";
    }
} else {
    echo "ไม่มีผู้ใช้นี้!";
}
?>
