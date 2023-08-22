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
            echo "<script>window.onload = function(){alert('Your apartment has been added successfully');location.href='my-apartments.php';}</script>";
        } else {
            echo "<script>window.onload = function(){alert('Failed to add apartment, please try again');}</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add - Apartment</title>
</head>

<body>
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            font-family: sans-serif;
        }

        .form-container h2 {
            font-size: 3.3em;
            margin-bottom: 20px;
            color: #ea1538;
            margin-top: 10px;
            text-align: center;
        }

        form {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group>label {
            flex-basis: 30%;
            margin-right: 10px;
            text-align: right;
            font-size: 18px;
            color: #ea1538;
            font-size: 1.1em;
            font-weight: lighter;
        }

        .form-group>input,
        .form-group>textarea,
        .form-group>select {
            flex-grow: 1;
            margin: 0;
            padding: 10px;
            font-size: 18px;
            font-family: sans-serif;
            border-radius: 5px;
            border: 2px solid #ccc;
            transition: border-color 0.3s ease-in-out;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="number"]:focus,
        .form-container input[type="file"]:focus,
        .form-container textarea:focus ,
        .form-container select:focus{
            border-color: #ea1538;
            outline: none;
        }

        .form-group--vertical {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group--vertical>label {
            margin-bottom: 10px;
        }

        .btn {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            width: fit-content;
            height: 10%;
            margin-top: 20px;
            margin-left: 45%;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #3e8e41;
            color: #000;
        }
    </style>

    <div class="form-container">
        <h2>Enter New Apartment Details</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="number" name="price" required>
            </div>
            <!-- <div class="form-group">
                <label>Location:</label>
                <input type="text" name="location" required>
            </div> -->

            <div class="form-group">
                <label for="location">Location:</label>
                <select id="location" name="location" required>
                    <option value="">Select a city</option>
                    <option value="Nairobi">Nairobi</option>
                    <option value="Mombasa">Mombasa</option>
                    <option value="Kisumu">Kisumu</option>
                    <option value="Nakuru">Nakuru</option>
                    <option value="Eldoret">Eldoret</option>
                    <option value="Thika">Thika</option>
                    <option value="Malindi">Malindi</option>
                    <option value="Kitale">Kitale</option>
                    <option value="Garissa">Garissa</option>
                    <option value="Kakamega">Kakamega</option>
                    <option value="Nyeri">Nyeri</option>
                    <option value="Machakos">Machakos</option>
                    <option value="Ruiru">Ruiru</option>
                    <option value="Migori">Migori</option>
                    <option value="Embu">Embu</option>
                    <option value="Voi">Voi</option>
                    <option value="Bungoma">Bungoma</option>
                    <option value="Athi River">Athi River</option>
                    <option value="Narok">Narok</option>
                    <option value="Kericho">Kericho</option>
                    <option value="Kilifi">Kilifi</option>
                    <option value="Makueni">Makueni</option>
                    <option value="Wundanyi">Wundanyi</option>
                    <option value="Kitui">Kitui</option>
                    <option value="Marsabit">Marsabit</option>
                    <option value="Lamu">Lamu</option>
                    <option value="Homa Bay">Homa Bay</option>
                    <option value="Karuri">Karuri</option>
                    <option value="Naivasha">Naivasha</option>
                    <option value="Isiolo">Isiolo</option>
                    <option value="Kapenguria">Kapenguria</option>
                    <option value="Kapsabet">Kapsabet</option>
                    <option value="Kabarnet">Kabarnet</option>
                    <option value="Nanyuki">Nanyuki</option>
                    <option value="Kerugoya">Kerugoya</option>
                    <option value="Siaya">Siaya</option>
                    <option value="Moyale">Moyale</option>
                    <option value="Maralal">Maralal</option>
                    <option value="Chuka">Chuka</option>
                    <option value="Oyugis">Oyugis</option>
                    <option value="Awendo">Awendo</option>
                    <option value="Nyamira">Nyamira</option>
                    <option value="Mumias">Mumias</option>
                    <option value="Kajiado">Kajiado</option>
                    <option value="Keroka">Keroka</option>
                    <option value="Molo">Molo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Upload an image:</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <div class="form-group">
                <label for="num_bedrooms">Number of bedrooms:</label>
                <input type="number" class="form-control" id="num_bedrooms" name="num_bedrooms" required>
            </div>

            <div class="form-group">
                <label for="num_bathrooms">Number of bathrooms:</label>
                <input type="number" class="form-control" id="num_bathrooms" name="num_bathrooms" required>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <input type="number" class="form-control" id="size" name="size" required>
            </div>

            <div class="form-group">
                <label for="amenities">Amenities:</label>
                <textarea class="form-control" id="amenities" name="amenities" rows="3" placeholder="Comma Separated" required></textarea>
            </div>

            <div class="form-group">
                <label for="rules">Rules:</label>
                <textarea class="form-control" id="rules" name="rules" rows="3" placeholder="Comma Separated" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact_info">Contact Information:</label>
                <textarea class="form-control" id="contact_info" name="contact_info" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>