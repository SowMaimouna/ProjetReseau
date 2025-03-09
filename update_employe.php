<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID de l'employé non spécifié.");
}

// Récupérer l'employé depuis la base de données
$id = $_GET['id'];
$sql = "SELECT * FROM employes WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

// Si l'employé n'existe pas, afficher un message d'erreur
if (!$employe) {
    die("Employé introuvable.");
}

// Mise à jour des informations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $courriel = $_POST["courriel"];
    $telephone = $_POST["telephone"];
    $poste = $_POST["poste"];

    $sql = "UPDATE employes SET nom = ?, prenom = ?, email = ?, telephone = ?, poste = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $courriel, $telephone, $poste, $id]);

    header("Location: create_employe.php"); // Redirection vers la liste des employés
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Modifier un Employé</h2>

    <!-- Formulaire de modification -->
    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom :</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($employe['nom']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Prénom :</label>
                <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($employe['prenom']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email :</label>
                <input type="email" name="courriel" class="form-control" value="<?= htmlspecialchars($employe['email']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone :</label>
                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($employe['telephone']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Poste :</label>
                <input type="text" name="poste" class="form-control" value="<?= htmlspecialchars($employe['poste']) ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <a href="create_employe.php" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
</body>
</html>
