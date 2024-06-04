<?php
require_once __DIR__ . '/../db_connect.php';

class posts
{
    private $db = null;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function getPosts()
    {
        $query = "SELECT * FROM posts";
        $stmt = $this->db->query($query);
        if (!$stmt) {
            die("Error retrieving posts: " . $this->db->errorInfo()[2]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $query = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Error preparing statement: " . $this->db->errorInfo()[2]);
        }
        $stmt->bindParam(':id', $id);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->errorInfo()[2]);
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
