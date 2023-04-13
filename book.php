<?php

// Start the session
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book - Rent My Space</title>
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
      <section class="booking">

         <h1 class="heading-title">Book Your Apartment</h1>
         <form action="book_form.php" method="post" class="book-form" id="booking-form">
            <input type="hidden" name="apartment_id" value="<?php echo $_GET['apartment_id']; ?>">
            <div class="flex">
               <div class="inputBox">
                  <span>name :</span>
                  <input type="text" placeholder="enter your name" name="name" required>
               </div>
               <div class="inputBox">
                  <span>email :</span>
                  <input type="email" placeholder="enter your email" name="email" required>
               </div>
               <div class="inputBox">
                  <span>phone :</span>
                  <input type="number" placeholder="enter your number" name="phone" min="1" required>
               </div>
               <div class="inputBox">
                  <span>address :</span>
                  <input type="text" placeholder="enter your address" name="address" required>
               </div>
               <div class="inputBox">
                  <span>other contact :</span>
                  <input type="number" placeholder="emergency contact" name="contact" min="1" required>
               </div>
               <div class="inputBox">
                  <span>how many :</span>
                  <input type="number" placeholder="number of guests" name="guests" min="1" required>
               </div>
               <div class="inputBox">
                  <span>check-in :</span>
                  <input type="date" name="arrivals" min="<?php echo date('Y-m-d'); ?>" required>
               </div>
               <div class="inputBox">
                  <span>check-out :</span>
                  <input type="date" name="leaving" min="<?php echo date('Y-m-d'); ?>" required>
               </div>

            </div>

            <?php

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
               // If not, display message and disable the submit button

               echo '<p><big>**Please log in to Continue booking**</big></p>';
               echo '<input type="submit" value="Submit to Continue" class="book-button" name="send" disabled>';
            } else {
               // If logged in, display the submit button
               echo '<input type="submit" value="Submit to Continue" class="book-button" name="send">';
            }
            ?>

            <button id="cancel-booking" class="cancel-btn-booking">Cancel Booking</button>
         </form>


      </section>
      <!-- booking section ends -->


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

   <script>
      //cancel booking 
      const cancelBtn = document.getElementById('cancel-booking');

      cancelBtn.addEventListener('click', (event) => {
         event.preventDefault();
         console.log('Cancel button clicked!');
         window.location.href = 'listings.php';
      });

      //date
      // Get the check-in and check-out date inputs
      var checkInDateInput = document.getElementsByName("arrivals")[0];
      var checkOutDateInput = document.getElementsByName("leaving")[0];

      // Add an event listener to the check-in date input
      checkInDateInput.addEventListener("input", function() {
         // Get the check-in and check-out date values
         var checkInDateValue = new Date(this.value);
         var checkOutDateValue = new Date(checkOutDateInput.value);

         // Disable the check-out date input if its value is before the check-in date value
         if (checkOutDateValue < checkInDateValue) {
            checkOutDateInput.value = "";
            checkOutDateInput.disabled = true;
         } else {
            checkOutDateInput.disabled = false;
         }
      });
   
      // Add an event listener to the check-out date input
      checkOutDateInput.addEventListener("input", function() {
         // Get the check-in and check-out date values
         var checkInDateValue = new Date(checkInDateInput.value);
         var checkOutDateValue = new Date(this.value);

         // Check if the check-out date value is before the check-in date value
         if (checkOutDateValue < checkInDateValue) {
            // Display an alert to inform the user to correct the dates
            alert("Check-out date must be after check-in date");

            // Clear the check-out date input value
            this.value = "";
         }
      });

   </script>

</body>

</html>