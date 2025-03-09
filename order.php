<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ดึงรายการภาพยนตร์จากฐานข้อมูล
$sql = "SELECT * FROM movies";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองตั๋วหนัง</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>จองตั๋วหนัง</h1>

    <div class="movies">
        <?php while ($movie = mysqli_fetch_assoc($result)) { ?>
            <div class="movie">
                <img src="photo/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>">
                <h2><?= htmlspecialchars($movie['name']) ?></h2>
                <p>ฉายเวลา: <?= htmlspecialchars($movie['showtime']) ?></p>
                <p>ราคาตั๋ว: <?= number_format($movie['price'], 2) ?> บาท</p>
                
                <!-- ฟอร์มจองตั๋ว -->
                <form action="order.php" method="POST">
                    <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                    <label>จำนวนตั๋ว:</label>
                    <input type="number" name="tickets" value="1" min="1" max="10">
                    <button type="submit">จองเลย</button>
                </form>
            </div>
        <?php } ?>
    </div>

</body>
</html>

<?php
// หากมีการส่งคำสั่งจองตั๋ว
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = intval($_POST['movie_id']);
    $tickets = intval($_POST['tickets']);

    if ($movie_id == 0 || $tickets < 1) {
        die("ข้อมูลไม่ถูกต้อง");
    }

    // ดึงราคาตั๋วจากฐานข้อมูล
    $stmt = $conn->prepare("SELECT price FROM movies WHERE id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();

    if (!$movie) {
        die("ไม่พบข้อมูลภาพยนตร์");
    }

    $total_price = $movie['price'] * $tickets;

    // บันทึกข้อมูลการจอง
    $stmt = $conn->prepare("INSERT INTO orders (movie_id, tickets, total_price, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iid", $movie_id, $tickets, $total_price);

    if ($stmt->execute()) {
        echo "<script>alert('จองตั๋วสำเร็จ!'); window.location.href='order.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($conn);
?>
