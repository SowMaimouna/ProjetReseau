<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=smarttech_db", "smarttech_user", "motdepassefort");

// Ajout d'un client
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];  // Assurez-vous d'utiliser le même nom de champ que dans la table
    $telephone = $_POST["telephone"];
    $entreprise = $_POST["entreprise"];

    $sql = "INSERT INTO clients (nom, email, telephone, entreprise) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $email, $telephone, $entreprise]);

    header("Location: create_client.php"); // Rafraîchir la page après ajout
    exit();
}

// Récupérer la liste des clients
$clients = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Ajouter un Client</h2>

    <!-- Formulaire d'ajout -->
    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email :</label>
                <input type="email" name="email" class="form-control" required> <!-- Correction ici -->
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone :</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Entreprise :</label>
                <input type="text" name="entreprise" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- Liste des clients -->
    <h3 class="text-center">Liste des Clients</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Entreprise</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client["id"]) ?></td>
                <td><?= htmlspecialchars($client["nom"]) ?></td>
                <td><?= htmlspecialchars($client["email"]) ?></td> <!-- Correction ici -->
                <td><?= htmlspecialchars($client["telephone"]) ?></td>
                <td><?= htmlspecialchars($client["entreprise"]) ?></td>
                <td>
                    <a href="update_client.php?id=<?= $client['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="delete_client.php?id=<?= $client['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Retour</a>
</div>
</body>
</html>
