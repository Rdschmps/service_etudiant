<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Chemin relatif au fichier 'vendor/autoload.php'

use Dotenv\Dotenv;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Configurer la connexion à la base de données
        $host = $_ENV['DB_HOST'];
        $name = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        $this->connection = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
