<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID de l'employé non spécifié.");
}

// Récupérer l'ID de l'employé
$id = $_GET['id'];

// Supprimer l'employé
$sql = "DELETE FROM employes WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Rediriger vers la liste des employés après suppression
header("Location: create_employe.php");
exit();
?>
