<?php
include 'includes/db.php';

function getTeamsFromDatabase($conn) {
    $query = "SELECT id, nom FROM equipes";
    $stmt = $conn->query($query);
    return $stmt->fetchAll();
}

$teams = getTeamsFromDatabase($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Manager | Simuler un Match</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/simulate.css">
</head>
<body>
    <!-- Navbar -->
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
                    <a class="nav-link" href="modifier.php">
                        <i class="fas fa-edit"></i> Modifier une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="simulate_match.php">
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
                    <a href="modifier.php" class="nav-link">
                    <i class="fas fa-edit"></i> Modifier une équipe
                    </a>
                </li>
                <li class="nav-item">
                    <a href="simulate_match.php" class="nav-link active">
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
                <h1 class="text-center mb-4">Simuler un Match</h1>
                <form method="POST" action="match.php">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="team1" class="form-label">Choisir l'Équipe 1</label>
                            <div class="team-select">
                                <select name="team1" id="team1" class="form-select custom-select">
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['nom'], ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="team2" class="form-label">Choisir l'Équipe 2</label>
                            <div class="team-select">
                                <select name="team2" id="team2" class="form-select custom-select">
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['nom'], ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark btn-lg w-100">
                        <i class="fas fa-play"></i> Simuler le Match
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
