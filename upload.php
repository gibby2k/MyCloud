<?php
require_once 'auth.php';

// katalog użytkownika
$userDir = 'uploads/' . $_SESSION['user']['login'];
if (!is_dir($userDir)) mkdir($userDir, 0755, true);

$targetFile = $userDir . '/' . basename($_FILES['fileToUpload']['name']);

if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
    echo "Plik " . htmlspecialchars(basename($_FILES['fileToUpload']['name'])) . " został przesłany.";
} else {
    echo "Błąd przesyłania pliku.";
}

echo '<br><a href="index.php">Powrót</a>';