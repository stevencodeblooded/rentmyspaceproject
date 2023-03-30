<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get booking ID from URL parameter
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];

// Retrieve booking details from database
$sql = "SELECT * FROM book_details WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    header('Location: index.php');
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="payment-wrapper">
        <div class="container-payment">
            <h1 class="title">Make Payment</h1>
            <form id="payment-form" method="POST" action="charge.php">

                <div class="form-row">
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display Element errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>

                <button id="submit-button" class="btn-payment">Pay Now</button>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form>
        </div>
    </div>

    <script>
        // Create a Stripe client
        var stripe = Stripe('pk_test_51Mid0vJxYaGDhDacJJf0OOmAxqqZw1SNb5aY2zgNKm0CcclVUbFkRCicrwv1EhO61EDKanqRRIDDYPD0MdTHSlJc00rrk3hkSu');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Create an instance of the card Element
        var card = elements.create('card');

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            // Disable the submit button to prevent multiple clicks
            document.getElementById('submit-button').disabled = true;

            // Create a token from the card Element
            stripe.createToken(card).then(function(result) {
                // If the token was created successfully, submit the payment form
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;

                    // Re-enable the submit button
                    document.getElementById('submit-button').disabled = false;
                } else {
                    // Insert the token ID into the form so it gets submitted to the server
                    var tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = 'stripeToken';
                    tokenInput.value = result.token.id;
                    form.appendChild(tokenInput);

                    // Submit the form
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>