<?php

//start the session 
session_start();

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'rent_my_space');

// Check if the ID parameter is present in the URL
if (isset($_GET['id'])) {
  // Get the ID from the query string
  $id = $_GET['id'];

  // Prepare the SQL statement
  $stmt = $db->prepare("SELECT * FROM submit_form WHERE id = ?");

  // Bind the ID parameter to the statement
  $stmt->bind_param('i', $id);

  // Execute the SQL statement
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Fetch the data
  $apartment = $result->fetch_assoc();

  // Check if the apartment was found
  if (!$apartment) {
    echo "Apartment not found";
  } else {
    function get_reviews($apartment_id)
    {
      global $db;
      $stmt = $db->prepare("SELECT * FROM reviews WHERE apartment_id = ?");
      $stmt->bind_param('i', $apartment_id);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Display the details of the apartment
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Listings - Rent My Space</title>
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
        <div class="container-details">
          <div class="row">
            <div class="col-3 item-label"></div>
            <div class="col-9 item-value-title"><?php echo $apartment['title']; ?></div>
          </div>
          <div class="row">
            <div class="col-3 item-label"></div>
            <div class="col-9 item-value"><?php echo $apartment['description']; ?></div>
          </div>
          <div class="row">
            <div class="col-3 item-label">Price per night: <i class="fa-solid fa-hand-holding-dollar"></i></div>
            <div class="col-9 item-value"><?php echo $apartment['price']; ?></div>
          </div>
          <div class="row">
            <div class="col-3 item-label">Location: <i class="fa-sharp fa-solid fa-location-dot"></i></div>
            <div class="col-9 item-value"><?php echo $apartment['location']; ?></div>
          </div>
          <div class="row">
            <div class="col-3 item-label"></div>
            <div class="col-9 item-value"><img src="<?php echo 'images/' . $apartment['image']; ?>" alt="Apartment Image"></div>
          </div>

          <div class="row-center">
            <div class="col-3 item-label"><i class="fa-solid fa-bed"></i> Number of Bedrooms:</div>
            <div class="col-9 item-value"><?php echo $apartment['num_bedrooms']; ?></div>
          </div>

          <div class="row-center">
            <div class="col-3 item-label"><i class="fa-solid fa-restroom"></i> Number of Bathrooms:</div>
            <div class="col-9 item-value"><?php echo $apartment['num_bathrooms']; ?></div>
          </div>

          <div class="row-center">
            <div class="col-3 item-label"><i class="fa-solid fa-house"></i> Size:</div>
            <div class="col-9 item-value">
              <p><?php echo $apartment['size']; ?> square meters</p>
            </div>
          </div>

          <hr>

          <div class="amenities-rules">
            <h2>Amenities:</h2>
            <ul>
              <?php foreach (explode(',', $apartment['amenities']) as $amenity) : ?>
                <li><i class="fas fa-check"></i><?= $amenity ?></li>
              <?php endforeach; ?>
            </ul>
          </div>

          <hr>

          <div class="amenities-rules">
            <h2>Rules:</h2>
            <ul>
              <?php foreach (explode(',', $apartment['rules']) as $rules) : ?>
                <li><i class="fa-sharp fa-solid fa-triangle-exclamation"></i><?= $rules ?></li>
              <?php endforeach; ?>
            </ul>
          </div>

          <hr> <br>

          <div class="row-center">
            <div class="col-3 item-label">Owner Contact Number</div>
            <div class="col-9 item-value">
              <p>Mobile Number: <?php echo $apartment['contact_info']; ?></p>
            </div>
          </div>

          <hr> <br>

          <!---The Review form section starts here--->
          <h3 class="head-reviews">What Travelers Are Saying...</h3>
          <?php


          function get_reviews_with_usernames($apartment_id, $conn)
          {
            $query = "SELECT r.*, u.username FROM reviews AS r INNER JOIN users AS u ON r.user_id = u.id WHERE apartment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $apartment_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
              return array();
            }

            $reviews = array();
            while ($row = $result->fetch_assoc()) {
              $reviews[] = $row;
            }

            return $reviews;
          }

          // Display reviews with usernames
          $reviews = get_reviews_with_usernames($apartment['id'], $db);

          if (!empty($reviews)) {
            foreach ($reviews as $review) {
          ?>
              <div class="review-item" id="review-section">
                <div class="review-header">
                  <div class="review-user-info">
                    <i class="fas fa-user"></i>
                    <span class="review-username"><?php echo $review['username']; ?></span>
                  </div>
                  <div class="review-rating">
                    <i class="fas fa-star"></i>
                    <span><?php echo $review['rating']; ?></span>
                  </div>
                </div>
                <p class="review-text"><?php echo $review['comment']; ?></p>
              </div>
            <?php
            }
          } else {
            echo "No reviews found.";
          }
          

          // Check if the user is logged in
          if (!isset($_SESSION['user_id'])) {
            echo "<p><big>**You must be logged in to submit a review**</big></p>";
          } else {
            // Display the review form
            ?>
            <div class="review-form">
              <h3>Rate your experience...</h3>
              <form action="submit_review.php" method="post" class="review-form-class">
                <input type="hidden" name="apartment_id" value="<?php echo $apartment['id']; ?>">
                <label for="rating">Rating:<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></label>
                <input type="number" step="0.1" min="0" max="5" name="rating" id="rating" required>
                <label for="comment">Comment:<i class="fa-solid fa-comment"></i><i class="fa-solid fa-comment-dots"></i><i class="fa-solid fa-pen"></i></label>
                <textarea name="comment" id="comment" required></textarea>

                <button id="submit-review" type="submit" name="submit">Submit</button>
              </form>
            </div>
          <?php
          }

          ?>

          <!---The Review form section ends here--->


          <div class="row">
            <div class="col-3"></div>
            <div class="col-9">
              <form action="book.php?id=<?php echo $apartment['id']; ?>" method="get">
                <input type="hidden" name="apartment_id" value="<?php echo $apartment['id']; ?>">
                <button type="submit" class="proceed-to-payment-btn">Proceed to Booking</button>
              </form>
            </div>
          </div>

        </div>


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
  <?php
  }
} else {
  echo "ID parameter not present in URL";
}
  ?>