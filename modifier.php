<?php
include 'includes/db.php';

$message = null;
$alertType = null; 

$teams = [];
try {
    $stmt = $conn->query("SELECT * FROM equipes");
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Erreur : " . $e->getMessage();
    $alertType = "error";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamId = $_POST['team_id'] ?? null;
    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';
    $logo = $_FILES['logo'] ?? null;

    if (!empty($teamId)) {
        $logoPath = null;
        if ($logo && $logo['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($logo['type'], $allowedTypes)) {
                $targetDir = 'uploads/logos/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
                }
                $logoPath = $targetDir . uniqid() . '-' . basename($logo['name']);
                move_uploaded_file($logo['tmp_name'], $logoPath);
            } else {
                $message = "Le fichier du logo doit être une image (JPEG, PNG ou GIF).";
                $alertType = "error";
            }
        }

        try {
            $stmt = $conn->prepare("UPDATE equipes SET nom = :nom, description = :description, logo = :logo WHERE id = :team_id");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':logo', $logoPath);
            $stmt->bindParam(':team_id', $teamId);

            if ($stmt->execute()) {
                $message = "Équipe mise à jour avec succès !";
                $alertType = "success";
            } else {
                $message = "Erreur : Impossible de mettre à jour l'équipe.";
                $alertType = "error";
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
            $alertType = "error";
        }
    } else {
        $message = "L'identifiant de l'équipe est requis !";
        $alertType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Manager | Modifier une équipe</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/ajouter.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-trophy"></i> League Manager
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ajouter.php">
                        <i class="fas fa-plus-circle"></i> Ajouter une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="modifier.php">
                        <i class="fas fa-edit"></i> Modifier une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="simulate_match.php">
                        <i class="fas fa-futbol"></i> Simuler un match
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classement.php">
                        <i class="fas fa-list-ol"></i> Classement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historique.php">
                        <i class="fas fa-history"></i> Historique des matches
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3 class="text-center mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="ajouter.php" class="nav-link">
                        <i class="fas fa-plus-circle"></i> Ajouter une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a href="modifier.php" class="nav-link active">
                    <i class="fas fa-edit"></i> Modifier une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a href="simulate_match.php" class="nav-link">
                        <i class="fas fa-futbol"></i> Simuler un match
                    </a>
                </li>
                <li class="nav-item">
                    <a href="classement.php" class="nav-link">
                        <i class="fas fa-list-ol"></i> Classement
                    </a>
                </li>
                <li class="nav-item">
                    <a href="historique.php" class="nav-link">
                        <i class="fas fa-history"></i> Historique des matches
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-container">
                <h1 class="text-center mb-4">Modifier une Équipe</h1>
                <form method="POST" action="modifier.php" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="team_id" class="form-label">Sélectionner l'Équipe</label>
                        <select name="team_id" id="team_id" class="form-select form-control-lg" required>
                            <option value="">Sélectionner une équipe</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="nom" class="form-label">Nom de l'Équipe</label>
                        <input type="text" name="nom" id="nom" class="form-control form-control-lg" placeholder="Entrez le nom de l'équipe" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control form-control-lg" rows="4" placeholder="Ajoutez une description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="logo" class="form-label">Logo de l'Équipe</label>
                        <input type="file" name="logo" id="logo" class="form-control form-control-lg" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-dark btn-lg w-100">Modifier</button>
                </form>
            </div>
        </div>
    </div>

    <?php if ($message && $alertType): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '<?= $alertType ?>', 
                    title: '<?= $message ?>',
                    confirmButtonText: 'OK'
                }).then(() => {
                    <?php if ($alertType === 'success'): ?>
                        window.location.href = 'index.php';
                    <?php endif; ?>
                });
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
