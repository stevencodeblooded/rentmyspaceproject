<?php 

session_start();

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password fields are not empty
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please enter both username and password'); window.location.href='signin.php';</script>";
        exit();
    }

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "rent_my_space");

    // Check if the user exists in the database
    $query = "SELECT id FROM users WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Set the user ID in the session variable
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];

        // Check if the user has any apartments listed in the database
        $query = "SELECT COUNT(*) FROM submit_form WHERE user_id = '$user[id]'";
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_row($result);
        $count = $row[0];

        // Redirect the user to my-apartments.php if they have apartments listed
        if ($count > 0) {
            header("Location: my-apartments.php");
            exit();
        }

        // Sign in the user and grant access
        // You can add code here to redirect the user to another page, set session variables, etc.
        echo "<script>alert('Welcome, " . $username . "'); window.location.href='index.php';</script>";
    
    } else {
        // Show an error message indicating that the username and password do not match any records in the database
        echo "<script>alert('Please Try Again, Incorrect username or password'); window.location.href='index.php';</script>";
    }
}

?>
