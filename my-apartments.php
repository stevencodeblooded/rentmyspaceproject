<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "book_db");

// Get the apartments listed by the current user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM submit_form WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>My Apartments</title>
</head>

<body>
    <style>
        body {
            background-color: #F5F5F5;
            font-family: sans-serif;
            font-size: 1.1em;
        }

        .all-my-apartments {
            margin: 20px;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 20px;
        }

        h1 {
            font-size: 3.3em;
            margin-bottom: 20px;
            color: #ea1538;
            margin-top: 10px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            border: 2px solid #CCCCCC;
            width: 100%;
        }

        thead {
            background-color: #F5F5F5;
        }

        th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #333333;
            border: 2px solid #CCCCCC;
        }

        td {
            padding: 10px;
            border: 2px solid #CCCCCC;
        }

        tr:nth-child(even) {
            background-color: #F5F5F5;
        }

        tr:hover {
            background-color: #CCCCCC;
        }

        .all-my-apartments a {
            text-decoration: none;
            color: #333333;
            padding: 5px;
            border: 1px solid #333333;
            border-radius: 5px;
            margin-right: 10px;
            margin-top: 20px;
        }

        .all-my-apartments a:hover {
            background-color: #333333;
            color: #FFFFFF;
        }

        .index-page-link {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            background-color: #ea1538;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            margin-left: 42%;
        }

        .index-page-link:hover {
            background-color: #ff5361;
            color: #000;
        }
        
    </style>

    <div class="all-my-apartments">
        <h1>My Listed Apartments</h1>

        <table>
            <thead>
                <tr>
                    <th>Apartment ID</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the apartments listed by the current user
                while ($row = mysqli_fetch_assoc($result)) {
                    $apartment_id = $row['id'];
                    $title = $row['title'];
                    $location = $row['location'];
                    $price = $row['price'];
                    $description = $row['description'];
                ?>
                    <tr>
                        <td><?php echo $apartment_id; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $location; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $description; ?></td>
                        <td>
                            <a href="edit-apartment.php?id=<?php echo $apartment_id; ?>">Edit</a>
                            <a href="delete-apartment.php?id=<?php echo $apartment_id; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add-apartment.php">Add Apartment</a>
    </div>

    <a href="index.php" class="index-page-link">Go to Home Page</a>

</body>

</html>