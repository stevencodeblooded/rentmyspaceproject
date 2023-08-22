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

// Get user ID from session or URL parameter
session_start();
$user_id = $_SESSION['user_id']; // assuming you store user ID in a session variable

// Retrieve user's bookings from database
// $sql = "SELECT * FROM book_details WHERE user_id = '$user_id'";
$sql = "SELECT b.*, s.title, s.location, s.price
        FROM book_details b
        JOIN submit_form s ON b.apartment_id = s.id
        WHERE b.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Bookings</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container-bookings">
    <h1 class="title">My Bookings</h1>
    <?php if (mysqli_num_rows($result) > 0) { ?>
      <table class="bookings-table">
        <thead>
          <tr>
            <th>Apartment Name</th>
            <th>Location</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Price Per Night</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['location']; ?></td>
              <td><?php echo $row['arrivals']; ?></td>
              <td><?php echo $row['leaving']; ?></td>
              <td><?php echo $row['price']; ?></td>
              <td><a href="cancel_booking.php?id=<?php echo $row['id']; ?>">Cancel</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p class="message">You have no bookings yet.</p>
    <?php } ?>
    <a href="listings.php" class="btn-back-to-listings">Back to Listings</a>
  </div>
</body>
</html>
