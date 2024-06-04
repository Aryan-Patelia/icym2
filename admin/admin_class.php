<?php
session_start();

class Action {
    private $db;

    public function __construct() {
        include '../db_connect.php';
        $this->db = $conn;
    }

    public function __destruct() {
        $this->db->close();
    }

    public function login() {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            return 0; // Invalid request
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                foreach ($row as $key => $value) {
                    if ($key !== 'password' && !is_numeric($key)) {
                        $_SESSION['login_'.$key] = $value;
                    }
                }
                return 1; // Successful login
            } else {
                return 2; // Incorrect password
            }
        } else {
            return 3; // User not found
        }
    }

    public function logout() {
        session_destroy();
        header("location: login.php");
        exit;
    }

    public function save_settings() {
        if (!isset($_POST['name'], $_POST['email'], $_POST['about'], $_POST['contact'])) {
            return 0; // Invalid request
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $about = htmlentities($_POST['about'], ENT_QUOTES);
        $contact = $_POST['contact'];

        $stmt = $this->db->prepare("SELECT * FROM site_settings");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $stmt = $this->db->prepare("UPDATE site_settings SET blog_name = ?, email = ?, about = ?, contact = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $email, $about, $contact, $id);
        } else {
            $stmt = $this->db->prepare("INSERT INTO site_settings (blog_name, email, about, contact) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $about, $contact);
        }

        $stmt->execute();

        return ($stmt->affected_rows > 0) ? 1 : 0;
    }

    public function save_category() {
        if (!isset($_POST['name'], $_POST['description'])) {
            return json_encode(array('status' => 0, 'msg' => 'Invalid request'));
        }

        $name = $_POST['name'];
        $description = $_POST['description'];

        if (empty($_POST['id'])) {
            $stmt = $this->db->prepare("SELECT * FROM category WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return json_encode(array('status' => 2, 'msg' => 'Category already exists'));
            } else {
                $stmt = $this->db->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
                $stmt->bind_param("ss", $name, $description);
            }
        } else {
            $id = $_POST['id'];
            $stmt = $this->db->prepare("SELECT * FROM category WHERE name = ? AND id != ?");
            $stmt->bind_param("si", $name, $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return json_encode(array('status' => 2, 'msg' => 'Category already exists'));
            } else {
                $stmt = $this->db->prepare("UPDATE category SET name = ?, description = ? WHERE id = ?");
                $stmt->bind_param("ssi", $name, $description, $id);
            }
        }

        $stmt->execute();

        return ($stmt->affected_rows > 0) ? json_encode(array('status' => 1)) : json_encode(array('status' => 0));
    }

    public function load_category() {
        $qry = $this->db->query("SELECT * FROM category WHERE status = 1");
        $data = array();
        while ($row = $qry->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    public function load_post() {
        $qry = $this->db->query("SELECT p.*, c.name AS category FROM posts p INNER JOIN category c ON c.id = p.category_id ");
        $data = array();
        while ($row = $qry->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    public function remove_category() {
        if (!isset($_POST['id'])) {
            return 0; // Invalid request
        }

        $id = $_POST['id'];
        $stmt = $this->db->prepare("UPDATE category SET status = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return ($stmt->affected_rows > 0) ? 1 : 0;
    }

    public function publish_post() {
        if (!isset($_POST['id'])) {
            return 0; // Invalid request
        }

        $id = $_POST['id'];
        $stmt = $this->db->prepare("UPDATE posts SET status = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return ($stmt->affected_rows > 0) ? 1 : 0;
    }

    public function remove_post() {
        if (!isset($_POST['id'])) {
            return 0; // Invalid request
        }

        $id = $_POST['id'];
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return ($stmt->affected_rows > 0) ? 1 : 0;
    }

    public function save_post() {
        if (!isset($_POST['name'], $_POST['post'], $_POST['category_id'])) {
            return json_encode(array('status' => 0, 'msg' => 'Invalid request'));
        }

        $name = $_POST['name'];
        $post = htmlentities($_POST['post'], ENT_QUOTES);
        $category_id = $_POST['category_id'];

        $data = " title = ?, post = ?, category_id = ? ";
        $params = array($name, $post, $category_id);

        if (!empty($_FILES['img']['tmp_name'])) {
            $fname = strtotime(date('Y-m-d H:i')).'_'.$_FILES['img']['name'];
            $move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/'. $fname);
            if ($move) {
                $data .= ", img_path = ? ";
                $params[] = $fname;
            }
        }

        if (empty($_POST['id'])) {
            $stmt = $this->db->prepare("INSERT INTO posts SET ".$data);
        } else {
            $id = $_POST['id'];
            $data .= ", date_published = '".date('Y-m-d H:i')."' ";
            $params[] = $id;
            $stmt = $this->db->prepare("UPDATE posts SET ".$data." WHERE id = ?");
        }

        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return ($stmt->affected_rows > 0) ? json_encode(array('status' => 1, 'id' => $this->db->insert_id)) : json_encode(array('status' => 0));
    }
}
?>
