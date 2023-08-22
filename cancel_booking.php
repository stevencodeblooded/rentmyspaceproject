<?php

// Establish database connection
$servername = "localhost";
$username = "id21172805_stevencodeblooded";
$password = "@Cruzah1234";
$dbname = "id21172805_steven";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get booking ID from URL parameter
if (!isset($_GET['id'])) {
  header('Location: index.php');
  exit();
}
$id = $_GET['id'];

// Retrieve booking details from database
$sql = "SELECT * FROM book_details WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Check if cancellation is allowed
$cancellation_time = strtotime($row['cancellation_time']);
$current_time = time();
if ($current_time > $cancellation_time) {
  // Cancellation is not allowed
  mysqli_close($conn);
  echo '<script>alert("Cancellation is not allowed at this time. Try again later.");window.location.href="view_bookings.php";</script>';
  exit();
} else {
  // Cancellation is successful
  $sql = "UPDATE book_details SET status = 'cancelled' WHERE id = '$id'";
  mysqli_query($conn, $sql);
  mysqli_close($conn);
  echo '<script>alert("Cancellation is successful.");window.location.href="view_bookings.php";</script>';
  exit();
}

// Close database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Booking Cancelled</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container-cancelled">
    <h1 class="title">Booking Cancelled <i class="fa-regular fa-thumbs-down"></i></h1>
    <p class="message">Your booking has been cancelled successfully.</p>
    <a href="listings.php" class="btn-back-to-listings">Back to Listings</a>
  </div>
</body>
</html>
