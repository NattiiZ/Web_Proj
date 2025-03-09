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

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM users WHERE username = '" . $_SESSION['Username'] . "'"; // คำสั่ง SQL ที่ถูกต้อง
$result = $conn->query($sql);
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
            background-color:rgb(75, 129, 236);
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

        tbody tr td {
            transition: transform 0.3s ease-in-out;
        }

        tbody tr td:hover {
            transform: scale(1.05);
            color: #4CAF50;
        }

        p {
            text-align: center;
            color: #888;
            font-size: 18px;
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
                        <th>username</th>
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
        <!-- ปุ่มออกจากระบบ -->
        <a href="logout.php" class="logout-btn">ออกจากระบบ</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
