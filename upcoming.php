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
        <a href="index.php">หน้าแรก</a>
        <a href="showtime.php">โปรแกรมฉายหนัง</a>
        <a href="upcoming.php">โปรแกรมหน้า</a>
        <a href="register.php">ลงทะเบียน</a> |
        <a href="login.php">เข้าสู่ระบบ</a>
    </nav>
</header>

<body>

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

    <div class="content">
        <h1>โปรแกรมหนัง</h1>
        <div class="movies">
            <div class='movie'>
                <img src='photo/novocaine.jpg' alt='ภาพยนตร์เรื่องที่ 1'>
                <p><a href='Detailnovocaine.php'>Novocaine มิสเตอร์โคตรคนทรหด</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='photo/naja2.jpg' alt='ภาพยนตร์เรื่องที่ 2'>
                <p><a href='Detailnaja2.php'>นาจา 2</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='photo/mulunaku.jpg' alt='ภาพยนตร์เรื่องที่ 3'>
                <p><a href='Detailmulunaku.php'>มูลู หน้าครู</a></p>
                <p class='showtime'>วันที่เข้าฉาย: 13 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class="movie">
                <img src="photo/snowwhite.jpg" alt="ภาพยนตร์เรื่องที่ 4">
                <p><a href="Detailsnowwhite.php">snowwhite | สโนว์ไวท์ </a></p>
                <p class="showtime">วันที่เข้าฉาย: 20 มีนาคม 2025</p>
                <p class="ticket">
                <a href="Ticket.php" class="button">TICKET|จองตั๋ว</a></p>

            </div>
        </div>
    </div>

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
