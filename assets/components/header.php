<!-- Common site-wide header for Trekker Tours -->
<!-- TODO: For specific pages, this header includes context-specific help articles (e.g., admin for admin pages) -->
<header>
    <nav class="header-navbar navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <img src="/3340/assets/img/logo.png" alt="Trekker Tours Logo" style="width:40px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href=<?php
                                if (isset($_SESSION['loggedin'])) {
                                    echo '/3340/pages/user/home.php';
                                } else {
                                    echo '/3340/index.php';
                                }
                                ?>>
                        Home
                    </a>
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
                <?php
                if (isset($_SESSION['loggedin'])) {
                    // If the user is logged in, show the logout link
                    echo '<li class="nav-item"><a class="nav-link" href="/3340/pages/login/logout.php">Logout</a></li>';
                } else {
                    // If the user is not logged in, show the login and register links
                    echo '<li class="nav-item"><a class="nav-link" href="/3340/pages/login/login.php">Login</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/3340/pages/login/register.php">Register</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>