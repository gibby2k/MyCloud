<?php
require_once 'auth.php';

$userDir = 'uploads/' . $_SESSION['user']['login'];
$files = array_diff(scandir($userDir), ['.', '..']);

echo "<h2>Pliki użytkownika ".$_SESSION['user']['login']."</h2>";
echo "<a href='select.php'>Prześlij plik</a><br><br>";
echo "<ul>";

foreach ($files as $file) {
    $filePath = $userDir . '/' . $file;
    if (is_dir($filePath)) {
        echo "<li>[KATALOG] $file</li>";
    } else {
        echo "<li>[PLIK] <a href='$filePath' download>$file</a></li>";
    }
}

echo "</ul>";
echo "<a href='index.php'>Powrót</a>";