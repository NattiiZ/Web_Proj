<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>โปรแกรมหนัง</title>
</head>
<body>
    <h1>📅 โปรแกรมหนัง</h1>
    <a href="index.php">⬅ กลับหน้าแรก</a>

    <?php
    $sql = "SELECT * FROM movies ORDER BY showtime ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2>{$row['title']}</h2>";
            echo "<p>{$row['description']}</p>";
            echo "<p>ฉาย: " . date("d/m/Y H:i", strtotime($row['showtime'])) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>ไม่มีโปรแกรมหนังตอนนี้</p>";
    }
    ?>
</body>
</html>
