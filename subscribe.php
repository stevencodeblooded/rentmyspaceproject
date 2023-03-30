<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  $sql = "INSERT INTO subscribe_newsletter (email) VALUES ('$email')";

  if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Subscribed successfully');
            window.location.href = 'index.php';
          </script>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>