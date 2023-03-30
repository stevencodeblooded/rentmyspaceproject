<?php

//start the session 
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_db";

$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set default page and items per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 8;

// Prepare the search query based on form data 
$query = "SELECT id, title, description, price, location, image FROM submit_form WHERE 1=1 ";

// Filter by location
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = $_GET['location'];
    $query .= " AND location='$location'";
}

// Filter by price range
if (isset($_GET['price-range']) && !empty($_GET['price-range'])) {
    $priceRange = $_GET['price-range'];
    if ($priceRange == "0-5000") {
        $query .= " AND price BETWEEN 0 AND 5000";
    } elseif ($priceRange == "5000-10000") {
        $query .= " AND price BETWEEN 5000 AND 10000";
    } elseif ($priceRange == "10000-20000") {
        $query .= " AND price BETWEEN 10000 AND 20000";
    } elseif ($priceRange == "20000-above") {
        $query .= " AND price > 20000";
    }
}

// Filter by number of bedrooms
if (isset($_GET['bedrooms']) && !empty($_GET['bedrooms'])) {
    $bedrooms = $_GET['bedrooms'];
    if ($bedrooms == "1") {
        $query .= " AND num_bedrooms=1";
    } elseif ($bedrooms == "2") {
        $query .= " AND num_bedrooms=2";
    } elseif ($bedrooms == "3") {
        $query .= " AND Num_bedrooms=3";
    } elseif ($bedrooms == "4") {
        $query .= " AND num_bedrooms=4";
    } elseif ($bedrooms == "5-above") {
        $query .= " AND num_bedrooms >= 5";
    }
}

// Filter by check-in and check-out dates
if (isset($_GET['arrivals']) && isset($_GET['leaving'])) {
    $checkin = date("Y-m-d", strtotime($_GET['arrivals']));
    $checkout = date("Y-m-d", strtotime($_GET['leaving']));

    // Get the apartment IDs that are already booked during the selected period
    $bookedQuery = "SELECT DISTINCT apartment_id FROM book_details WHERE arrivals <= ? AND leaving >= ?";
    $bookedStmt = $db->prepare($bookedQuery);
    $bookedStmt->bind_param("ss", $checkout, $checkin);
    $bookedStmt->execute();
    $bookedResult = $bookedStmt->get_result();
    $bookedIds = array();
    while ($row = $bookedResult->fetch_assoc()) {
        $bookedIds[] = $row['apartment_id'];
    }
    $bookedStmt->close();

    // Filter out the booked apartments from the search query
    if (!empty($bookedIds)) {
        $bookedIdsString = implode(",", $bookedIds);
        $query .= " AND id NOT IN ($bookedIdsString)";
    }

    // Filter out the apartments that are not available during the selected period
    $query .= " AND id NOT IN (SELECT DISTINCT apartment_id FROM book_details WHERE arrivals <= '$checkout' AND leaving >= '$checkin')";
}

// Get the total number of items matching the search criteria
$totalItemsQuery = str_replace("SELECT id,", "SELECT COUNT(*) as count,", $query);
$totalItemsResult = $db->query($totalItemsQuery);
$totalItems = $totalItemsResult->fetch_assoc()['count'];

// Calculate the total number of pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Calculate the offset for the current page
$offset = ($page - 1) * $itemsPerPage;

// Add the pagination limit and offset to the search query
$query .= " LIMIT $itemsPerPage OFFSET $offset";

// Execute the search query and get the results
$result = $db->query($query);

///////////


// Prepare the SQL statement
$stmt = $db->prepare($query);

// Execute the SQL statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all the rows
$apartments = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement
$stmt->close();

// Close the database connection
$db->close();

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
        <main class="decorate-listings">
            <h1>Apartments - Rent My Space</h1>
            <p>This page features an extensive selection of the finest and most luxurious apartments available for rent, boasting stunning views, top-of-the-line amenities, and prime locations. Browse our listings to find your dream home away from home.</p>

            <form action="listings.php" method="get" id="searchForm">
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" name="location" id="location" class="form-control">
                </div>
                <div class="form-group">
                    <label for="price-range">Price Range:</label>
                    <select name="price-range" id="price-range" class="form-control">
                        <option value="">All</option>
                        <option value="0-5000">Ksh. 0 - 5,000</option>
                        <option value="5000-10000">Ksh. 5,000 - 10,000</option>
                        <option value="10000-20000">Ksh. 10,000 - 20,000</option>
                        <option value="20000-above">Above Ksh. 20,000</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bedrooms">Bedrooms:</label>
                    <select name="bedrooms" id="bedrooms" class="form-control">
                        <option value="">All</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5-above">5 and above</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="arrivals">Check-in:</label>
                    <input type="date" name="arrivals" id="arrivals" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="leaving">Check-out:</label>
                    <input type="date" name="leaving" id="leaving" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                </div>

                <input type="submit" value="Search" class="btn btn-primary">

            </form>

            <div class="listings-container">

                <?php if (empty($apartments)) : ?>
                    <p style="margin-top: 5%;">Sorry, the apartment you are searching for is not available at the moment. <br> Try some other time</p>
                <?php else : ?>
                    <?php foreach ($apartments as $apartment) { ?>

                        <div class="listing-card">
                            <img src="<?php echo 'images/' . $apartment['image']; ?>" alt="<?php echo $apartment['title']; ?>">
                            <div class="listing-info">
                                <h2><?php echo $apartment['title']; ?></h2>
                                <p><?php echo $apartment['description']; ?></p>

                                <div class="listing-button">
                                    <button type="button" onclick="window.location.href='details.php?id=<?php echo $apartment['id']; ?>'">View Apartment</button>
                                </div>

                                <div class="listing-details">
                                    <div>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo $apartment['location']; ?></span>
                                    </div>
                                    <div>
                                        <i class="fas fa-money-bill-alt"></i>
                                        <span>Ksh.<?php echo $apartment['price']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php }

                    ?>
                <?php endif; ?>

            </div>


            <div class="number-links">
                <?php
                // Output pagination links
                
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<span>$i</span>";
                    } else {
                        echo "<a href='listings.php?page=$i";
                        if (isset($_GET['location'])) {
                            echo "&location=" . $_GET['location'];
                        }
                        if (isset($_GET['price-range'])) {
                            echo "&price-range=" . $_GET['price-range'];
                        }
                        if (isset($_GET['bedrooms'])) {
                            echo "&bedrooms=" . $_GET['bedrooms'];
                        }
                        if (isset($_GET['arrivals']) && isset($_GET['leaving'])) {
                            echo "&arrivals=" . $_GET['arrivals'] . "&leaving=" . $_GET['leaving'];
                        }
                        echo "'>$i</a>";
                    }
                }
                
                ?>
            </div>

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