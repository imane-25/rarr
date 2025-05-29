<?php
class Database {
    private static $instance = null;
    private $pdo;
    
    // Configuration de la base de données (à adapter)
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'beldi_artisanat';
    private const DB_USER = 'root';
    private const DB_PASS = '';

    private function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8',
                self::DB_USER,
                self::DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            throw new Exception('Database connection failed');
        }
    }

    public static function connect() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    // Empêcher le clonage et la désérialisation
    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Fonction utilitaire pour les requêtes
function db_query(string $sql, array $params = []) {
    try {
        $pdo = Database::connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        throw $e;
    }
}
?>