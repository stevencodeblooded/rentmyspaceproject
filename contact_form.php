<?php

// PHP script that can be used to connect to the database and insert the form data into the 'contact_form' table
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent_my_space";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Insert the data into the contact_form table
$sql = "INSERT INTO contact_form (name, email, message)
VALUES ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Message successfully submitted');</script>";
    header("Location: contact.php");
} else {
    echo "<script type='text/javascript'>alert('Kindly retry sending the message');</script>";
}

$conn->close();
?>