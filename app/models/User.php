<?php
class User
{
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createUser()
    {
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));

        return $stmt->execute();
    }

    public function checkUser()
    {
        $query = "SELECT id, password, role, username FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
        return $stmt;
    }

    public function getUserById()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }
}
