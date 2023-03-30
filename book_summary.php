<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_db";

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

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);

  // Retrieve apartment details from database
  $apartment_id = $row['apartment_id'];
  $sql = "SELECT * FROM submit_form WHERE id = '$apartment_id'";
  $result = mysqli_query($conn, $sql);
  $apartment = mysqli_fetch_assoc($result);
} else {
  header('Location: index.php');
  exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Booking Summary</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container-confirm">
    <h1 class="title">Booking Summary <i class="fa-regular fa-thumbs-up"></i></h1>
    <p class="message">Thank you for booking with us. Your booking details are:</p>
    <ul class="booking-details">
      <li class="booking-detail">Apartment Name: <?php echo $apartment['title']; ?></li>
      <li class="booking-detail">Apartment Location: <?php echo $apartment['location']; ?></li>
      <li class="booking-detail">Price Per Night: <?php echo $apartment['price']; ?></li>
      <br>
      <li class="booking-detail">Name: <?php echo $row['name']; ?></li>
      <li class="booking-detail">Email: <?php echo $row['email']; ?></li>
      <li class="booking-detail">Phone: <?php echo $row['phone']; ?></li>
      <li class="booking-detail">Address: <?php echo $row['address']; ?></li>
      <li class="booking-detail">Contact: <?php echo $row['contact']; ?></li>
      <li class="booking-detail">Guests: <?php echo $row['guests']; ?></li>
      <li class="booking-detail">Arrivals: <?php echo $row['arrivals']; ?></li>
      <li class="booking-detail">Leaving: <?php echo $row['leaving']; ?></li>
    </ul>
    <a href="payment.php?id=<?php echo $id; ?>" class="btn-payment-proceed">Proceed to Payment</a>
    <a href="listings.php" class="btn-back-to-listings">Back to Listings</a>
  </div>
</body>
</html>
