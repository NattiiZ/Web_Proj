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
$sql = 'SELECT movie_id, name, image FROM movies';
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
                    <a href="profile.php">ข้อมูลส่วนตัว</a> <!-- ลิงก์ไปยังหน้าข้อมูลส่วนตัว -->
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


<!-- <style>
    /* ตั้งค่าเบื้องต้น */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    /* โลโก้และเมนู */
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #222;
        padding: 10px 20px;
    }

    nav .logo img {
        height: 50px;
    }

    nav .nav-links {
        display: flex;
        gap: 20px;
    }

    nav a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        padding: 8px 16px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    nav a:hover {
        background-color: #575757;
    }

    nav .dropdown {
        position: relative;
    }

    nav .dropdown .dropbtn {
        background-color: #222;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    nav .dropdown-content {
        display: none;
        position: absolute;
        background-color: #333;
        min-width: 160px;
        z-index: 1;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    nav .dropdown:hover .dropdown-content {
        display: block;
    }

    nav .dropdown-content a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    nav .dropdown-content a:hover {
        background-color: #575757;
    }

    /* สไลด์แบนเนอร์ */
    .banner {
        width: 100%;
        max-height: 400px;
        overflow: hidden;
        margin-bottom: 40px;
    }

    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .swiper-slide img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
    }

    /* แสดงข้อมูลหนัง */
    .content {
        padding: 20px;
        text-align: center;
    }

    h1 {
        font-size: 32px;
        margin-bottom: 20px;
        color: #222;
    }

    .movies {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .movie {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s;
    }

    .movie:hover {
        transform: translateY(-10px);
    }

    .movie img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .movie p {
        padding: 10px;
        background-color: #f8f8f8;
        margin: 0;
        font-size: 18px;
        color: #444;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    .movie a {
        color: #333;
        text-decoration: none;
    }

    .ticket {
        padding: 10px;
        text-align: center;
    }

    .ticket .button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .ticket .button:hover {
        background-color: #0056b3;
    }

    /* ฟุตเตอร์ */
    footer {
        background-color: #222;
        color: white;
        text-align: center;
        padding: 20px;
    }

    footer p {
        margin: 0;
        font-size: 14px;
    }

    /* สไตล์ Swiper */
    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .swiper-pagination {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .swiper-pagination-bullet {
        background-color: #fff;
        opacity: 0.5;
        transition: opacity 0.3s;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
    }
</style> -->


</html>