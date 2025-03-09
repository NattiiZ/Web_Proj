<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดภาพยนตร์</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
        .movie-detail {
            display: flex;
            gap: 20px;
            padding: 20px;
            background-color: #111;
            color: white;
        }
        .poster img {
            width: 300px;
            border-radius: 10px;
        }
        .info {
            flex: 1;
            
        }
        .actors, .director {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .actors .person, .director .person {
            text-align: center;
            width: 100px;
        }
        .actors img, .director img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }
        .name {
            margin-top: 5px;
            font-size: 14px;
        }
        .trailer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">หน้าแรก</a>
        <a href="showtime.php">โปรแกรมฉายหนัง</a>
        <a href="register.php">ลงทะเบียน</a> |
        <a href="login.php">เข้าสู่ระบบ</a>
    </div>
    <div class="movie-detail">
        <div class="poster">
            <img src="photo/comper.jpg" alt="โปสเตอร์หนัง">
        </div>
        <div class="info">
            <h1>Companion | คอมแพเนียน</h1>
            <p><strong>ประเภท:</strong> สยองขวัญ , วิทยาศาสตร์ , ระทึกขวัญ</p>
            <p><strong>ความยาว:</strong> 97 นาที</p>
            
            
            
            <div class="director">
                <h3>ผู้กำกับ</h3>
                <div class="person">
                    <img src="photo/deiCom1.jpg" alt="ผู้กำกับ">
                    <div class="name">ดรูว์ ฮานค็อก</div>
                </div>
            </div>
            
            <div class="synopsis">
                <h3>เรื่องย่อ</h3>
                <p>การเสียชีวิตของมหาเศรษฐีพันล้านคนหนึ่ง ได้กลายมาเป็นจุดเริ่มต้นให้เกิดเหตุการณ์มากมายในระหว่างที่ ไอริส และเพื่อนของเธอ มาพักผ่อนช่วงสุดสัปดาห์ที่บ้านหรูริมทะเลสาปของเขา</p>
            </div>
        </div>
    </div>
</body>
</html>
