<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "movie_ticket";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// เพิ่มหมวดหมู่
    $category = $_POST['category_name'] ?? '';
    if ($category != '') {
        $sql = "INSERT INTO category (name) VALUES ('$category')";
        if ($conn->query($sql)) {
            if ($_POST['add_category'] ?? '') {
                echo "<script>alert('เพิ่มหมวดหมู่สำเร็จ');</script>";
            } 
        }else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่');</script>";
        }
    } else {
        if ($_POST['add_category'] ?? '') 
            echo "<script>alert('กรุณากรอกชื่อหมวดหมู่');</script>";
    }


    
    $sqltxt = "SELECT * FROM category ";
    $result = mysqli_query($conn, $sqltxt);

    $CATID = $_POST['add_category'] ?? '';
    echo $CATID;
    // if ($CATID != '') {
    //     $sql = "UPDATE catagory SET  name = 'catid'  WHERE Country='Mexico'";
    //     if ($conn->query($sql)) {
    //         if ($_POST['add_category'] ?? '') {
    //             echo "<script>alert('เพิ่มหมวดหมู่สำเร็จ');</script>";
    //         } 
    //     }else {
    //         echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่');</script>";
    //     }
    // } else {
    //     if ($_POST['add_category'] ?? '') 
    //         echo "<script>alert('กรุณากรอกชื่อหมวดหมู่');</script>";
    // }





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่หนัง</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .form-group input {
            width: 48%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #ff758c;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 117, 140, 0.5);
        }
        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            background: #ff758c;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff5c75;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .category-table th, .category-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .category-table th {
            background: #f2f2f2;
        }
    </style>
</head>
<div class="container">
        <h1>จัดการหมวดหมู่หนัง</h1>

        <!-- ฟอร์มเพิ่มหมวดหมู่ -->
        <h2>เพิ่มหมวดหมู่</h2>
        <form method="POST" class="form-group">
            <th><input type="text" name="category_name" placeholder="ชื่อหมวดหมู่" required class="form-input"></th>
            <button type="submit" name="add_category" class="form-button">เพิ่มหมวดหมู่</button>
            
        </form>

        <!-- ตารางแสดงรายการหมวดหมู่ -->
        <h2>รายการหมวดหมู่</h2>
        <table class="category-table">
            <tr>
                <th>ชื่อหมวดหมู่</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
            <?php
              while ($rs = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $rs['name'] . "</td>";
                echo "<td><form class=\"edit-cat\" method=\"POST\">
                        <input type=\"hiddend\" name=\"id\" value=\" " . $rs['category_id']. " \" >
                        <input type=\"hiddend\" name = \"id \" >
                        <button type=\"submit\" name=\"add_category\" class=\"editcat_btn\">แก้ไข</button>
                    </td>";
                echo "<td></td>";
                echo "</tr>";

            //     echo "<tr>";
            //     echo "<td>" . $rs['name'] . "</td>";
            //     echo "<td><button onclick='showEditForm(" . $rs['category_id'] . ", \"" . $rs['name'] . "\")'>แก้ไข</button></td>";
            //     echo `<td><form class="edit-form" method="POST">
            //             <input type="hiddend" name="`.$rs['category_id'].`"  ">
            //             <button type="submit" name="delete_category" class="form-button">x</button>
            //         </form></td>`;
            //     echo "</tr>";
             }
            ?>
        </table>

    </div>

    <script>
        function showEditForm(id, name) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_category_name').value = name;
        }
    </script>
</body>
</html>


