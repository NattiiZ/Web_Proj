<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
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
    width: 320px;
    text-align: center;
}

h1 {
    color: #333;
}

input[type="text"], input[type="email"], input[type="password"], input[type="number"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>

    <h1>Register</h1>
    <form action="">
        <p><input type="text" name="name" placeholder="Name" required></p>
        <p><input type="text" name="surname" placeholder="Surname" required></p>
        <p><input type="number" name="age" placeholder="Age" required></p>
        <p><input type="email" name="email" placeholder="Email" required></p>
        <p><input type="text" name="username" placeholder="Username" required></p>
        <p><input type="password" name="password" placeholder="Password" required></p>
        <p><input type="submit" value="Register"></p>
    </form>

</body>
</html>