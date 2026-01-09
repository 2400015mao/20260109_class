<?php
$conn = new mysqli("localhost", "kintaiuser", "kintaipass123", "kintaidb");

// 1. 出勤・退勤ボタンが押された時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['jugyoin_id'];
    $now = date("Y-m-d H:i:s");

    if (isset($_POST['action_start'])) {
        // 出勤：新しいレコードを作成
        $stmt = $conn->prepare("INSERT INTO kiroku (jugyoin_id, start_work) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $now);
        $stmt->execute();
    } elseif (isset($_POST['action_end'])) {
        // 退勤：その従業員の最新のレコード（end_workが空のもの）を更新
        $stmt = $conn->prepare("UPDATE kiroku SET end_work = ? WHERE jugyoin_id = ? AND end_work IS NULL ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("ss", $now, $id);
        $stmt->execute();
    }
}

// 2. 全記録一覧の取得
$result = $conn->query("SELECT * FROM kiroku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>簡易勤怠管理</title>
    <link rel="stylesheet" href="css/base.css">
</head>
<body>
    <h2>勤怠入力</h2>
    <form method="POST">
        従業員ID: <input type="text" name="jugyoin_id" required>
        <button type="submit" name="action_start">出勤</button>
        <button type="submit" name="action_end">退勤</button>
    </form>

    <hr>
    <h2>全記録一覧</h2>
    <table border="1">
        <tr><th>ID</th><th>従業員ID</th><th>出勤時刻</th><th>退勤時刻</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['jugyoin_id'] ?></td>
            <td><?= $row['start_work'] ?></td>
            <td><?= $row['end_work'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>