<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'ospduorg_istdrv_db';
    private $username = 'ospduorg_istdrv_db';
    private $password = 'yWah5H2YHLMdaHcpUQsH';
    private $conn;



    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function createTables() {
        try {
            // Table users
            $sql = "CREATE TABLE IF NOT EXISTS user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                photo VARCHAR(255),
                role ENUM('admin', 'user') DEFAULT 'user',
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);

            /* Table categories (exemple)
            $sql = "CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                image VARCHAR(255),
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);

            // Table products (exemple)
            $sql = "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(200) NOT NULL,
                description TEXT,
                price DECIMAL(10,2),
                category_id INT,
                image VARCHAR(255),
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            )";
            $this->conn->exec($sql);*/

            // Créer un utilisateur admin par défaut
            $this->createDefaultAdmin();

        } catch(PDOException $e) {
            echo "Erreur lors de la création des tables: " . $e->getMessage();
        }
    }

    private function createDefaultAdmin() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM user WHERE role = 'admin'");
        $stmt->execute();
        
        if ($stmt->fetchColumn() == 0) {
            $password = password_hash('80664212_$Theo', PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO user (username, email, password, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@iabstrack.com', $password, 'Super', 'Admin', 'admin']);
        }
    }

    public function getAllTables() {
        try {
            $stmt = $this->conn->prepare("SHOW TABLES");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function getTableColumns($tableName) {
        try {
            $stmt = $this->conn->prepare("DESCRIBE `$tableName`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function getTableData($tableName, $limit = 50) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `$tableName` LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>