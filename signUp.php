<?php
  session_start();
  
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

  if (isset($_POST['submit'])) {
    // Validate form fields
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
      echo "<script>
            alert('Please fill in all fields');
            window.location.href = 'signup.php';
          </script>";
      exit();
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      echo "<script>
            alert('Please enter a valid email address');
            window.location.href = 'signup.php';
          </script>";
      exit();
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
      // Get the user_id of the newly created user
      $user_id = mysqli_insert_id($conn);

      // Set the $_SESSION['user_id'] variable to the user_id
      $_SESSION['user_id'] = $user_id;

      echo "<script>
            alert('Sign Up was successful');
            window.location.href = 'index.php';
          </script>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

  mysqli_close($conn);
?>
