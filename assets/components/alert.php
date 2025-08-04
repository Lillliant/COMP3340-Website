<?php
// This is a common alert component for displaying messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show">' . htmlspecialchars($_SESSION['success']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close""></button></div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show">' . htmlspecialchars($_SESSION['error']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close""></button></div>';
    unset($_SESSION['error']);
}
