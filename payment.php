<?php
require "includes/common.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the user input
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $payment_mode = mysqli_real_escape_string($con, $_POST['payment_mode']);
    
    // You can further validate the input if needed
    
    // Update the order status to "Confirmed" in the database
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE users_products SET status='Confirmed' WHERE user_id='$user_id' AND status='Added to cart'";
    mysqli_query($con, $query);

    // Redirect to success page after processing the payment
    header("Location: success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planet Shopify | Online Shopping Site for Men</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header_menu.php'; ?>
    <div class="container-fluid mt-5 pt-5" id="content" style="margin-bottom:200px">
        <div class="col-md-8 mx-auto">
            <div class="jumbotron text-center">
                <h3>Your order is confirmed. Please complete your payment.</h3><hr>
                <!-- Payment Form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="payment_mode">Payment Mode:</label>
                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="PayPal">PayPal</option>
                            <!-- Add more payment options as needed -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Make Payment</button>
                </form>
            </div>
        </div>
    </div>
    <!-- footer-->
    <?php include 'includes/footer.php'?>
    <!--footer ends-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });

        $(document).ready(function() {
            if(window.location.href.indexOf('#login') != -1) {
                $('#login').modal('show');
            }
        });
    </script>
</body>
</html>
