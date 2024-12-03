<?php
require_once 'common/Database.php';

try {
    $db = Database::getInstance();
    echo "Connexion à la base de données réussie !";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
