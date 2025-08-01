<?php
// This file is used to initialize the database and create necessary tables
// It should be included in the init/init.php file
require_once('../assets/php/CreateDb.php');
createDb();

// Then, add a process to handle the initialization of data,
// Including creating initial accounts and uploading files and links to the database
?>
<html>

<head>
    <title>Title</title>
</head>

<body>
    <h2>Initialization Complete</h2>
    <!-- Change it so that pressing the button will refresh the database -->
    <!-- Add a setup.php file to set up the initial testing data -->
    <!-- PHP executes before loading this page, so add the php code to createDb.php, if it works -->
</body>

</html>