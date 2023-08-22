<?php
session_start();

// check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// check if the apartment id is passed in the URL
if (!isset($_GET['id'])) {
    header("Location: my-apartments.php");
    exit();
}

// get the apartment id from the URL
$apartment_id = $_GET['id'];

// connect to the database
$conn = mysqli_connect("localhost", "id21172805_stevencodeblooded", "@Cruzah1234", "id21172805_steven");

// check if the logged in user is the owner of the apartment
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM submit_form WHERE id=$apartment_id AND user_id=$user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    // the apartment does not belong to the logged in user
    header("Location: my-apartments.php");
    exit();
}

// delete the apartment from the database
$query = "DELETE FROM submit_form WHERE id=$apartment_id";
mysqli_query($conn, $query);

// redirect to the my-apartments page with a success message
$_SESSION['success_message'] = "Apartment deleted successfully.";
header("Location: my-apartments.php");
exit();
?>
