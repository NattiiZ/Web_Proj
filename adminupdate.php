<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #333;
    color: white;
    padding: 20px 0;
    text-align: center;
}

.admin h1 {
    margin: 0;
}

.correct {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

.correct a {
    display: block;
    width: 200px;
    text-align: center;
    background-color: #007BFF;
    color: white;
    padding: 10px;
    margin: 5px 0;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.correct a:hover {
    background-color: #0056b3;
}

    </style>
</head>
   
<body>
    <header>
    <div class="admin">
    <center>
         <h1>admin</h1>
    </center>
   </div>
    </header>
    
    <div class="correct">

        <a href="correctMovie1.php">แก้ไขหนัง</a>
        <a href="editcategory.php">แก้ไขหมวดหมู่</a>
        <a href="editshowtime.php">แก้ไขรอบ</a>
        <a href="edituser.php">แก้ไขuser</a>
        <a href="editticket.php">แก้ไขorder</a>
    </div>



</body>
</html>