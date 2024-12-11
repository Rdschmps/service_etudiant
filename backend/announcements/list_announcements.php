<?php
require_once '../common/Database.php';

class Announcement {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT a.id, a.title, a.description, a.created_at, u.username 
                                      FROM announcements a 
                                      JOIN users u ON a.user_id = u.id 
                                      ORDER BY a.created_at DESC");
            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $announcements;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des annonces : " . $e->getMessage();
        }
    }
}

$announcement = new Announcement();
$announcements = $announcement->getAll();

header('Content-Type: application/json');
echo json_encode($announcements);
?>
 