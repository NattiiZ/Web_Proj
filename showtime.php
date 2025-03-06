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
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#">หน้าแรก</a>
        <a href="#">โปรแกรมฉายหนัง</a>
        <a href="#">ลงทะเบียน | เข้าสู่ระบบ</a>
    </div>
    <div class="banner">
        <img src="banner.jpg" alt="ภาพยนตร์แนะนำ">
    </div>
    <div class="content">
        <h1>โปรแกรมหนัง</h1>
        <div class="movies">
            <div class='movie'>
                <img src='comper.jpg' alt='ภาพยนตร์เรื่องที่ 1'>
                <p>Companion | คอมแพเนียน</p>
                <p class='showtime'>ฉายเวลา: 12:30, 15:00, 18:00</p>
            </div>
            <div class='movie'>
                <img src='Dacknun.jpg' alt='ภาพยนตร์เรื่องที่ 2'>
                <p>Dark Nuns</p>
                <p class='showtime'>ฉายเวลา: 13:00, 16:00, 19:30</p>
            </div>
            <div class='movie'>
                <img src='substance.jpg' alt='ภาพยนตร์เรื่องที่ 3'>
                <p>The Substance | สวยสลับร่าง</p>
                <p class='showtime'>ฉายเวลา: 14:15, 17:45, 21:00</p>
            </div>
        </div>
    </div>
</body>
</html>
