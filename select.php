<?php require_once 'auth.php'; ?>

<h2>Twoje pliki</h2>

<!-- Formularz dodawania nowego katalogu -->
<form method="post" action="create_folder.php" class="mb-3">
    <input type="text" name="folder_name" placeholder="Nowy katalog" required>
    <button type="submit" class="btn btn-primary btn-sm">Utwórz katalog</button>
</form>

<!-- Formularz wysyłania plików -->
<form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit" class="btn btn-success btn-sm">Wyślij plik</button>
</form>

<!-- Lista plików -->
<ul>
    <?php
    $userDir = 'uploads/' . $_SESSION['user']['login'];
    if (is_dir($userDir)) {
        $files = scandir($userDir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            echo "<li>$file</li>";
        }
    }
    ?>
</ul>