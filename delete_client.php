<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID du client non spécifié.");
}

// Récupérer l'ID du client
$id = $_GET['id'];

// Supprimer le client
$sql = "DELETE FROM clients WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Rediriger vers la liste des clients après suppression
header("Location: create_client.php");
exit();
?>
