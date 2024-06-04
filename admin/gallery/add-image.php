<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}


require_once '../../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $folderId = filter_input(INPUT_POST, 'tbl_image_folder_id', FILTER_SANITIZE_NUMBER_INT);
    
    if (!empty($_FILES['image_names']['name'][0])) {
        $fileCount = count($_FILES['image_names']['name']);
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        for ($i = 0; $i < $fileCount; $i++) {
            $imageName = $_FILES['image_names']['name'][$i];
            $imageTmpName = $_FILES['image_names']['tmp_name'][$i];
            $imageSize = $_FILES['image_names']['size'][$i];
            $imageError = $_FILES['image_names']['error'][$i];

            // Get the MIME type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $imageType = $finfo->file($imageTmpName);

            // Validate the file extension and MIME type
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            if (in_array($imageExt, $allowed) && ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/gif')) {
                if ($imageError === 0) {
                    if ($imageSize < 500000000) { // 5MB limit
                        $imageNameNew = uniqid('', true) . "." . $imageExt;
                        $imageDestination = 'images/' . $imageNameNew;

                        if (move_uploaded_file($imageTmpName, $imageDestination)) {
                            // Set the file permissions to be read-only by the owner
                            chmod($imageDestination, 0644);

                            try {
                                $conn->beginTransaction();

                                $sql = "INSERT INTO tbl_image (image_name, tbl_image_folder_id) VALUES (:image_name, :folder_id)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':image_name', $imageNameNew);
                                $stmt->bindParam(':folder_id', $folderId);
                                $stmt->execute();

                                $conn->commit();
                            } catch (PDOException $e) {
                                $conn->rollBack();
                                echo "Error: " . $e->getMessage();
                            }
                        } else {
                            echo "Error uploading image $imageName";
                        }
                    } else {
                        echo "File $imageName is too large.";
                    }
                } else {
                    echo "Error uploading file $imageName.";
                }
            } else {
                echo "File type $imageType not allowed for $imageName.";
            }
        }
    }
    header("Location: index.php");
    exit();
}
?>
