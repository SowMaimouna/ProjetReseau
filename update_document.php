<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID du document non spécifié.");
}

// Récupérer le document depuis la base de données
$id = $_GET['id'];
$sql = "SELECT * FROM documents WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le document n'existe pas, afficher un message d'erreur
if (!$document) {
    die("Document introuvable.");
}

// Mise à jour des informations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $proprietaire = $_POST["proprietaire"];
    $chemin = $document["chemin"]; // Garder le chemin actuel s'il n'est pas modifié

    // Si un fichier est téléchargé, le traiter
    if ($_FILES['document']['error'] == 0) {
        $fileName = $_FILES['document']['name'];
        $fileTmpName = $_FILES['document']['tmp_name'];
        $filePath = 'uploads/' . basename($fileName);
        move_uploaded_file($fileTmpName, $filePath);
        $chemin = $filePath; // Mettre à jour le chemin du fichier
    }

    $sql = "UPDATE documents SET nom = ?, proprietaire = ?, chemin = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $proprietaire, $chemin, $id]);

    header("Location: create_document.php"); // Redirection vers la liste des documents
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Modifier un Document</h2>

    <!-- Formulaire de modification -->
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom du document :</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($document['nom']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Propriétaire :</label>
                <input type="text" name="proprietaire" class="form-control" value="<?= htmlspecialchars($document['proprietaire']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Fichier (optionnel) :</label>
                <input type="file" name="document" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <a href="create_document.php" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
</body>
</html>
