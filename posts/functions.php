<?php
class posts
{
    private $db = null;

    public function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'icym2');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getPosts()
    {
        $query = "SELECT * FROM posts";
        $result = $this->db->query($query);
        if (!$result) {
            die("Error retrieving posts: " . $this->db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            die("Error executing statement: " . $stmt->error);
        }
        return $result->fetch_assoc();
    }

    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>
