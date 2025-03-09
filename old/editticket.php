<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

$showtimes = $conn->query("SELECT showtimes.show_id, movies.name, showtimes.time 
        FROM showtimes 
        JOIN movies ON showtimes.movie_id = movies.movie_id");

// ดึงรายชื่อผู้ใช้จากฐานข้อมูล
 $users = $conn->query("SELECT * FROM users");

// เพิ่มการจองตั๋ว
if (isset($_POST['add_ticket'])) {
    $user_id = $_POST['user_id'];
    $showtime_id = $_POST['showtime_id'];
    $seat_number = $_POST['seat_number'];

    $sql = "INSERT INTO show (user_id, showtime_id, seat_number) VALUES ('$user_id', '$showtime_id', '$seat_number')";
    $conn->query($sql);
}

// แก้ไขการจองตั๋ว
if (isset($_POST['edit_ticket'])) {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $showtime_id = $_POST['showtime_id'];
    $seat_number = $_POST['seat_number'];

    $sql = "UPDATE tickets SET user_id='$user_id', showtime_id='$showtime_id', seat_number='$seat_number' WHERE id=$id";
    $conn->query($sql);
}

// ยกเลิกตั๋ว
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tickets WHERE id=$id";
    $conn->query($sql);
}

// ดึงข้อมูลการซื้อตั๋วทั้งหมด
// $tickets = $conn->query("SELECT tickets.id, users.name, movies.title, showtimes.show_date, showtimes.show_time, tickets.seat_number 
//                          FROM tickets 
//                          JOIN users ON tickets.user_id = users.id 
//                          JOIN showtimes ON tickets.showtime_id = showtimes.id 
//                          JOIN movies ON showtimes.movie_id = movies.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการตั๋วหนัง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        select, input, button {
            margin: 5px 0;
            padding: 10px;
        }
        button {
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgreen;
        }
        .edit-form {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: red;
        }
    </style>
</head>
<body>
    <h1>จัดการตั๋วหนัง</h1>

    <!-- ฟอร์มเพิ่มการซื้อตั๋ว -->
    <h2>ซื้อตั๋ว</h2>
    <form method="POST">
        <select name="user_id" required>
            <option value="">เลือกผู้ใช้</option>
            <?php while ($row = $users->fetch_assoc()): ?>
                <option value="<?= $row['user_id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>
        <select name="showtime_id" required>
            <option value="">เลือกรอบฉาย</option>
            <?php while ($row = $showtimes->fetch_assoc()): ?>
                <option value="<?= $row['show_id'] ?>"><?= $row['time'] ?> </option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="seat_number" placeholder="หมายเลขที่นั่ง" required>
        <button type="submit" name="add_ticket">ซื้อตั๋ว</button>
    </form>

    <!-- ตารางแสดงรายการตั๋วที่ซื้อ -->
    <h2>รายการตั๋ว</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อผู้จอง</th>
            <th>ชื่อหนัง</th>
            <th>วันที่ฉาย</th>
            <th>เวลาฉาย</th>
            <th>ที่นั่ง</th>
            <th>แก้ไข</th>
            <th>ยกเลิก</th>
        </tr>
        <!-- <?php while ($row = $tickets->fetch_assoc()): ?> -->
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['show_date'] ?></td>
                <td><?= $row['show_time'] ?></td>
                <td><?= $row['seat_number'] ?></td>
                <td>
                    <button onclick="showEditForm('<?= $row['id'] ?>', '<?= $row['name'] ?>', '<?= $row['title'] ?>', '<?= $row['show_date'] ?>', '<?= $row['show_time'] ?>', '<?= $row['seat_number'] ?>')">
                        ✏ แก้ไข
                    </button>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('ยืนยันการยกเลิก?');">🗑 ยกเลิก</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- ฟอร์มแก้ไขตั๋ว -->
    <div id="editFormContainer" style="display: none;">
        <h2>แก้ไขตั๋ว</h2>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="seat_number" id="edit_seat_number" required>
            <button type="submit" name="edit_ticket">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>

    <script>
        function showEditForm(id, user, movie, date, time, seat) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_seat_number').value = seat;
        }
    </script>
</body>
</html>