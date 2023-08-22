<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not, redirect the user to the login page
    header('Location: index.php');
    exit();
}

// Retrieve the user_id value from the session
$user_id = $_SESSION['user_id'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent_my_space";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if form is submitted
if (isset($_POST["submit"])) {
    // Get form data
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $target = "images/" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    $image = $_FILES["image"]["name"];
    $num_bedrooms = $_POST["num_bedrooms"];
    $num_bathrooms = $_POST["num_bathrooms"];
    $size = $_POST["size"];
    $amenities = $_POST["amenities"];
    $rules = $_POST["rules"];
    $contact_info = $_POST["contact_info"];

    // Validate form data
    if (!$title || !$description || !$price || !$location || !$image || !$num_bedrooms || !$num_bathrooms || !$size || !$amenities || !$rules || !$contact_info) {
        // Display error message
        echo "<script>alert('Please fill out all fields');</script>";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO submit_form(user_id, title, description, price, location, image, num_bedrooms, num_bathrooms, size, amenities, rules, contact_info) VALUES ('$user_id', '$title', '$description', '$price', '$location', '$image', '$num_bedrooms', '$num_bathrooms', '$size', '$amenities', '$rules', '$contact_info')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.onload = function(){alert('Your details have been submitted successfully');location.href='listings.php';}</script>";
        } else {
            echo "<script>window.onload = function(){alert('Failed submission, Retry Again');}</script>";
        }
    }
}
