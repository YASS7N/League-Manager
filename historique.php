<?php
// Include the database connection
include 'includes/db.php';

// Query to fetch all match results
$query = "
    SELECT 
        e1.nom AS equipe1,
        e1.logo AS logo1,
        e2.nom AS equipe2,
        e2.logo AS logo2,
        m.score_equipe1,
        m.score_equipe2,
        m.date_match
    FROM matches m
    INNER JOIN equipes e1 ON m.equipe1_id = e1.id
    INNER JOIN equipes e2 ON m.equipe2_id = e2.id
    ORDER BY m.date_match DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Manager | Historique des Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/historique.css">
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
                    <a class="nav-link" href="modifier.php">
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
                    <a class="nav-link active" href="historique.php">
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
                    <a href="historique.php" class="nav-link active">
                        <i class="fas fa-history"></i> Historique des matches
                    </a>
                </li>
            </ul>
        </div>

    <!-- Main Content -->
    <div class="container mt-5"><br>
        <h1 class="text-center mb-4">Historique des Matches</h1>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Équipe 1</th>
                    <th>Score</th>
                    <th>Équipe 2</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>
                            <td>" . date("d-m-Y", strtotime($row['date_match'])) . "</td>
                            <td>
                                <img src='{$row['logo1']}' alt='{$row['equipe1']}' class='team-logo'> {$row['equipe1']}
                            </td>
                            <td>{$row['score_equipe1']} - {$row['score_equipe2']}</td>
                            <td>
                                <img src='{$row['logo2']}' alt='{$row['equipe2']}' class='team-logo'> {$row['equipe2']}
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
