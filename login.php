<?php
session_start();

require_once('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are set in the POST array
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Sanitize and validate inputs
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($_POST['password']);

        if (!$email) {
            echo "<script>alert('Invalid email address. Please try again.');</script>";
            exit();
        }

        try {
            

            $sql = "SELECT ID, Password FROM users WHERE Email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Password'])) {
               
                session_regenerate_id(true);

                // Store user ID in a secure session
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['is_logged_in'] = true;
                $_SESSION['last_activity'] = time(); 
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR']; 

                session_set_cookie_params([
                    'lifetime' => 86400, 
                    'secure' => true,    
                    'httponly' => true,  
                    'samesite' => 'Strict'
                ]);

                header('Location: index.php');
                exit();
            } else {
                echo "<script>alert('Invalid login credentials. Please try again.');</script>";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;  
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .password-toggle {
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</head>
<body>
<section class="bg-light p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11">
                <div class="card border-light-subtle shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-6">
                            <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="icym_25.png" alt="Welcome back!">
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                            <div class="col-12 col-lg-11 col-xl-10">
                                <div class="card-body p-3 p-md-4 p-xl-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-5">
                                                <div class="text-center mb-4">
                                                </div>
                                                <h4 class="text-center">Login</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="login.php" method="post">
                                        <div class="row gy-3 overflow-hidden">
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                                    <label for="email" class="form-label">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                                    <label for="password" class="form-label">Password</label>
                                                    <i class="fa fa-eye-slash password-toggle" id="togglePassword"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                                                    <label class="form-check-label text-secondary" for="remember_me">
                                                        Keep me logged in (**Use cautiously!**)<br>
                                                        <small class="text-muted">Recommended for trusted devices only.</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-dark btn-lg" type="submit">Log in now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                <a href="register.php" class="link-secondary text-decoration-none">Create new account</a>
                                                <a href="forgot_password.php" class="link-secondary text-decoration-none">Forgot password</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<!-- Rest of your HTML code -->
