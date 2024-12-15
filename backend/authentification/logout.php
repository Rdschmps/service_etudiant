<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Répondre avec un message JSON pour confirmer la déconnexion
header('Content-Type: application/json');
echo json_encode(['message' => 'Déconnexion réussie.']);
exit();
?>
