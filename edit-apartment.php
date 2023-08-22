<?php
session_start();

// Redirect the user to the login page if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Redirect the user to the my-apartments page if the ID is not provided
if (!isset($_GET['id'])) {
    header("Location: my-apartments.php");
    exit();
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "rent_my_space");

// Get the apartment details from the database
$apartment_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
$query = "SELECT * FROM submit_form WHERE id='$apartment_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // Redirect the user to the my-apartments page if the apartment does not belong to them
    header("Location: my-apartments.php");
    exit();
}

$apartment = mysqli_fetch_assoc($result);

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $num_bedrooms = mysqli_real_escape_string($conn, $_POST['num_bedrooms']);
    $num_bathrooms = mysqli_real_escape_string($conn, $_POST['num_bathrooms']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $amenities = mysqli_real_escape_string($conn, $_POST['amenities']);
    $rules = mysqli_real_escape_string($conn, $_POST['rules']);
    $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);

    // Check if a new image has been uploaded
    $image = $apartment['image'];
    if ($_FILES["image"]["name"] != "") {
        $image_tmp = $_FILES["image"]["tmp_name"];
        $image_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image_name = uniqid('img_') . '.' . $image_ext;
        $target_dir = "images/";
        $target_file = $target_dir . $image_name;
        $allowed_ext = array("jpg", "jpeg", "png");
        if (in_array($image_ext, $allowed_ext)) {
            if (move_uploaded_file($image_tmp, $target_file)) {
                $image = $image_name;
            } else {
                $error_msg = "Failed to upload image.";
            }
        } else {
            $error_msg = "Only JPG, JPEG, and PNG files are allowed.";
        }
    }

    // Update the apartment details in the database
    $query = "UPDATE submit_form SET title='$title', description='$description', price='$price', location='$location', 
    image='$image', num_bedrooms='$num_bedrooms', num_bathrooms='$num_bathrooms', size='$size', amenities='$amenities', rules='$rules',
    contact_info='$contact_info' WHERE id='$apartment_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect the user to the updated apartment details page
        header("Location: my-apartments.php?id=$apartment_id");
        exit();
    } else {
        $error_msg = "Failed to update apartment details.";
    }
}

?>

<!-- HTML form to update apartment details -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Apartment</title>
</head>

<body>
    <style>
        .header {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            font-family: sans-serif;
            margin: 30px;
            border-radius: 20px;
        }

        .header h1 {
            font-size: 3.3em;
            margin-bottom: 20px;
            color: #ea1538;
            margin-top: 10px;
        }

        .header p {
            font-size: 1.2em;
            line-height: 1.5;
        }

        .edit-apartment {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: sans-serif;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .edit-apartment form {
            display: flex;
            flex-direction: column;
        }

        .edit-apartment label {
            flex-basis: 30%;
            font-size: 18px;
            color: #ea1538;
            margin-bottom: 10px;
            display: inline-block;
        }

        .edit-apartment input[type="text"],
        .edit-apartment input[type="number"],
        .edit-apartment input[type="file"],
        .edit-apartment textarea {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: sans-serif;
            font-size: 1.1rem;
            font-weight: 400;
            color: #333;
            transition: border-color 0.3s ease-in-out;
        }

        .edit-apartment input[type="text"]:focus,
        .edit-apartment input[type="number"]:focus,
        .edit-apartment input[type="file"]:focus,
        .edit-apartment textarea:focus {
            border-color: #ea1538;
            outline: none;
        }

        .edit-apartment textarea {
            height: 70px;
        }


        .edit-apartment input[type="submit"] {
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

            transition: background-color 0.3s ease-in-out;
        }

        .edit-apartment input[type="submit"]:hover {
            background-color: #3e8e41;
            color: #000;
        }
    </style>

    <div class="header">
        <h1>Edit Apartment Details</h1>
        <p>This page allows you to update the details of your apartment, including its title, description, price, location, image, number of bedrooms and bathrooms, size, amenities, rules, and contact information. Simply fill in the form below with the updated information and click the "Update Details" button to save your changes.</p>
    </div>

    <div class="edit-apartment">
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $apartment['title']; ?>"><br>

            <label for="description">Description:</label>
            <textarea name="description"><?php echo $apartment['description']; ?></textarea><br>

            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo $apartment['price']; ?>"><br>

            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo $apartment['location']; ?>"><br>

            <label for="image">Image:</label>
            <input type="file" name="image"><br>

            <label for="num_bedrooms">Number of Bedrooms:</label>
            <input type="number" name="num_bedrooms" value="<?php echo $apartment['num_bedrooms']; ?>"><br>

            <label for="num_bathrooms">Number of Bathrooms:</label>
            <input type="number" name="num_bathrooms" value="<?php echo $apartment['num_bathrooms']; ?>"><br>

            <label for="size">Size:</label>
            <input type="number" name="size" value="<?php echo $apartment['size']; ?>"><br>

            <label for="amenities">Amenities:</label>
            <textarea name="amenities"><?php echo $apartment['amenities']; ?></textarea><br>

            <label for="rules">Rules:</label>
            <textarea name="rules"><?php echo $apartment['rules']; ?></textarea><br>

            <label for="contact_info">Contact Info:</label>
            <textarea name="contact_info"><?php echo $apartment['contact_info']; ?></textarea><br>

            <input type="submit" name="submit" value="Update Details">
        </form>
    </div>
</body>

</html>