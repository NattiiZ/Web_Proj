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

// ดึงข้อมูลหนัง
$sql = 'SELECT movie_id, name, image, status_id FROM movies';
$result = mysqli_query($conn, $sql);

// ตรวจสอบข้อผิดพลาด
if (!$result) {
    die("เกิดข้อผิดพลาดในการดึงข้อมูล: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>โปรแกรมฉายหนัง</title>
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
                <?php if (isset($_SESSION['Username'])): ?>
                    <a href="profile.php">ข้อมูลส่วนตัว</a>
                    <a href="logout.php">ออกจากระบบ</a>
                <?php else: ?>
                    <a href="login.php">เข้าสู่ระบบ</a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <div class="swiper-slide">
                            <a href="movie_detail.php?id=<?= $row['movie_id'] ?>">
                                <img src="uploads/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                                <?php if ($row['status'] == 3): ?>
                                    <div class="coming-soon">Coming Soon</div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </header>

    <div class="content">
        <h1>โปรแกรมหนัง</h1>
        <div class="movies">
            <?php
            // Move result pointer back to the beginning for displaying the list of movies below the banner
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result)): ?>
                <div class="movie">
                    <a href="movie_detail.php?id=<?= $row['movie_id'] ?>">
                        <img src="uploads/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                        <?php if ($row['status_id'] == 3): ?>
                            <div class="coming-soon">Coming Soon</div>
                        <?php endif; ?>
                    </a>
                    <p>
                        <a href="movie_detail.php?id=<?= $row['movie_id'] ?>">
                            <?= htmlspecialchars($row['name']) ?>
                        </a>
                    </p>
                    <p class="ticket">
                        <a href="Ticket.php?id=<?= $row['movie_id'] ?>" class="button">TICKET | จองตั๋ว</a>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Movie Theater. All rights reserved.</p>
    </footer>

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
