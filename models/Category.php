<?php
class Category {
    // DB Stuff
    private $conn;
    private $table = 'categories';
    
    // Properties
    public $id;
    public $name;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get categories
    public function read() {
        // Create query
        $query = 'SELECT id, name, created_at FROM ' . $this->table . ' ORDER BY created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single category
    public function read_single() {
        // Create query
        $query = 'SELECT c.id, c.name, c.created_at FROM ' . $this->table . ' c WHERE c.id = :id LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        // Fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }

    // Create category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if( $stmt->execute() ) {
            return true;
        }

        // Print error if something goes wrong
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    // Update category
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlentities(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if( $stmt->execute() ) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete category
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if( $stmt->execute() ) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}