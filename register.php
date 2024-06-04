<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .password-toggle {
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.querySelectorAll('.password-toggle');
            togglePassword.forEach(item => {
                item.addEventListener('click', function() {
                    const passwordField = document.getElementById(this.dataset.target);
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });

            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordMessage = document.getElementById('password-message');

            confirmPassword.addEventListener('input', () => {
                if (password.value !== confirmPassword.value) {
                    passwordMessage.textContent = 'Passwords do not match';
                } else {
                    passwordMessage.textContent = '';
                }
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
                            <img class="img-fluid rounded-start w-auto mt-5 h-auto object-fit-cover" loading="lazy" src="icym_25.png" alt="Welcome!">
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                            <div class="col-12 col-lg-11 col-xl-10">
                                <div class="card-body p-3 p-md-4 p-xl-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-5">
                                                <div class="text-center mb-4"></div>
                                                <h4 class="text-center">Sign Up</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="signup.php" method="post" enctype="multipart/form-data">
                                        <div class="row gy-3 overflow-hidden">
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="file" class="form-control" name="photo" id="photo" required>
                                                    <label for="photo" class="form-label">Photo</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" required>
                                                    <label for="name" class="form-label">Name</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" name="gender" id="gender" required>
                                                        <option value="" selected disabled>Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <label for="gender" class="form-label">Gender</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" name="age" id="age" placeholder="Age" required>
                                                    <label for="age" class="form-label">Age</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                                    <label for="email" class="form-label">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" required>
                                                    <label for="mobile" class="form-label">Mobile Number</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                                    <label for="password" class="form-label">Password</label>
                                                    <i class="fa fa-eye-slash password-toggle" data-target="password"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                                    <i class="fa fa-eye-slash password-toggle" data-target="confirm_password"></i>
                                                    <div id="password-message" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" name="birthday" id="birthday" placeholder="Birthday" required>
                                                    <label for="birthday" class="form-label">Birthday</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="country" id="country" placeholder="Country" required>
                                                    <label for="country" class="form-label">Country</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                                                    <label for="city" class="form-label">City</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="parish" id="parish" placeholder="Parish" required>
                                                    <label for="parish" class="form-label">Parish</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="education_occupation" id="education_occupation" placeholder="Education/Occupation" required>
                                                    <label for="education_occupation" class="form-label">Education/Occupation</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-dark btn-lg" type="submit">Sign Up Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                <a href="login.php" class="link-secondary text-decoration-none">Already have an account? Log in</a>
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
</body>
</html>
