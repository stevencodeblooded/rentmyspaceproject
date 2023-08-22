<?php

$servername = "localhost";
$username = "id21172805_stevencodeblooded";
$password = "@Cruzah1234";
$dbname = "id21172805_steven";

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