<!-- Common site-wide header for Trekker Tours -->
<header>
    <nav class="header-navbar navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo and site name -->
            <a class="navbar-brand" href="/3340/index.php">
                <img src="/3340/assets/img/logo.svg" alt="Trekker Tours Logo" height="24" class="d-inline-block align-middle align-text-top">
                Trekker Tours
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navItems" aria-controls="navItems" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class=" collapse navbar-collapse" id="navItems">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php
                        // If the user is logged in, show the home link to their dashboard
                        // Otherwise, show the home link to the main site
                        if (isset($_SESSION['loggedin'])) {
                            echo '<a class="nav-link" href="/3340/pages/user/home.php">Dashboard</a>';
                        } else {
                            echo '<a class="nav-link" href="/3340/index.php">Home</a>';
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/3340/pages/help/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/3340/pages/tour/search.php">Search Tours</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Help
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Generate help articles based on user role -->
                            <?php

                            // helper function to generate help articles links
                            function generateHelpArticles($articles)
                            {
                                foreach ($articles as $title => $link) {
                                    echo sprintf(
                                        '<li><a class="dropdown-item" href="/3340/pages/help/%s">%s</a></li>',
                                        htmlspecialchars($link),
                                        htmlspecialchars($title)
                                    );
                                }
                            }

                            // If the user is an admin, show admin-specific help articles
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                $helpArticles = [
                                    'Tour Management' => 'tour.php',
                                    'Booking Management' => 'booking.php',
                                    'User Management' => 'user.php',
                                ];
                                generateHelpArticles($helpArticles);
                            }

                            // Otherwise, show general help articles available to everyone
                            $helpArticles = [
                                'Login and Profile' => 'login.php',
                                'Book Tours' => 'purchase.php',
                            ];
                            generateHelpArticles($helpArticles);
                            ?>
                        </ul>
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
        </div>

    </nav>
</header>