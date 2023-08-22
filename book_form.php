<?php
// Start the session
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent_my_space";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if(isset($_POST['send'])) {

  // Get user input
  $apartment_id = $_POST['apartment_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $guests = $_POST['guests'];
  $arrivals = $_POST['arrivals'];
  $leaving = $_POST['leaving']; 
  $cancellation_time = date('Y-m-d H:i:s', strtotime($arrivals . ' + 24 hours'));

  // Check if apartment is available for selected dates
  $sql = "SELECT * FROM book_details WHERE apartment_id = '$apartment_id'
          AND status != 'cancelled'
          AND ((arrivals >= '$arrivals' AND arrivals < '$leaving')
          OR (leaving > '$arrivals' AND leaving <= '$leaving')
          OR ('$arrivals' >= arrivals AND '$arrivals' < leaving)
          OR ('$leaving' > arrivals AND '$leaving' <= leaving))";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Dates overlap, show error message
    echo '<script>alert("Sorry, the selected dates are already booked. Please try some other dates."); window.location.href="book.php?apartment_id='.$apartment_id.'";</script>';
    exit();
  }

  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
     echo "Please log in to proceed";
     exit();
  }

  // Retrieve the user_id from the session variable
  $user_id = $_SESSION['user_id'];

  // Insert booking into database
  $sql = "INSERT INTO book_details (user_id, apartment_id, name, email, phone, address, contact, guests, arrivals, leaving, cancellation_time)
      VALUES ('$user_id', '$apartment_id', '$name', '$email', '$phone', '$address', '$contact', '$guests', '$arrivals', '$leaving', '$cancellation_time')";
  if (mysqli_query($conn, $sql)) {
    $id = mysqli_insert_id($conn);
    $book_summary_url = 'book_summary.php?id=' . $id;
    header('Location: ' . $book_summary_url);
    exit();
  } else {
    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo $message;
  }

  // Close database connection
  mysqli_close($conn);
}
