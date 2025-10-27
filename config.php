<?php
declare(strict_types=1);

// Uruchom sesję tylko, jeśli jeszcze nie działa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ustawienia błędów (dla debugowania)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Połączenie z bazą danych
$dbhost = "localhost"; // Host bazy danych, np. localhost
$dbuser = "srv96822_z5"; // Użytkownik bazy danych
$dbpassword = "srv96822_z5"; // Hasło bazy danych
$dbname = "srv96822_z5"; // Nazwa bazy danych

// Tworzenie połączenia
$conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
?>
