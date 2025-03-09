<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมหน้า</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">

    
    
</head>


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

    <!-- แบนเนอร์สไลด์ -->
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper"> 
                <div class="swiper-slide"><a href="Detailnovocaine.php"><img src="photo/novocaine.jpg" alt="Banner 1"></a></div>
                <div class="swiper-slide"><a href="Detailnaja2.php"><img src="photo/naja2.jpg" alt="Banner 2"></a></div>
                <div class="swiper-slide"><a href="Detailsnowwhite.php"><img src="photo/snowwhite.jpg" alt="Banner 3"></a></div>
             </div> 
            <!-- ปุ่มเลื่อน -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            
        </div>
    </div>
    </header>

    <div class="content">
        <h1>โปรแกรมหน้า</h1>
        <div class="movies">
            <div class='movie'>
                <a href="Detailnovocaine.php"><img src="photo/novocaine.jpg" alt='ภาพยนตร์เรื่องที่ 1'>
                <p><a href='Detailnovocaine.php'>Novocaine มิสเตอร์โคตรคนทรหด</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <a href="Detailnaja2.php"><img src="photo/naja2.jpg" alt='ภาพยนตร์เรื่องที่ 2'>
                <p><a href='Detailnaja2.php'>นาจา 2</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <a href="Detailmulunaku.php"><img src="photo/mulunaku.jpg" alt='ภาพยนตร์เรื่องที่ 3'>
                <p><a href='Detailmulunaku.php'>มูลู หน้าครู</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class="movie">
                <a href="Detailsnowwhite.php"><img src="photo/snowwhite.jpg" alt="ภาพยนตร์เรื่องที่ 4">
                <p><a href="Detailsnowwhite.php">snowwhite | สโนว์ไวท์ </a></p>
                <p class="showtime">วันที่เข้าฉาย: 20 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>

            </div>
            <div class="movie">
                <a href="Detailbbpp.php"><img src="photo/ppbb.jpg" alt="ภาพยนตร์เรื่องที่ 5">
                <p><a href="Detailbbpp.php">ซองแดงแต่งผี</a></p>
                <p class="showtime">วันที่เข้าฉาย: 20 มีนาคม 2025</p>
                <p class="ticket"> 
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class = "movie">
                <a href="Detailsparm.php"><img src="photo/sparm.jpg" alt="ภาพยนตร์เรื่องที่ 6">
                <p><a href="Detailsparm.php">แก๊งสเปิร์มผงาด</a></p>
                <p class="showtime">วันที่เข้าฉาย: 27 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
        </div>
    </div>

    <div class="imglogo">
        <img src="photo/logo.jpg" alt="logo">
        <img src="photo/logo1.jpg" alt="logo">
        <img src="photo/logo2.jpg" alt="logo">
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
