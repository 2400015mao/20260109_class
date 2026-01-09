<?php
$conn = new mysqli("localhost", "kintaiuser", "kintaipass123", "kintaidb");

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_start'])) {
    $jugyoin_id = $conn->real_escape_string($_POST['jugyoin_id']);
    
    $sql = "INSERT INTO kiroku (jugyoin_id, start_work) VALUES ('$jugyoin_id', NOW())";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success'>出勤を記録しました！</div>";
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
    <title>出勤入力 - 勤怠管理</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/enter.css">
</head>
<body class="page-layout">
    <nav class="nav-bar">
        <a href="#" class="link-start">出勤</a>
        <a href="end.php">退勤</a>
        <a href="index.php">一覧</a>
    </nav>

    <div class="container">
        <h2 class="page-title">出勤入力</h2>
        
        <div class="card">
            <?php echo $msg; ?>
            
            <div class="digital-clock" id="clock">00:00:00</div>
            
            <form method="POST">
                <div class="input-group">
                    <label for="jugyoin_id">従業員ID</label>
                    <input type="text" name="jugyoin_id" id="jugyoin_id" required placeholder="例: 12345" autofocus>
                </div>
                <button type="submit" name="action_start" class="main-button" style="width: 100%;">出勤を記録する</button>
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