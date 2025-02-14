<?php
class Room
{
    private $conn;
    private $table = "rooms";

    public $id;
    public $room_number;
    public $room_type;
    public $price;
    public $availability;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createRoom()
    {
        $query = "INSERT INTO " . $this->table . " (room_number, room_type, price) VALUES (:room_number, :room_type, :price)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":room_number", $this->room_number);
        $stmt->bindParam(":room_type", $this->room_type);
        $stmt->bindParam(":price", $this->price);

        return $stmt->execute();
    }

    public function getRooms()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
