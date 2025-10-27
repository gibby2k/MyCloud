<?php require_once 'config.php' ; ?>

<?php

$errors = [];
$success = '';
$showForm = true; // kontrola wyświetlania formularza
$defaultAvatar = 'media/avatars/default_avatar.png'; // domyślny avatar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Walidacja
    if ($username === '' || $password === '' || $password_confirm === '') {
        $errors[] = 'Wypełnij wszystkie pola.';
    } elseif ($password !== $password_confirm) {
        $errors[] = 'Hasła nie są takie same.';
    }

    if (empty($errors)) {
        $conn = new mysqli('localhost', 'srv96822_z5', 'srv96822_z5', 'srv96822_z5');
        $conn->set_charset('utf8mb4');

        if ($conn->connect_error) {
            die('Błąd połączenia z bazą: ' . $conn->connect_error);
        }

        // Sprawdzenie czy login już istnieje
        $stmt = $conn->prepare('SELECT username FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'Użytkownik o takim loginie już istnieje.';
        } else {

            // obsługa przesyłania avatara
            $avatarPath = $defaultAvatar;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES['avatar']['tmp_name'];
                $fileName = basename($_FILES['avatar']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png','gif'];
                if (in_array($fileExt, $allowed)) {
                    $newFileName = uniqid('avatar_', true) . '.' . $fileExt;
                    $uploadDir = 'media/avatars/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    if (move_uploaded_file($fileTmp, $uploadDir.$newFileName)) {
                        $avatarPath = $uploadDir.$newFileName;
                    }
                }
            }

            // zapis użytkownika do bazy
 $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$insertStmt = $conn->prepare('INSERT INTO users (username, password, avatar) VALUES (?, ?, ?)');
$insertStmt->bind_param('sss', $username, $hashedPassword, $avatarPath);

            if ($insertStmt->execute()) {
                $success = 'Rejestracja przebiegła pomyślnie. Możesz się teraz zalogować.';
                $showForm = false; // ukrycie formularza po sukcesie
            } else {
                $errors[] = 'Błąd przy rejestracji użytkownika.';
            }

            $insertStmt->close();
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
<title>Rejestracja · Bootstrap</title>
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
<!-- <body class="text-center" onload="myLoadHeader()">
<div id="myHeader"></div> -->

<main class="form-signin">
<?php if ($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err) echo '<div>'.htmlspecialchars($err).'</div>'; ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($success); ?>
        <div class="mt-2">
            <a href="login.php" class="btn btn-primary btn-sm">Przejdź do logowania</a>
        </div>
    </div>
<?php endif; ?>

<?php if ($showForm): ?>
<form method="post" action="" enctype="multipart/form-data">
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo Bootstrap" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Zarejestruj się</h1>

    <div class="form-floating mb-2">
        <input type="text" name="username" class="form-control" id="floatingUsername" placeholder="Login" required>
        <label for="floatingUsername">Wprowadź nowy login...</label>
    </div>

    <div class="form-floating mb-2">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Hasło" required>
        <label for="floatingPassword">Wprowadź unikalne hasło...</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" name="password_confirm" class="form-control" id="floatingPasswordConfirm" placeholder="Powtórz hasło" required>
        <label for="floatingPasswordConfirm">Powtórz hasło...</label>
    </div>

    <div class="mb-3">
        <label for="avatar" class="form-label">Avatar (opcjonalnie)</label>
        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Zarejestruj się</button>

    <div class="mt-3">
        <a href="login.php" class="btn btn-outline-secondary btn-sm">Masz konto? Zaloguj się</a>
    </div>
</form>
<?php endif; ?>

<p class="mt-5 mb-3 text-muted">&copy; Bootstrap</p>
</main>

</body>
</html>