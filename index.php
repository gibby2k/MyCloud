<?php require_once 'auth.php';?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>Gabrych</title>
  <!-- Dodajemy link do CDN Bootstrapa -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Wstawiamy navbar -->
  <?php include('navbar.php'); ?>

  <!-- Kontener Bootstrapa -->
  <div class="container mt-5">

    <div class="text-center mb-4">
      <h1>LISTA POLECEŃ</h1>
      <p>Wybierz:</p>
    </div>

    <ul class="list-group">
      <li class="list-group-item">
        <a href="#" class="btn btn-outline-primary w-100">jest</a>
      </li>

    </ul>
  </div>

  <!-- Dodajemy skrypt do CDN Bootstrapa -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
