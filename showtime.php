<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมฉายหนัง</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #222;
            color: white;
            text-align: center;
        }
        .navbar {
            background-color: black;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .banner img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
        }
        .content {
            padding: 20px;
        }
        .movies {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .movie {
            background-color: #333;
            padding: 10px;
            border-radius: 10px;
            width: 220px;
            text-align: center;
        }
        .movie img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        .movie p {
            margin-top: 10px;
            font-size: 16px;
        }
        .showtime {
            font-size: 14px;
            color: #ffcc00;
            margin-top: 5px;
        }
        .ticket {
            font-size: 14px;
            color: #ffcc00;
            margin-top: 5px;
        }
        .movie a {
            color: #ffcc00;
            text-decoration: none;
        }
        .movie a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #007BFF;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }     

        .button:active {
            background-color: #004085;
        }
    </style>
</head>
<header>
    <nav>
        <a href="index.php">หน้าแรก</a>
        <a href="showtime.php">โปรแกรมฉายหนัง</a>
        <a href="register.php">ลงทะเบียน</a> |
        <a href="login.php">เข้าสู่ระบบ</a>
    </nav>
</header>
<body>
    <div class="banner">
        <img src="banner.jpg" alt="ภาพยนตร์แนะนำ">
    </div>
    <div class="content">
        <h1>โปรแกรมหนัง</h1>
        <div class="movies">
            <div class='movie'>
                <img src='comper.jpg' alt='ภาพยนตร์เรื่องที่ 1'>
                <p><a href='Detailcompanion.php'>Companion | คอมแพเนียน</a></p>
                <p class='showtime'>ฉายเวลา: 12:30, 15:00, 18:00</p>
                <p class="ticket">
                <a href="ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='Dacknun.jpg' alt='ภาพยนตร์เรื่องที่ 2'>
                <p><a href='movie_detail.php?id=2'>Dark Nuns</a></p>
                <p class='showtime'>ฉายเวลา: 13:00, 16:00, 19:30</p>
                <p class="ticket">
                <a href="ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
            <div class='movie'>
                <img src='substance.jpg' alt='ภาพยนตร์เรื่องที่ 3'>
                <p><a href='movie_detail.php?id=3'>The Substance | สวยสลับร่าง</a></p>
                <p class='showtime'>ฉายเวลา: 14:15, 17:45, 21:00</p>
                <p class="ticket">
                <a href="ticket.php" class="button">TICKET|จองตั๋ว</a></p>
            </div>
        </div>
    </div>
</body>
</html>
