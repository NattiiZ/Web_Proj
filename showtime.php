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

<header>
<nav>
    <a href="index.php">
    <img src="photo/Malai_Cineplex.jpg" href="index.php" alt="logo">
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
    <!-- แบนเนอร์สไลด์ -->
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper"> 
                <div class="swiper-slide"><a href="Detailcompanion.php"><img src="photo/comper.jpg" alt="Banner 1"></a></div>
                <div class="swiper-slide"><a href="Detaildarknun.php"><img src="photo/Dacknun.jpg" alt="Banner 2"></a></div>
                <div class="swiper-slide"><a href="Detailsubstance.php"><img src="photo/substance.jpg" alt="Banner 3"></a></div>
             </div> 
            <!-- ปุ่มเลื่อน -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</header>

<body>
    <div class="content">
        <h1>โปรแกรมหนัง</h1>
        <div class="movies">
            <div class='movie'>
                <img src='photo/comper.jpg' alt='ภาพยนตร์เรื่องที่ 1'>
                <p><a href='Detailcompanion.php'>Companion | คอมแพเนียน </a></p>
                <p class='showtime'>ฉายเวลา: 12:30, 15:00, 18:00</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='photo/Dacknun.jpg' alt='ภาพยนตร์เรื่องที่ 2'>
                <p><a href='Detaildarknun.php'>Dark Nuns</a></p>
                <p class='showtime'>ฉายเวลา: 13:00, 16:00, 19:30</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='photo/substance.jpg' alt='ภาพยนตร์เรื่องที่ 3'>
                <p><a href='Detailsubstance.php'>The Substance | สวยสลับร่าง</a></p>
                <p class='showtime'>ฉายเวลา: 14:15, 17:45, 21:00</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
        </div>
    </div>

    <div class="imglogo">
        <img src="photo/logo.jpg" alt="logo">
        <img src="photo/logo1.jpg" alt="logo">
        <img src="photo/logo2.png" alt="logo">
        <img src="photo/logo3.jpg" alt="logo">
        
        
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
                delay: 3000, // เปลี่ยนภาพทุก 3 วินาที
                disableOnInteraction: false,
            }
        });
    </script>
</body>
</html>
