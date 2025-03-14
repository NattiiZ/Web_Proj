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
            <img src="photo/naja2.jpg" alt="โปสเตอร์หนัง">
        </div>
        <div class="info">
            <h1>naja 2 | นาจา 2</h1>
            <p><strong>ประเภท:</strong> ผจญภัย , แอนิเมชัน , ชีวิต , แฟนตาซี </p>
            <p><strong>ความยาว:</strong> 145 นาที</p>
            
            
            
            <div class="director">
                <h3>ผู้กำกับ</h3>
                <div class="person">
                    <img src="photo/place.jpg" alt="ผู้กำกับ">
                    <div class="name">Yang Yu</div>
                </div>
            </div>
            
            <div class="synopsis">
                <h3>เรื่องย่อ</h3>
                <p>หลังจากรับอสนีบาต แม้นาจากับอ๋าวปิ่งจะรอดมาได้ด้วยการกลายเป็นวิญญาณ แต่ในไม่ช้าพวกเขาก็จะต้องสลายหายไป ไท่หยี่จึงวางแผนที่จะสร้างร่างของนาจาและอ๋าวปิ่งขึ้นมาใหม่ด้วยดอกบัววิเศษเจ็ดสี 
                    ทว่าระหว่างการสร้างร่างก็ได้เกิดอุปสรรคขึ้นมากมาย มาลุ้นกันว่าชะตากรรมของนาจาและอ๋าวปิ่งจะเป็นอย่างไรต่อไป</p>
            </div>
        </div>
    </div>
</body>
</html>
