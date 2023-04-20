<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Rent My Space</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/6e3eac2e13.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav id="navBar">
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
            <section id="contact">
                <h1>Contact - Rent My Space</h1>
                <p>We are here to help and answer any question you might have. We look forward to hearing from you. Don't hesitate to reach out to us. We understand that sometimes it can be difficult to find the right information and we want to make sure that you have a smooth experience. If you have any questions or concerns, please don't hesitate to reach out to us, we are here to help.</p>
            
            </section>
            <h1 class="form-heading">Let's Talk</h1>

            <form id="contact-form" action="contact_form.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Full name..." required>
        
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your e-mail address..." required>
        
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Enter your message here..." required></textarea>
        
                <input type="submit" value="Submit" >
            </form>
            
            <section id="contact">
                <h3>Contact us through the following:</h3>
                <ul>
                    <li>Phone Number: <i class="fa-solid fa-phone"></i> +254 112 275 442</li>
                    <li>Email Address: <i class="fa-solid fa-envelope"></i> info@rentmyspace.com</li>
                    <li>Physical Address: <i class="fa-solid fa-location-dot"></i> Mama Ngina Street, Nairobi Kenya</li>
                </ul>
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

    <script src="script.js"></script>
</body>
</html>    