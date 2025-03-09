<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID du client non spécifié.");
}

// Récupérer le client depuis la base de données
$id = $_GET['id'];
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le client n'existe pas, afficher un message d'erreur
if (!$client) {
    die("Client introuvable.");
}

// Mise à jour des informations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $courriel = $_POST["courriel"];
    $telephone = $_POST["telephone"];
    $entreprise = $_POST["entreprise"];

    $sql = "UPDATE clients SET nom = ?, email = ?, telephone = ?, entreprise = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $courriel, $telephone, $entreprise, $id]);

    header("Location: create_client.php"); // Redirection vers la liste des clients
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Modifier un Client</h2>

    <!-- Formulaire de modification -->
    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom :</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($client['nom']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email :</label>
                <input type="email" name="courriel" class="form-control" value="<?= htmlspecialchars($client['email']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone :</label>
                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($client['telephone']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Entreprise :</label>
                <input type="text" name="entreprise" class="form-control" value="<?= htmlspecialchars($client['entreprise']) ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <a href="create_client.php" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
</body>
</html>
