<?php

/**
 * logout.php
 * This script handles user logout by destroying the session and redirecting to the homepage.
 */

session_start();
session_destroy();
header("location:../../index.php");
