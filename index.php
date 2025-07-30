<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trekker Tours</title>
  <!-- Import layout -->
  <?php
  include 'assets/php/layout.php';
  ?>

  <script>
    function toggleTheme(value) {
      let sheet = document.getElementById('themeStylesheet');
      sheet.href = `assets/css/${value}.css`;
    }
  </script>
</head>

<body>
  <!-- Header -->
  <header>
    <nav class="header-navbar navbar navbar-expand-lg">
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" alt="Trekker Tours Logo" style="width:40px;">
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Theme
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" onclick="toggleTheme('dark')">Dark</a></li>
              <li><a class="dropdown-item" href="#" onclick="toggleTheme('light')">Light</a></li>
              <li><a class="dropdown-item" href="#" onclick="toggleTheme('pastel')">Pastel</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <h1>Trekker Tours</h1>
  <button onclick="toggleTheme('dark')">
    Dark
  </button>
  <!-- Footer -->
</body>

</html>