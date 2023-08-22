<?php
require_once('vendor/autoload.php'); // Include Stripe PHP library

$stripe = [
  "secret_key"      => "sk_test_51Mid0vJxYaGDhDactHQA2Zj4z0bfUvOCy8b2fImlXwi99eJe3sytzcZOK8IECwRj3hp3sy3UQEbbu0jfinnv7LXP00F3UPOmzp",
  "publishable_key" => "pk_test_51Mid0vJxYaGDhDacJJf0OOmAxqqZw1SNb5aY2zgNKm0CcclVUbFkRCicrwv1EhO61EDKanqRRIDDYPD0MdTHSlJc00rrk3hkSu"
];

\Stripe\Stripe::setApiKey($stripe['secret_key']); // Set the API key

$token  = $_POST['stripeToken'];
$booking_id = $_POST['id'];
$amount = 1000; // Amount in cents

try {
  // Charge the user's card
  $charge = \Stripe\Charge::create([
    'amount' => $amount,
    'currency' => 'usd',
    'description' => 'Booking Payment',
    'source' => $token,
  ]);

  // Update the booking status in your database
  $servername = "localhost";
  $username = "id21172805_stevencodeblooded";
  $password = "@Cruzah1234";
  $dbname = "id21172805_steven";

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "UPDATE book_details SET status = 'paid' WHERE id = '$booking_id'";
  if (mysqli_query($conn, $sql)) {
    header('Location: payment_success.php'); // Redirect to payment success page
    exit();
  } else {
    header('Location: payment_error.php'); // Redirect to payment error page
    exit();
  }

  mysqli_close($conn);

} catch(\Stripe\Exception\CardException $e) {
  // If the card is declined, display an error message to the user
  header('Location: payment_error.php');
  exit();
}
?>
