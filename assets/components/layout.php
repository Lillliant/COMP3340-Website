<?php
if (!isset($_SESSION['theme']) && !isset($_COOKIE['theme'])) {
    // If no theme cookie/session is set, default to light theme
    $_SESSION['theme'] = 'light';
} else if (isset($_COOKIE['theme'])) {
    // If a cookie is set but no session, use cookie's value in the session
    $_SESSION['theme'] = $_COOKIE['theme'];
}
?>
<!-- Bootstrap 5 CSS and JS, hosted on CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/3340/assets/css/<?php echo $_SESSION['theme'] ?>.css" id="themeStylesheet">
<link rel="stylesheet" href="/3340/assets/css/main.css">