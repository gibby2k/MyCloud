<?php
require_once 'auth.php';

$folderName = $_POST['folder_name'] ?? '';
$userDir = 'uploads/' . $_SESSION['user']['login'];

if ($folderName !== '') {
    mkdir($userDir . '/' . basename($folderName), 0755, true);
    header('Location: file_list.php');
    exit;
}
?>