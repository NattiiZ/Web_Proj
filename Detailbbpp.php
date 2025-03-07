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
            <img src="photo/snowwhite.jpg" alt="โปสเตอร์หนัง">
        </div>
        <div class="info">
            <h1>ซองแดงแต่งผี</h1>
            <p><strong>ประเภท:</strong> ตลก </p>
            <p><strong>ความยาว:</strong> 125 นาที</p>
            <button>ดูรอบฉาย</button>
            
            
            <div class="director">
                <h3>ผู้กำกับ</h3>
                <div class="person">
                    <img src="photo/ppbbDt.jpg" alt="ผู้กำกับ">
                    <div class="name">ชยนพ บุญประกอบ</div>
                </div>
            </div>
            
            <div class="synopsis">
                <h3>เรื่องย่อ</h3>
                <p>เรื่องราวการแต่งงานสุดพิลึกพิลั่นระหว่างคนกับผี ที่ป่วนที่สุดในสองโลก!
เมื่อ ‘เม่น’ (บิวกิ้น พุฒิพงศ์) โจรกระจอกที่ผันตัวมาเป็นสายตำรวจ เผลอไปหยิบซองแดงปริศนา และพบว่ามันคือพิธีกรรมความเชื่อเก่าแก่ที่ทำให้เขาต้องแต่งงานกับศพ ไม่เช่นนั้นเขาจะซวยไปตลอดชีวิต แต่ที่ทำให้ชายแท้อย่างเม่นต้องเหวอสุดขีดก็คือ ศพที่เขาต้องแต่งด้วยดันเป็นผู้ชายด้วยกัน! 
 
และนั่นทำให้เขาได้เจอกับ ‘ตี่ตี๋’ (พีพี กฤษฏ์) วิญญาณเกย์หนุ่มสุดคิวต์ ที่ยังไม่ยอมไปเกิดเพราะยังมีเรื่องค้างคาใจ เม่นต้องช่วยตามสืบอุบัติเหตุที่คร่าชีวิตตี่ตี๋ โดยหวังจะทำให้ตี่ตี๋ไปสู่สุคติและออกไปจากชีวิตเขาสักที ยิ่งไปกว่านั้น เบาะแสทั้งหมดที่เม่นพบกลับกลายเป็นว่านี่อาจไม่ใช่อุบัติเหตุธรรมดา แต่มันโยงใยไปสู่แก๊งค้ายาที่เขา และ ‘เจ๊ก๊อย’ (ก้อย อรัชพร) 
ตำรวจสาวรุ่นพี่ที่เม่นแอบชอบกำลังตามสืบอยู่ด้วย งานนี้ เม่นจึงหวังจะปิดคดีเพื่อที่เขาจะได้ทั้งหน้าที่การงาน ความรัก และช่วยให้ตี่ตี๋ไปเกิดเสียที</p>
            </div>
        </div>
    </div>
</body>
</html>
