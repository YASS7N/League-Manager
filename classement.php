<?php
include 'includes/db.php';

$query = "
SELECT 
    e.nom, 
    e.logo,
    COUNT(CASE WHEN (m.equipe1_id = e.id AND m.score_equipe1 > m.score_equipe2) OR 
                     (m.equipe2_id = e.id AND m.score_equipe2 > m.score_equipe1) 
              THEN 1 ELSE NULL END) AS wins,
    COUNT(CASE WHEN (m.equipe1_id = e.id AND m.score_equipe1 < m.score_equipe2) OR 
                     (m.equipe2_id = e.id AND m.score_equipe2 < m.score_equipe1) 
              THEN 1 ELSE NULL END) AS losses,
    COUNT(CASE WHEN (m.score_equipe1 = m.score_equipe2) AND 
                     (m.equipe1_id = e.id OR m.equipe2_id = e.id) 
              THEN 1 ELSE NULL END) AS draws,
    COUNT(CASE WHEN m.equipe1_id = e.id OR m.equipe2_id = e.id THEN 1 ELSE NULL END) AS games_played,
    SUM(CASE WHEN m.equipe1_id = e.id THEN m.score_equipe1 ELSE 0 END) AS goals_scored,
    SUM(CASE WHEN m.equipe2_id = e.id THEN m.score_equipe2 ELSE 0 END) AS goals_conceded,
    SUM(CASE WHEN m.equipe1_id = e.id THEN m.score_equipe1 - m.score_equipe2
             WHEN m.equipe2_id = e.id THEN m.score_equipe2 - m.score_equipe1 ELSE 0 END) AS goal_difference,
    SUM(CASE WHEN (m.equipe1_id = e.id AND m.score_equipe1 > m.score_equipe2) THEN 3
             WHEN (m.equipe2_id = e.id AND m.score_equipe2 > m.score_equipe1) THEN 3
             WHEN (m.score_equipe1 = m.score_equipe2) THEN 1
             ELSE 0 END) AS points
FROM equipes e
LEFT JOIN matches m ON m.equipe1_id = e.id OR m.equipe2_id = e.id
GROUP BY e.id
ORDER BY points DESC, goal_difference DESC, wins DESC;
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Manager | Classement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/classement.css">
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
                    <a class="nav-link active" href="classement.php">
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
            <h3 class="text-center mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Accueil</a></li>
                <li class="nav-item"><a href="ajouter.php" class="nav-link"><i class="fas fa-plus-circle"></i> Ajouter une équipe</a></li>
                <li class="nav-item"><a href="modifier.php" class="nav-link"><i class="fas fa-edit"></i> Modifier une équipe</a></li>
                <li class="nav-item"><a href="simulate_match.php" class="nav-link"><i class="fas fa-futbol"></i> Simuler un match</a></li>
                <li class="nav-item"><a href="classement.php" class="nav-link active"><i class="fas fa-list-ol"></i> Classement</a></li>
                <li class="nav-item"><a href="historique.php" class="nav-link"><i class="fas fa-history"></i> Historique des matches</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4">
            <div class="text-center">
                <h1 class="mb-4">Classement des équipes</h1>
            </div>

            <table class="table table-striped text-center">
    <thead>
        <tr>
            <th>Classement</th>
            <th>Nom de l'équipe</th>
            <th>Matches</th>
            <th>Points</th>
            <th>W</th>
            <th>L</th>
            <th>D</th>
            <th>+/-</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        foreach ($result as $row) {
            $points = ($row['wins'] * 3) + ($row['draws'] * 1);

            echo "<tr>
                    <td>{$rank}</td>
                    <td><img src='{$row['logo']}' alt='{$row['nom']}' width='40' height='40' class='team-logo'> {$row['nom']}</td>
                    <td>{$row['games_played']}</td>
                    <td>{$points}</td>
                    <td>{$row['wins']}</td>
                    <td>{$row['losses']}</td>
                    <td>{$row['draws']}</td>
                    <td>{$row['goal_difference']}</td>
                </tr>";
            $rank++;
        }
        ?>
    </tbody>
</table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
