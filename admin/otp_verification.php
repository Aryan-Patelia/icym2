<?php
// Start session (if not already started)
session_start();

// Check if OTP is stored in the session
if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    // OTP is not set, redirect user to the login page
    header("Location: login.php");
    exit();
}

// Check if the OTP form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if OTP is provided
    if (isset($_POST['otp'])) {
        // Verify if provided OTP matches the OTP stored in the session
        if ($_POST['otp'] == $_SESSION['otp']) {
            // OTP verification successful, log the user in
            // Here, you can redirect the user to the dashboard or any other authenticated page
            // For example:
            // header("Location: dashboard.php");
            // exit();
            echo "OTP verification successful. You are now logged in.";
            // Unset the OTP from the session
            unset($_SESSION['otp']);
            unset($_SESSION['email']);
        } else {
            // OTP verification failed, display error message
            $error_message = "Invalid OTP. Please try again.";
        }
    } else {
        // OTP is not provided, display error message
        $error_message = "Please enter the OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">OTP Verification</h1>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <label for="otp" class="form-label">Enter OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
</div>

</body>
</html>
