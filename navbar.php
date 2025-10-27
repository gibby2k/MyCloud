<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gabrych</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Dropdown dla "Polecenia" -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Polecenia
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="test.php">fsockopen()</a></li>
            <li><a class="dropdown-item" href="index1.php">host, port, stan</a></li>
            <li><a class="dropdown-item" href="dodaj1.php">Dodaj</a></li>
            <li><a class="dropdown-item" href="kasuj1.php">Usuń</a></li>
            <!-- Dodaj inne polecenia w razie potrzeby -->        
          </ul>
        </li>
        <!-- Form do logów uzytkowników -->
      <form class="d-flex ms-auto" action="user_log.php" method="post">
        <button class="btn btn-outline-blue" type="submit" >User logs</button>
      </form>
        <!-- Form do wylogowania z wyrównaniem do prawej strony -->
      <form class="d-flex ms-auto" action="logout.php" method="post">
        <button class="btn btn-outline-dark" type="submit">Wyloguj się</button>
      </form>

        
      </ul>
    </div>
  </div>
</nav>
