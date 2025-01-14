<?php
include 'includes/db.php';

function getTeamById($conn, $id) {
    $query = "SELECT * FROM equipes WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team1_id = $_POST['team1'];
    $team2_id = $_POST['team2'];

    $team1 = getTeamById($conn, $team1_id);
    $team2 = getTeamById($conn, $team2_id);

    $team1_score = rand(0, 5);
    $team2_score = rand(0, 5);

    $sql = "INSERT INTO matches (equipe1_id, equipe2_id, score_equipe1, score_equipe2, date_match) 
            VALUES (:team1_id, :team2_id, :team1_score, :team2_score, CURDATE())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':team1_id' => $team1_id,
        ':team2_id' => $team2_id,
        ':team1_score' => $team1_score,
        ':team2_score' => $team2_score
    ]);

    $update_sql = "UPDATE equipes SET score_total = score_total + :team1_score WHERE id = :team1_id";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->execute([
        ':team1_score' => $team1_score,
        ':team1_id' => $team1_id
    ]);

    $update_sql = "UPDATE equipes SET score_total = score_total + :team2_score WHERE id = :team2_id";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->execute([
        ':team2_score' => $team2_score,
        ':team2_id' => $team2_id
    ]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Manager | Résultat du Match</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/match.css">
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
                    <a href="index.html" class="nav-link">
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

        <div class="container">
    <div class="match">
        <div class="match-header">
            <div class="match-tournament">
                <i class="fas fa-futbol"></i><span class="result">Résultat du match</span>
            </div>
        </div><hr>
        <div class="match-content">
            <div class="column">
                <div class="team team--home">
                    <div class="team-logo">
                        <img src="<?= htmlspecialchars($team1['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="Team 1 Logo" />
                    </div>
                    <h2 class="team-name"><?= htmlspecialchars($team1['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                </div>
            </div>
            <div class="column">
                <div class="match-details">
                    <div class="match-score">
                        <span class="match-score-number match-score-number--leading"><?= $team1_score ?></span>
                        <span class="match-score-divider">:</span>
                        <span class="match-score-number"><?= $team2_score ?></span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="team team--away">
                    <div class="team-logo">
                        <img src="<?= htmlspecialchars($team2['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="Team 2 Logo" />
                    </div>
                    <h2 class="team-name"><?= htmlspecialchars($team2['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                </div>
            </div>
        </div>

        <div class="match-footer">
            <a href="simulate_match.php" class="btn btn-primary btn-lg w-100">Simuler un autre match</a>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Le match a été simulé avec succès !',
            showConfirmButton: false,
            timer: 1500
        });
    </script>

</body>
</html>
