<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID du document non spécifié.");
}

// Récupérer l'ID du document
$id = $_GET['id'];

// Récupérer les informations du document avant de le supprimer (pour supprimer le fichier sur le serveur si nécessaire)
$sql = "SELECT chemin FROM documents WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le document existe, supprimer le fichier du serveur (si le fichier est trouvé)
if ($document && file_exists($document['chemin'])) {
    unlink($document['chemin']); // Supprimer le fichier du serveur
}

// Supprimer le document de la base de données
$sql = "DELETE FROM documents WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Rediriger vers la liste des documents après suppression
header("Location: create_document.php");
exit();
?>
