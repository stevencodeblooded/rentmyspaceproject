<?php

//start the session 
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>List Your Space</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav id="navBar" class="navbar-white">
        <a style="text-decoration: none" href="index.php">
            <h2 class="logo">Home <br><span><em>Adventures</em></span></h2>
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="listings.php">Apartments</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <div class="container">

        <main>
            <section id="share-space">
                <h1><i class="fa-solid fa-star"></i> Sharing is Earning <i class="fa-solid fa-star"></i></h1>
                <h2>List Your Apartment Details</h2>

                <form id="listing-form" action="submit_form.php" method="post" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="price">Price (per night in KSH):</label>
                    <input type="number" id="price" name="price" min="1" required>

                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>

                    <label for="image">Select image(s) to upload:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>

                    <label for="num_bedrooms">Number of bedrooms:</label>
                    <input type="number" id="num_bedrooms" name="num_bedrooms" min="1" required>

                    <label for="num_bathrooms">Number of bathrooms:</label>
                    <input type="number" id="num_bathrooms" name="num_bathrooms" min="1" required>

                    <label for="size">Size (in square feet):</label>
                    <input type="number" id="size" name="size" min="1" required>

                    <label for="amenities">Amenities (comma separated):</label>
                    <input type="text" id="amenities" name="amenities" required>

                    <label for="rules">Rules (comma separated):</label>
                    <input type="text" id="rules" name="rules" required>

                    <label for="contact_info">Contact Information:</label>
                    <input type="text" id="contact_info" name="contact_info" required>

                    <!----only show the submit form button after login ------>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="submit" name="submit" value="Submit">
                    <?php } else { ?>
                        <p><big>**Please log in to submit the form**</big></p>
                    <?php } ?>

                </form>
            </section>
        </main>


        <div class="footer">
            <a href="https://facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
            <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
            <hr>
            <p>Copyright &copy; 2023 Home For Travelers. All rights reserved.</p>
        </div>
    </div>

</body>

</html>