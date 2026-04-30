<?php
// includes/User.php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "Users";
    
    public $UserID;
    public $Username;
    public $Email;
    public $Password;
    public $FirstName;
    public $LastName;
    public $Role;
    public $IsVerified;
    public $StoreName;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Check if username exists
    public function usernameExists($username) {
        $query = "SELECT UserID FROM " . $this->table_name . " WHERE Username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT UserID FROM " . $this->table_name . " WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Register new user
    public function register() {
        // Hash the password
        $hashed_password = password_hash($this->Password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table_name . "
                  SET Username = :username,
                      Email = :email,
                      Password = :password,
                      FirstName = :firstname,
                      LastName = :lastname,
                      Role = :role,
                      StoreName = :storename";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->Username = htmlspecialchars(strip_tags($this->Username));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));
        $this->Role = htmlspecialchars(strip_tags($this->Role));
        $this->StoreName = htmlspecialchars(strip_tags($this->StoreName));
        
        // Bind parameters
        $stmt->bindParam(":username", $this->Username);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":firstname", $this->FirstName);
        $stmt->bindParam(":lastname", $this->LastName);
        $stmt->bindParam(":role", $this->Role);
        $stmt->bindParam(":storename", $this->StoreName);
        
        if($stmt->execute()) {
            $this->UserID = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    // Login user
    public function login($username, $password) {
        $query = "SELECT UserID, Username, Email, Password, Role, IsVerified, IsActive, FirstName, LastName, StoreName
                  FROM " . $this->table_name . " 
                  WHERE (Username = :username OR Email = :username) AND IsActive = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $row['Password'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['UserID'];
                $_SESSION['username'] = $row['Username'];
                $_SESSION['email'] = $row['Email'];
                $_SESSION['role'] = $row['Role'];
                $_SESSION['firstname'] = $row['FirstName'];
                $_SESSION['lastname'] = $row['LastName'];
                $_SESSION['storename'] = $row['StoreName'];
                $_SESSION['is_verified'] = $row['IsVerified'];
                
                // Update last login
                $updateQuery = "UPDATE " . $this->table_name . " SET LastLogin = NOW() WHERE UserID = :userid";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(":userid", $row['UserID']);
                $updateStmt->execute();
                
                return true;
            }
        }
        
        return false;
    }
    
    // Get user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update user role
    public function updateRole($user_id, $new_role) {
        $query = "UPDATE " . $this->table_name . " SET Role = :role WHERE UserID = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $new_role);
        $stmt->bindParam(":user_id", $user_id);
        return $stmt->execute();
    }
}
?>