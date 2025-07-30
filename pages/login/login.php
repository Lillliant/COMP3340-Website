<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Import layout -->
    <!-- For static pages, the components can be included directly -->
    <?php include '../../assets/components/layout.php'; ?>
    <script src="../../assets/js/toggleTheme.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php include '../../assets/components/header.php'; ?>

    <!-- Main Content -->
    <h1>Trekker Tours</h1>

    <h2>Login Page</h2>
    <a href="/3340/index.php">Go back to home page</a>
    <form action="auth.php" method="post">
        Enter Username:
        <input type="text" name="username" required="required" /> <br />
        Enter Password: <input type="password"
            name="password" required="required" /> <br />
        <input type="submit" value="Login" />
    </form>

    <!-- Footer -->
</body>

</html>