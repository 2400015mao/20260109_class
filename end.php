<?php
$conn = new mysqli("localhost", "kintaiuser", "kintaipass123", "kintaidb");

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_end'])) {
    $jugyoin_id = $conn->real_escape_string($_POST['jugyoin_id']);
    
    $sql = "UPDATE kiroku 
            SET end_work = NOW() 
            WHERE jugyoin_id = '$jugyoin_id' 
            AND end_work IS NULL 
            ORDER BY start_work DESC 
            LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            $msg = "<div class='alert alert-success'>お疲れ様でした！退勤を記録しました。</div>";
        } else {
            $msg = "<div class='alert alert-error'>出勤データが見つからないか、既に退勤済みです。</div>";
        }
    } else {
        $msg = "<div class='alert alert-error'>エラーが発生しました。</div>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退勤入力 - 勤怠管理</title>
    <link rel="stylesheet" href="css/base.css">
     <link rel="stylesheet" href="css/end.css">  </head>
<body class="page-layout">
    <nav class="nav-bar">
        <a href="enter.php" class="link-start">出勤</a>
        <a href="#" class="link-end">退勤</a>
        <a href="index.php">一覧</a>
    </nav>

    <div class="container">
        <h2 class="page-title">退勤入力</h2>
        
        <div class="card">
            <?php echo $msg; ?>
            
            <div class="digital-clock" id="clock">00:00:00</div>
            
            <form method="POST">
                <div class="input-group">
                    <label for="jugyoin_id">従業員ID</label>
                    <input type="text" name="jugyoin_id" id="jugyoin_id" required placeholder="例: 12345" autofocus>
                </div>
                <button type="submit" name="action_end" class="main-button" style="width: 100%;">退勤を記録する</button>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('ja-JP');
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>