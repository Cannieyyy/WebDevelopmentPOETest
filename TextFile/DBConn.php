<?php
// DBConn.php - Database connection for the assignment requirement
class DBConn {
    private $host = "localhost";
    private $db_name = "clothing_store";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            echo "✅ Database connection successful!<br>";
            return $this->conn;
        } catch(PDOException $exception) {
            die("❌ Connection error: " . $exception->getMessage());
        }
    }
}
?>