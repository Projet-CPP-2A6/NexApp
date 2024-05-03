<?php
 require __DIR__ . '/../../config.php';
 $conn = Config::getConnexion();

// Function to get the count of organizations and companies
function getStatistics($conn) {
    $stats = array();

    $stmtOrganisations = $conn->prepare("SELECT COUNT(*) as orgCount FROM organisations");
    $stmtOrganisations->execute();
    $rowOrganisations = $stmtOrganisations->fetch(PDO::FETCH_ASSOC);
    $stats['orgCount'] = $rowOrganisations['orgCount'];

    $stmtSociete = $conn->prepare("SELECT COUNT(*) as socCount FROM société");
    $stmtSociete->execute();
    $rowSociete = $stmtSociete->fetch(PDO::FETCH_ASSOC);
    $stats['socCount'] = $rowSociete['socCount'];

    return $stats;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (your deletion code remains unchanged)
}

$statistics = getStatistics($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- You can keep your custom styles in a separate file -->
    <style>
        /* Custom Styles for Statistics Section */
        .statistics-section {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>

<div class="container">
    <h1 class="mt-4">Bonjour Mr.Chaouachi</h1>
    <div class="jumbotron">
        <h1 class="display-4">Dashboard</h1>
        <p class="lead">Voici les statistiques des organismes inscrites, vous pouvez les consulter</p>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Nombre d'organisations</h5>
                        <p class="card-text"><?= $statistics['orgCount'] ?></p>
                        <a href="associations.php" class="btn btn-light">Voir la liste des organisations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de société</h5>
                        <p class="card-text"><?= $statistics['socCount'] ?></p>
                        <a href="companies.php" class="btn btn-light">Voir la liste des sociétés</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 180px;
    height: 180px;
    background-color: #D7B20B;
    border-radius: 60%;
    border :1px solid #000000;
    position: fixed;
    top: 20px;
    left: 20px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    z-index: 3;
}

.logo img {
    width: 150px;
    height: 70px;
}
</style>
<!-- Add Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>