<?php
$conn = new mysqli("localhost", "kintaiuser", "kintaipass123", "kintaidb");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['jugyoin_id'];
    $now = date("Y-m-d H:i:s");

    if (isset($_POST['action_start'])) {
        $stmt = $conn->prepare("INSERT INTO kiroku (jugyoin_id, start_work) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $now);
        $stmt->execute();
    } elseif (isset($_POST['action_end'])) {
        $stmt = $conn->prepare("UPDATE kiroku SET end_work = ? WHERE jugyoin_id = ? AND end_work IS NULL ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("ss", $now, $id);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM kiroku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>全記録一覧 - 勤怠管理システム</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body class="page-records">
    <nav class="navbar">
        <div class="nav-container">
            <span class="nav-logo">勤怠管理システム</span>
            <ul class="nav-links">
                <li><a href="enter.php" class="link-start">出勤入力</a></li>
                <li><a href="end.php" class="link-end">退勤入力</a></li>
                <li><a href="#" class="active">全記録一覧</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <section class="list-section">
            <div class="section-header">
                <h2>全記録一覧</h2>
            </div>
            
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>従業員ID</th>
                            <th>出勤時刻</th>
                            <th>退勤時刻</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><span class="badge-id"><?= $row['jugyoin_id'] ?></span></td>
                            <td class="time-in"><?= $row['start_work'] ?></td>
                            <td class="time-out"><?= $row['end_work'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>