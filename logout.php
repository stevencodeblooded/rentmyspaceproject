<?php
session_start(); // Start session
session_destroy(); // Destroy session data
header('Location: index.php'); // Redirect to index.php
exit(); // End script execution
?>
