<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Ajout d'un employé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $courriel = $_POST["courriel"];
    $telephone = $_POST["telephone"];
    $poste = $_POST["poste"];

    $sql = "INSERT INTO employes (nom, prenom, email, telephone, poste) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $courriel, $telephone, $poste]);

    header("Location: create_employe.php"); // Rafraîchir la page après ajout
    exit();
}

// Récupérer la liste des employés
$employes = $pdo->query("SELECT * FROM employes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Ajouter un Employé</h2>

    <!-- Formulaire d'ajout -->
    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Prénom :</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email :</label>
                <input type="email" name="courriel" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone :</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Poste :</label>
                <input type="text" name="poste" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- Liste des employés -->
    <h3 class="text-center">Liste des Employés</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Poste</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employes as $employe): ?>
            <tr>
                <td><?= htmlspecialchars($employe["id"]) ?></td>
                <td><?= htmlspecialchars($employe["nom"]) ?></td>
                <td><?= htmlspecialchars($employe["prenom"]) ?></td>
                <td><?= htmlspecialchars($employe["email"]) ?></td>
                <td><?= htmlspecialchars($employe["telephone"]) ?></td>
                <td><?= htmlspecialchars($employe["poste"]) ?></td>
                <td>
                    <a href="update_employe.php?id=<?= $employe['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="delete_employe.php?id=<?= $employe['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Retour</a>
</div>
</body>
</html>
