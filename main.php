<<<<<<< HEAD:main.php
<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรก - ระบบจองตั๋วหนัง</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav>
        <a href="index.php">หน้าแรก</a>
        <a href="showtime.php">โปรแกรมฉายหนัง</a>
        <a href="register.php">ลงทะเบียน</a> |
        <a href="login.php">เข้าสู่ระบบ</a>
    </nav>
</header>

<div class="banner">

    <img src="banner.jpg" alt="โปรโมตหนัง"><br>

</div>


<div class="container">
    <h1>โปรแกรมหนัง</h1>
</div>

</body>
</html>
=======
<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ดึงข้อมูลภาพยนตร์จากฐานข้อมูล
$sql = "SELECT * FROM movies ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมฉายหนัง</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
</head>

<body>

<header>
    <nav>
        <a href="index.php" class="logo">
            <img src="photo/Malai_Cineplex.jpg" alt="logo">
        </a>
        <div class="nav-links">
            <a href="index.php">หน้าแรก</a>
            <div class="dropdown">
                <button class="dropbtn">โปรแกรมหนัง</button>
                <div class="dropdown-content">
                    <a href="showtime.php">โปรแกรมฉายหนัง</a>
                    <a href="upcoming.php">โปรแกรมหน้า</a>
                </div>
            </div>
            <a href="register.php">ลงทะเบียน</a> |
            <a href="login.php">เข้าสู่ระบบ</a>
        </div>
    </nav>
</header>

<!-- แบนเนอร์สไลด์ -->
<div class="banner">
    <div class="swiper-container">
        <div class="swiper-wrapper"> 
            <div class="swiper-slide"><a href="Detailcompanion.php"><img src="photo/comper.jpg" alt="Banner 1"></a></div>
            <div class="swiper-slide"><a href="Detaildarknun.php"><img src="photo/Dacknun.jpg" alt="Banner 2"></a></div>
            <div class="swiper-slide"><a href="Detailsubstance.php"><img src="photo/substance.jpg" alt="Banner 3"></a></div>
        </div> 
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<div class="content">
    <h1>โปรแกรมหนัง</h1>
    <div class="movies">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="movie">
                <a href="movie_detail.php?id=<?= $row['id'] ?>">
                    <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                </a>
                <p>
                    <a href="movie_detail.php?id=<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['name']) ?>
                    </a>
                </p>
                <p class='showtime'>ฉายเวลา: <?= htmlspecialchars($row['showtime']) ?></p>
                <p class="ticket">
                    <a href="Ticket.php?id=<?= $row['id'] ?>" class="button">TICKET | จองตั๋ว</a>
                </p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<footer>
    <p>&copy; 2025 Movie Theater. All rights reserved.</p>
</footer>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        }
    });
</script>

</body>
</html>
>>>>>>> ea0292429a7640fbe9279911a23c8c8a9669e5ed:index.php
