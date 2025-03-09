<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Ajout d'un document
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['document'])) {
    $nom = $_POST["nom"];
    $proprietaire = $_POST["proprietaire"];
    
    // Récupérer le fichier téléchargé
    $file = $_FILES['document'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Vérifier s'il n'y a pas d'erreur dans le téléchargement
    if ($fileError === 0) {
        // Créer un nom unique pour le fichier
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileNewName = uniqid('', true) . "." . $fileExtension;
        $fileDestination = 'uploads/' . $fileNewName;

        // Déplacer le fichier dans le dossier "uploads"
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Insérer les informations du document dans la base de données
            $sql = "INSERT INTO documents (nom, proprietaire, chemin) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $proprietaire, $fileDestination]);

            header("Location: create_document.php"); // Rafraîchir la page après ajout
            exit();
        } else {
            echo "Une erreur est survenue lors du téléchargement du fichier.";
        }
    } else {
        echo "Il y a eu une erreur lors du téléchargement du fichier.";
    }
}

// Récupérer la liste des documents
$documents = $pdo->query("SELECT * FROM documents")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Ajouter un Document</h2>

    <!-- Formulaire d'ajout de document -->
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom du Document :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Propriétaire :</label>
                <input type="text" name="proprietaire" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Document :</label>
                <input type="file" name="document" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- Liste des documents -->
    <h3 class="text-center">Liste des Documents</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Propriétaire</th>
                <th>Chemin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
            <tr>
                <td><?= htmlspecialchars($document["id"]) ?></td>
                <td><?= htmlspecialchars($document["nom"]) ?></td>
                <td><?= htmlspecialchars($document["proprietaire"]) ?></td>
                <td><?= htmlspecialchars($document["chemin"]) ?></td>
                <td>
                    <a href="update_document.php?id=<?= $document['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="delete_document.php?id=<?= $document['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce document ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Retour</a>
</div>
</body>
</html>
