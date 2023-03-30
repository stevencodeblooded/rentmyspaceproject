<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apartment_id = $_POST["apartment_id"];
  $rating = $_POST["rating"];
  $comment = $_POST["comment"];
  $user_id = $_SESSION['user_id'];

  // Connect to database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "book_db";

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Insert review into database
  $sql = "INSERT INTO reviews (apartment_id, rating, comment, user_id) VALUES (?, ?, ?, ?)";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "idsi", $apartment_id, $rating, $comment, $user_id);

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);

      // Select username from users table
      $sql = "SELECT username FROM users WHERE user_id = ?";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Display success message with username
        echo "<script>alert('Thank you, $username, for your review!')</script>";
        echo "<script>window.location.href='details.php?id=$apartment_id#review-section'</script>";
      } else {
        echo "Something went wrong. Please try again later.";
      }
    } else {
      echo "Something went wrong. Please try again later.";
    }
    mysqli_close($conn);
  }
} else {
  header("Location: details.php?id=$apartment_id#review-section");
  exit();
}
?>
