<?php
session_start();

require_once('db_connect.php');

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Sanitize and validate inputs
$name = sanitizeInput($_POST['name']);
$gender = sanitizeInput($_POST['gender']);
$age = filter_var(sanitizeInput($_POST['age']), FILTER_VALIDATE_INT);
$email = filter_var(sanitizeInput($_POST['email']), FILTER_VALIDATE_EMAIL);
$mobile = sanitizeInput($_POST['mobile']);
$password = sanitizeInput($_POST['password']);
$confirm_password = sanitizeInput($_POST['confirm_password']);
$birthday = sanitizeInput($_POST['birthday']);
$country = sanitizeInput($_POST['country']);
$city = sanitizeInput($_POST['city']);
$parish = sanitizeInput($_POST['parish']);
$education_occupation = sanitizeInput($_POST['education_occupation']);
$isAdmin = "No";
// Handle file upload securely
if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    $file_info = pathinfo($_FILES["photo"]["name"]);
    $imageFileType = strtolower($file_info['extension']);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate file type
    if (!in_array($imageFileType, $allowed_extensions)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if ($_FILES["photo"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }


    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }


    $new_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }
} else {
    die("Error uploading file: " . $_FILES["photo"]["error"]);
}

// Check if passwords match
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO users (photo, name, gender, age, email, mobile, password, birthday, country, city, parish, education_occupation , isAdmin) 
            VALUES (:photo, :name, :gender, :age, :email, :mobile, :password, :birthday, :country, :city, :parish, :education_occupation , :isAdmin)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':photo', $target_file);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':parish', $parish);
    $stmt->bindParam(':education_occupation', $education_occupation);
    $stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_STR); 

    $stmt->execute();

    $_SESSION['user_id'] = $conn->lastInsertId(); 
    $_SESSION['is_logged_in'] = true;
    session_regenerate_id(true);  

    header('Location: index.php');
    exit();
} catch(PDOException $e) {
    
    error_log("Database error: " . $e->getMessage());
    echo " error ";
}

$conn = null;  
?>
