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
            <img src="photo/mulunaku.jpg" alt="โปสเตอร์หนัง">
        </div>
        <div class="info">
            <h1>มูลู หน้าครู</h1>
            <p><strong>ประเภท:</strong> สยองขวัญ</p>
            <p><strong>ความยาว:</strong> 90 นาที</p>
            
            
            
            <div class="director">
                <h3>ผู้กำกับ</h3>
                <div class="person">
                    <img src="photo/place.jpg" alt="ผู้กำกับ">
                    <div class="name">บุญส่ง นาคภู่</div>
                </div>
            </div>
            
            <div class="synopsis">
                <h3>เรื่องย่อ</h3>
                <p>เมย์ สถาปนิกสาวที่เพิ่งย้ายเข้ามาบ้านใหม่แถวชานเมืองกับ กัน แฟนหนุ่ม ได้รับแจ้งข่าวการตายของ ปอ แม่เลี้ยง โดยมีเพียง นุ่น ลูกสาวของปอให้การว่า มีคนฆ่าแม่ของเธอ แต่ไม่ปรากฏว่ามีพยานหลักฐานใดที่ชี้ชัด

หลังจากเมย์ตัดสินใจรับนุ่นไปดูแลที่บ้านของเธอ นุ่นก็มีอาการผิดปกติเหมือนถูกผีเข้า รวมทั้งตัวเมย์เองก็เริ่มมีภาวะนอนไม่ได้จนล้มป่วย กัน ได้รับคำแนะนำให้ โชค ศักดิ์ และอาจารย์คม เข้ามาช่วยเหลือ

อาจารย์คมรับรู้ได้ทันทีว่าภายในบ้านมี ‘ของ’ ที่ไม่ดีมาจากอดีต และต้องช่วยกันหาต้นตอของสิ่งชั่วร้ายนี้ให้เจอ โดยมีเรื่องร้ายในอดีตที่เกี่ยวพันกับหนังหน้าครูของอาจารย์ซึ่งถูกเลาะโดยฝีมืออาจารย์จง ศิษย์อีกคนจากสำนักเดียวกันเมื่อหลายสิบปีก่อนเป็นต้นตอของเรื่องราวสุดสยองทั้งหมดนี้</p>
            </div>
        </div>
    </div>
</body>
</html>
