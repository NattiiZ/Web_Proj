<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['Username'] . "'"; 
$result = $conn->query($sql);

// ดึงประวัติการจองตั๋วของผู้ใช้ (แสดงแค่ ชื่อหนัง จำนวนตั๋ว และเวลา)
$sql_booking = "SELECT movies.name AS movie_name, orders.ticketQty AS tickets, 
                CONCAT(DATE_FORMAT(showtimes.date, '%d-%m-%Y'), ' ', DATE_FORMAT(showtimes.time, '%H:%i:%s')) AS order_time
                FROM orders 
                JOIN movies ON orders.movie_id = movies.movie_id 
                JOIN showtimes ON orders.show_id = showtimes.show_id
                WHERE orders.user_id = (SELECT user_id FROM users WHERE username = '" . $_SESSION['Username'] . "')";


$booking_result = $conn->query($sql_booking);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลส่วนตัว</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2e3a59;
            font-size: 36px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: rgb(75, 129, 236);
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e4f2e4;
            transition: background-color 0.3s ease;
        }

        .logout-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #f44336;
            color: white;
            text-align: center;
            font-size: 16px;
            border-radius: 25px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
            cursor: pointer;
        }

        .edit-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            text-align: center;
            font-size: 16px;
            border-radius: 25px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #388e3c;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ข้อมูลส่วนตัว</h1>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>อีเมล์</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>ไม่พบข้อมูล</p>
        <?php endif; ?>

        <!-- เพิ่มประวัติการจอง -->
        <h2>ประวัติการจองตั๋ว</h2>
        <?php if ($booking_result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อภาพยนตร์</th>
                        <th>วันที่ / เวลา</th>
                        <th>จำนวนตั๋ว</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $booking_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $booking['movie_name']; ?></td>
                            <td><?php echo $booking['order_time']; ?></td>
                            <td><?php echo $booking['tickets']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>ยังไม่มีการจองตั๋ว</p>
        <?php endif; ?>

        <button onclick="window.history.back()" class="edit-btn">กลับ</button>
        <!-- ปุ่มออกจากระบบ -->
        <a href="logout.php" class="logout-btn">ออกจากระบบ</a>

        <!-- ปุ่มแก้ไขข้อมูล -->
        <a href="edit_profile.php" class="edit-btn">แก้ไขข้อมูล</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
