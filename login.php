<?php require_once 'config.php'; ?>

<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $errors[] = 'Wypełnij wszystkie pola.';
    } else {
        // Połączenie z bazą danych (z Z1)
        $conn = new mysqli('localhost', 'srv96822_z5', 'srv96822_z5', 'srv96822_z5');
        $conn->set_charset('utf8mb4');

        if ($conn->connect_error) {
            die('Błąd połączenia z bazą: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT id, username, password, avatar FROM users WHERE username = ?');
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user'] = [
            'id' => $row['id'],
            'login' => $row['username'],
            'display_name' => $row['username'],
            'avatar' => $row['avatar']
        ];

        // Dane logowania
        $ip_address = $_SERVER['REMOTE_ADDR'];

        function getBrowserInfo($user_agent) {
    $browser = 'Nieznana przeglądarka';
    $platform = 'Nieznany system';

    // System operacyjny
    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'macOS';
    } elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'Windows';
    } elseif (preg_match('/iphone|ipad|ipod/i', $user_agent)) {
        $platform = 'iOS';
    } elseif (preg_match('/android/i', $user_agent)) {
        $platform = 'Android';
    }

    // Przeglądarka
    if (preg_match('/MSIE|Trident/i', $user_agent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Edg/i', $user_agent)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/OPR|Opera/i', $user_agent)) {
        $browser = 'Opera';
    } elseif (preg_match('/Chrome/i', $user_agent)) {
        $browser = 'Chrome';
    } elseif (preg_match('/Safari/i', $user_agent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Firefox/i', $user_agent)) {
        $browser = 'Firefox';
    }

    // Wersja (jeśli występuje)
    $version = '';
    if (preg_match('/(Chrome|Firefox|Safari|Edg|OPR)[\/ ]([0-9\.]+)/i', $user_agent, $matches)) {
        $version = $matches[2];
    }

    return "$browser $version / $platform";
}

$browser_info = getBrowserInfo($_SERVER['HTTP_USER_AGENT']);

        $screen_resolution = $_POST['screen_resolution'] ?? '';
        $window_size = $_POST['window_size'] ?? '';
        $color_depth = $_POST['color_depth'] ?? '';
        $cookies_enabled = (int)($_POST['cookies_enabled'] ?? 0);
        $java_enabled = (int)($_POST['java_enabled'] ?? 0);
        $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // Log do bazy
        $stmt2 = $conn->prepare("
            INSERT INTO user_logs 
            (user_id, ip_address, browser_info, screen_resolution, window_size, color_depth, cookies_enabled, java_enabled, language)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt2->bind_param(
            "isssssiss",
            $row['id'], $ip_address, $browser_info, $screen_resolution,
            $window_size, $color_depth, $cookies_enabled, $java_enabled, $language
        );
        $stmt2->execute();
        $stmt2->close();

        header('Location: index.php');
        exit;
            } else {
                $errors[] = 'Niepoprawne hasło.';
            }
        } else {
            $errors[] = 'Nie znaleziono użytkownika.';
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie z5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="signin.css?v=<?php echo filemtime('signin.css'); ?>" rel="stylesheet">
    <link href="twoj_css.css?v=<?php echo filemtime('twoj_css.css'); ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="twoj_js.js"></script>
    <style>
      main.form-signin {
        max-width: 400px;
        padding: 15px;
        margin: auto;
        margin-top: 80px;
        background-color: rgba(255,255,255,0.9);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
      }
      body {
        background: linear-gradient(135deg, #a2d2ff, #bde0fe, #cdb4db);
      }
    </style>
  </head>

  <main class="form-signin">
    <form method="post" action="">
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo Bootstrap" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err) echo '<div>'.htmlspecialchars($err).'</div>'; ?>
        </div>
    <?php endif; ?>

    <div class="form-floating mb-2">
        <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Login" required>
        <label for="floatingInput">Wprowadź login</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Hasło" required>
        <label for="floatingPassword">Wprowadź hasło</label>
    </div>

    <!-- Ukryte pola do zbierania danych o przeglądarkach -->
    <input type="hidden" name="screen_resolution" id="screen_resolution">
    <input type="hidden" name="window_size" id="window_size">
    <input type="hidden" name="color_depth" id="color_depth">
    <input type="hidden" name="cookies_enabled" id="cookies_enabled">
    <input type="hidden" name="java_enabled" id="java_enabled">
    <input type="hidden" name="language" id="language">

    <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj</button>

    <div class="mt-3">
        <a href="register.php" class="btn btn-outline-secondary btn-sm">Zarejestruj się</a>
    </div>

    <p class="mt-5 mb-3 text-muted">&copy; Bootstrap</p>
</form>

<script type="text/javascript">
    document.getElementById('screen_resolution').value = screen.width + "x" + screen.height;
document.getElementById('window_size').value = window.innerWidth + "x" + window.innerHeight;
document.getElementById('color_depth').value = screen.colorDepth;
document.getElementById('cookies_enabled').value = navigator.cookieEnabled ? 1 : 0;
document.getElementById('java_enabled').value = navigator.javaEnabled() ? 1 : 0;
document.getElementById('language').value = navigator.language || navigator.userLanguage;
</script>
</main>

</html>
