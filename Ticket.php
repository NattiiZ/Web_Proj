<?php
session_start();

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

// เชื่อมต่อ MySQL
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("<script>alert('❌ การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error() . "');</script>");
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
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .movie-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .movie {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .movie img {
            width: 100%;
            border-radius: 10px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .quantity-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }
        .quantity-btn:hover {
            background-color: #0056b3;
        }
        .pay-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }
        .pay-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1>🎬 จองตั๋วหนัง 🎟️</h1>
    <div class="movie-container">
        <?php while ($movie = mysqli_fetch_assoc($result)) { ?>
            <div class="movie">
                <img src="photo/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>">
                <h2><?= htmlspecialchars($movie['name']) ?></h2>
                <p>ฉายเวลา: <?= isset($movie['showtime']) ? htmlspecialchars($movie['showtime']) : 'ไม่ระบุ' ?></p>
                <p>ราคาตั๋ว: <span id="price-<?= (int)$movie['id'] ?>">
                <?= isset($movie['price']) ? number_format((float)$movie['price'], 2) : '0.00' ?>
                </span> บาท</p>

                <div class="quantity-control">
                    <button onclick="changeQuantity(<?= (int)$movie['id'] ?>, -1)">-</button>
                    <span id="quantity-<?= $movie['id'] ?>">1</span>
                    <button class="quantity-btn" onclick="changeQuantity(<?= (int)$movie['id'] ?>, 1)">+</button>
                </div>

                <p>ราคารวม: <span id="total-<?= $movie['id'] ?>"><?= number_format($movie['price'], 2) ?></span> บาท</p>

                <form method="POST">
                    <input type="hidden" name="movie_id" value="<?= (int)$movie['id'] ?>">
                    <input type="hidden" id="hidden-quantity-<?= $movie['id'] ?>" name="tickets" value="1">
                    <input type="hidden" id="hidden-price-<?= $movie['id'] ?>" name="total_price" value="<?= $movie['price'] ?>">
                    <button type="submit" class="pay-btn">จองเลย</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <script>
        function changeQuantity(movieId, change) {
            let quantityElement = document.getElementById("quantity-" + movieId);
            let totalPriceElement = document.getElementById("total-" + movieId);
            let priceElement = document.getElementById("price-" + movieId);
            let hiddenQuantity = document.getElementById("hidden-quantity-" + movieId);
            let hiddenPrice = document.getElementById("hidden-price-" + movieId);

            let quantity = parseInt(quantityElement.innerText);
            let pricePerUnit = parseFloat(priceElement.innerText.replace(',', ''));
            
            quantity += change;
            if (quantity < 1) quantity = 1; 

            let totalPrice = quantity * pricePerUnit;

            quantityElement.innerText = quantity;
            totalPriceElement.innerText = totalPrice.toLocaleString();
            hiddenQuantity.value = quantity;
            hiddenPrice.value = totalPrice;
        }
    </script>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = intval($_POST['movie_id'] ?? 0);
    $tickets = intval($_POST['tickets'] ?? 1);
    $total_price = floatval($_POST['total_price'] ?? 0.0);

    if ($movie_id <= 0 || $tickets < 1) {
        die("<script>alert('⚠️ ข้อมูลไม่ถูกต้อง');</script>");
    }

    $stmt = $conn->prepare("SELECT id FROM movies WHERE id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("<script>alert('❌ ไม่พบข้อมูลภาพยนตร์');</script>");
    }

    $stmt = $conn->prepare("INSERT INTO orders (movie_id, tickets, total_price, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iid", $movie_id, $tickets, $total_price);
    if ($stmt->execute()) {
        echo "<script>alert('✅ จองตั๋วสำเร็จ! 🎟️\n💰 ยอดชำระ: " . number_format($total_price, 2) . " บาท'); window.location.href='Ticket.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการจอง');</script>";
    }
}

mysqli_close($conn);
?>
</html>