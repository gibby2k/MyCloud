<?php require_once 'config.php' ; ?>

<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $errors[] = 'Wypełnij wszystkie pola.';
    } else {
        // Połączenie z bazą danych (z Z1)
        $conn = new mysqli('localhost', 'srv96822_z4', 'hZ6KVnJLXqYRmjhRT6Au', 'srv96822_z4');
        $conn->set_charset('utf8mb4');

        if ($conn->connect_error) {
            die('Błąd połączenia z bazą: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT id, username, password, avatar FROM users WHERE username = ?');
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Sprawdzenie hasła
            if (password_verify($password, $row['password'])) {
    $_SESSION['user'] = [
        'id' => $row['id'],                // <--- DODANE
        'login' => $row['username'],
        'display_name' => $row['username'],
        'avatar' => $row['avatar']
    ];
    
    if ($row['id'] == 0 && $row['username'] === 'admin') {
    header('Location: index.php');
} else {
    header('Location: index.php');
}
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
    <title>Logowanie z4</title>

    <!-- Bootstrap z CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Example CSS -->
    <link href="signin.css?v=<?php echo filemtime('signin.css'); ?>" rel="stylesheet">

    <!-- Twój CSS -->
    <link href="twoj_css.css?v=<?php echo filemtime('twoj_css.css'); ?>" rel="stylesheet">

    <!-- Twój JS + jQuery -->
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

  <!-- <body class="text-center" onload="myLoadHeader()">
    <div id="myHeader"></div> -->

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

        <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj</button>

        <div class="mt-3">
          <a href="register.php" class="btn btn-outline-secondary btn-sm">Zarejestruj się</a>
        </div>

        <p class="mt-5 mb-3 text-muted">&copy; Bootstrap</p>
      </form>
    </main>

    
  </body>
</html>