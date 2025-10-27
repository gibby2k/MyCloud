<?php
require_once 'config.php';
require_once 'auth.php';

// Połączenie z bazą
$sql = "SELECT ul.*, u.username 
        FROM user_logs ul
        JOIN users u ON ul.user_id = u.id
        ORDER BY ul.log_datetime DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Logi użytkowników</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require_once 'navbar.php'; ?>

<div class="container mt-5">
    
    <h1 class="mb-4">Logi użytkowników</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID użytkownika</th>
                    <th>Nazwa</th>
                    <th>IP</th>
                    <th>Data logowania</th>
                    <th>Przeglądarka</th>
                    <th>Rozdzielczość</th>
                    <th>Rozmiar okna</th>
                    <th>Kolory</th>
                    <th>Cookies</th>
                    <th>Java</th>
                    <th>Język</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['ip_address']) ?></td>
                        <td><?= htmlspecialchars($row['log_datetime']) ?></td>
                        <td><?= htmlspecialchars($row['browser_info']) ?></td>
                        <td><?= htmlspecialchars($row['screen_resolution']) ?></td>
                        <td><?= htmlspecialchars($row['window_size']) ?></td>
                        <td><?= htmlspecialchars($row['color_depth']) ?></td>
                        <td><?= $row['cookies_enabled'] ? 'TAK' : 'NIE' ?></td>
                        <td><?= $row['java_enabled'] ? 'TAK' : 'NIE' ?></td>
                        <td><?= htmlspecialchars($row['language']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Brak logów użytkowników.</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary mt-3">Powrót</a>
</div>
</body>
</html>