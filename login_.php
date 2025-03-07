<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Calculate</title>
    <!-- <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .forgot-password {
            margin-top: 10px;
        }

        .forgot-password a {
            text-decoration: none;
            color: #007bff;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style> */ -->
</head>
<body>
<?php
    $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    echo $params['username'];
    echo $params['password'];
    session_start();
    
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "movie_ticket";
    $conn = mysqli_connect($hostname, $username, $password);
  
    if (!$conn)
        die("ไม่สามารถติดต่อกับ MySQL ได้");
    
    mysqli_select_db($conn, $dbname) or die("ไม่สามารถเลือกฐานข้อมูล session ได้");
    


    $sqltxt = "SELECT * FROM login where users = '$params[username]'";
    $result = mysqli_query($conn, $sqltxt);
    $rs = mysqli_fetch_array($result);
    
    
   
    
    if ($rs) 
    {
        if ($rs['password'] == $params['password']) 
        {
            $_SESSION['Username'] = $params['username'];
            header("Location: showtime.php?username=$uername");
        } 
        else 
        {
            echo "<br>Password not match.";
            echo "<br><a href='login.php'>คลิก กลับไปเพื่อ login</a>";
        }
    } 
    else 
    {
        echo "Not found Username " . $username;
        echo "<br><a href='login.php'>คลิก กลับไปเพื่อ login </a>";
    }
?>
    <!-- <h1>Login</h1>
    <form method="post">
        <p><input type="text" name="Username" placeholder="Username" required></p>
        <p><input type="password" name="Password" placeholder="Password" required></p>
        <p><input type="submit" name="submit" value="เข้าสู่ระบบ"></p>
    </form>

    <div class="forgot-password">
        <a href="#">ลืมรหัสผ่าน?</a>
    </div>  -->

</body>
</html> 
