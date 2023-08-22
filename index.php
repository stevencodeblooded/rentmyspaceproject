<?php
// Start the session
session_start();

// Check if the user has submitted the login form
if (isset($_POST['signin'])) {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are valid
    // You can replace this with your own code to check the credentials
    if ($username == 'username' && $password == 'password') {
        // Set the session variable
        $_SESSION['user_id'] = 1;

        // Redirect the user to the same page
        header('Location: index.php');
        exit();
    } else {
        // Display an error message
        $error = 'Invalid username or password';
    }
}

?>

<!-------the end of the php script for login and registration--->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent My Space</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="header">
        <nav id="navBar">
            <a style="text-decoration: none" href="index.php">
                <h2 class="logo">Home <br><span><em>Adventures</em></span></h2>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="listings.php">Apartments</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    // User is logged in, display link to view_booking.php
                    echo '<li><a href="view_bookings.php">My Bookings</a></li>';
                }
                ?>

                <!-- Display the login button if the user is not logged in -->
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo '<button class="btnLogin-popup">Login</button>';
                } else {
                    echo '<li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </nav>

        <section id="container">
            <h1>You Are All <br> Welcome To <br> Rent My Space</h1>
            <p>Find your perfect rental space today. <br> We allow you to list your property for others to rent <br> and therefore you get to earn as you share.</p>

            <!---This button redirects you to the listing form-->
            <button id="list-space-btn" onclick="location.assign('listing-form.php')">List Your Space</button>
        </section>

        <div class="wrapper">
            <span class="icon-close">X</span>
            <div class="form-box login">
                <h2>Login</h2>
                <form action="signIn.php" method="post">

                    <?php if (isset($error)) { ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php } ?>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></i></span>
                        <input type="text" name="username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></i></span>
                        <input type="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remeber me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" name="signin" class="log-form-btn">Login</button>

                    <div class="login-register">
                        <p>Don't have an account?<a href="#" class="register-link">Register</a></p>
                    </div>
                </form>
            </div>

            <div class="form-box register">
                <h2>Registration</h2>
                <form action="signUp.php" method="post">
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">I agree to the terms & conditions</label>
                    </div>
                    <button type="submit" name="submit" class="log-form-btn">Register</button>

                    <div class="login-register">
                        <p>Already have an account?<a href="#" class="login-link">Login</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="container">
        <section id="popular">
            <h2>You Get An Exclusive Offer</h2>
            <p>Here are some of the accommodations you may find interesting as you travel around the country. From luxurious villas to cozy apartments, there's something for every traveler out there. Get ready to experience the best of what the country has to offer and make lasting memories.</p>
        </section>
        <div class="featured-listings-container">

            <div class="featured-listing">
                <img src="images/8.jpeg" alt="Featured Listing 1">
                <h3>Spacious Studio Apartment</h3>
                <p>Location: Nairobi, Kenya</p>
                <p>Price: Ksh.25000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
            <div class="featured-listing">
                <img src="images/6.jpg" alt="Featured Listing 2">
                <h3>Cozy Cottage</h3>
                <p>Location: Malindi, Kenya</p>
                <p>Price: Ksh.30000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
            <div class="featured-listing">
                <img src="images/3.jpeg" alt="Featured Listing 3">
                <h3>Luxurious Penthouse</h3>
                <p>Location: Uasin Gishu, Kenya</p>
                <p>Price: Ksh.40000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
            <div class="featured-listing">
                <img src="images/9.jpeg" alt="Featured Listing 1">
                <h3>Luxury Villa in Taveta</h3>
                <p>Location: Taita Taveta, Kenya</p>
                <p>Price: Ksh.35000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
            <div class="featured-listing">
                <img src="images/7.jpeg" alt="Featured Listing 2">
                <h3>Rustic Cabin in Kakamega</h3>
                <p>Location: Kakamega, Kenya</p>
                <p>Price: Ksh.55000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
            <div class="featured-listing">
                <img src="images/4.jpeg" alt="Featured Listing 3">
                <h3>Charming Studio in Nyeri</h3>
                <p>Location: Nyeri, Kenya</p>
                <p>Price: Ksh.70000/month</p>
                <a href="listings.php" class="button">View Listing</a>
            </div>
        </div>

        <div class="services-card-container">
            <div class="services-card">
                <i class="fas fa-home"></i>
                <h3>Short-term Rentals</h3>
                <p>We offer a wide variety of short-term rental options for those looking for a temporary living space.</p>
            </div>
            <div class="services-card">
                <i class="fas fa-key"></i>
                <h3>Long-term Leases</h3>
                <p>We also have a variety of long-term lease options for those looking for a more permanent living solution.</p>
            </div>
            <div class="services-card">
                <i class="fas fa-search"></i>
                <h3>Property Search</h3>
                <p>Our advanced property search allows you to easily find the perfect rental space to fit your needs.</p>
            </div>
            <div class="services-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Online Booking</h3>
                <p>Book your rental space online with our easy to use booking system.</p>
            </div>
        </div>

        <div class="testimonials-container">
            <h2 style="color: #ea1538">Testimonials</h2>
            <div class="testimonial">
                <blockquote>
                    <p>"Rent My Space was the perfect solution for my short-term rental needs. Their user-friendly platform made it easy for me to find the perfect space, and the customer service was exceptional. I highly recommend Rent My Space to anyone looking for a rental space."</p>
                    <cite style="color: #ea1538"><i class="fa-solid fa-user"></i>- Keisha Mwanamisi</cite>
                </blockquote>
                <div class="testimonial">
                    <blockquote>
                        <p>"I had a great experience with Rent My Space. They helped me find the perfect space for my business, and the process was smooth and easy. I would definitely use them again in the future."</p>
                        <cite style="text-align: center; color: #ea1538"><i class="fa-solid fa-user"></i>- Eunice Chaka</cite>
                    </blockquote>
                </div>
                <div class="testimonial">
                    <blockquote>
                        <p>"Rent My Space made it easy for me to find a rental space that fit my needs and budget. Their customer service was top-notch and I would definitely recommend them to anyone looking for a rental space."</p>
                        <cite style="color: #ea1538"><i class="fa-solid fa-user"></i>- Jacktone Mukaisi</cite>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="subscribe-container">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Stay updated on the latest news, events and promotions from our company by subscribing to our newsletter.
                Don't miss out on <br>exclusive offers and discounts available only to our subscribers.
                We promise to never spam you <br> and you can unsubscribe at any time.</p>

            <form action="subscribe.php" method="post">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <br>

        <div class="partners-container">
            <h2>Our Partners</h2>
            <div class="partner">
                <img src="images/logoH.png" alt="Partner 1">
            </div>
            <div class="partner">
                <img src="images/logoE.png" alt="Partner 2">
            </div>
            <div class="partner">
                <img src="images/logoG.png" alt="Partner 3">
            </div>
            <div class="partner">
                <img src="images/logoD.png" alt="Partner 4">
            </div>
        </div>

    </div>
    <br>
    <!----kenyan Map ---->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8171113.995063892!2d33.40774147351357!3d0.16510345641353757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182780d08350900f%3A0x403b0eb0a1976dd9!2sKenya!5e0!3m2!1sen!2ske!4v1675691391688!5m2!1sen!2ske" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    <div class="container">
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

    <script src="script.js"></script>

</body>

</html>