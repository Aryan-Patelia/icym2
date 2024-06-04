<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.tiny.cloud/1/4jl60m8r1p6peancxhrit88wrjalewqoca12pfh8anpxwmc9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '#description',
                plugins: "a11ychecker advcode advlist advtable anchor autocorrect autosave editimage image link linkchecker lists media mediaembed pageembed powerpaste searchreplace table template tinymcespellchecker typography visualblocks wordcount",
                toolbar: "undo redo | styles | bold italic underline strikethrough | align | table link image media pageembed | bullist numlist outdent indent | spellcheckdialog a11ycheck typography code",
                height: 540,
                a11ychecker_level: "aaa",
                typography_langs: ["en-US"],
                typography_default_lang: "en-US",
                advcode_inline: true,
                content_style: `
                    body {
                      font-family: 'Roboto', sans-serif;
                      color: #222;
                    }
                    img {
                      height: auto;
                      margin: auto;
                      padding: 10px;
                      display: block;
                    }
                    img.medium {
                      max-width: 25%;
                    }
                    a {
                      color: #116B59;
                    }
                    .related-content {
                      padding: 0 10px;
                      margin: 0 0 15px 15px;
                      background: #eee;
                      width: 200px;
                      float: right;
                    }
                  `,
            });
        });
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create New Post</h5>
            </div>
            <div class="card-body">
                <!-- Form to submit new post -->
                <form action="process_post.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php
                            require_once __DIR__ . '/../../db_connect.php';
                            $result = $conn->query("SELECT ID, category_name FROM post_category");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['ID'] . "'>" . $row['category_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Content</label>
                        <textarea id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
