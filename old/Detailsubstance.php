<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดภาพยนตร์</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .h1 {
            color: white;
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
            <img src="photo/substance.jpg" alt="โปสเตอร์หนัง">
        </div>
        <div class="info">
            <h1>The Substance | สวยสลับร่าง</h1>
            <p><strong>ประเภท:</strong> ชีวิต , สยองขวัญ</p>
            <p><strong>ความยาว:</strong> 140 นาที</p>
            
            
            
            <div class="director">
                <h3>ผู้กำกับ</h3>
                <div class="person">
                    <img src="photo/deiCon1.jpg" alt="ผู้กำกับ">
                    <div class="name">กอราลี ฟาร์ฌาต์</div>
                </div>
            </div>
            
            <div class="synopsis">
                <h3>เรื่องย่อ</h3>
                <p>‘อลิซาเบธ สปาร์คเกิล’ (เดมี่ มัวร์) เป็นอดีตดาราดังแถวหน้าที่เคยเจิดจรัสในวงการบันเทิง แต่ตอนนี้เธอมีอายุมากขึ้นจนถูกฮาร์วี่ (เดนนิส เดวด) 
                    หัวหน้าสถานีเขี่ยทิ้งจากรายการออกกำลังกายซึ่งเป็นอาชีพสุดท้ายที่เธอเหลืออยู่ในภาวะที่สิ้นหวัง อลิซาเบธได้พบกับ ‘THE SUBSTANCE’ 
                    สารมหัศจรรย์ที่อ้างว่าจะสามารถปลดปล่อยตัวเธอในเวอร์ชันที่สมบูรณ์แบบกว่าออกมาได้ เธอตัดสินใจฉีดมัน 
                    แล้วก็ได้ร่างใหม่เป็นสาวสวยสะพรั่งวัยยี่สิบกว่าชื่อว่า ‘ซู’ (มาร์กาเร็ต ควอลลี่ย์)กฎสำคัญมีเพียงข้อเดียวเท่านั้น
                     คือ อลิซาเบธและซูต้องแบ่งเวลาในการใช้ร่างกัน หนึ่งอาทิตย์สำหรับร่างเก่า หนึ่งอาทิตย์สำหรับร่างใหม่ 
                     ทุกอย่างดูน่าจะเป็นไปอย่างราบรื่น แต่จะเกิดอะไรขึ้น เมื่อการแบ่งเวลาของทั้งสองเริ่มไม่เป็นไปตามกฎข้อนี้</p>
            </div>
        </div>
    </div>
</body>
</html>
