<?php
session_start();
require_once '../common/Database.php'; // Assure-toi que le chemin est correct

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/login.html");
    exit();
}

try {
    // Connexion à la base de données
    $db = Database::getInstance();

    // Récupérer le nombre de points de l'utilisateur
    $stmt = $db->prepare("SELECT points FROM users WHERE id = :user_id");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $points = $user['points'] ?? 0; // Par défaut, 0 points si non trouvé
} catch (PDOException $e) {
    $points = 'Erreur lors de la récupération des points';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    <p>Email : <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <p>Nombre de points : <strong><?php echo htmlspecialchars($points); ?></strong></p>
    <a href="./logout.php">Se déconnecter</a>
</body>
</html>
