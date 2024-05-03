<?php
 require __DIR__ . '/../../config.php';
 $conn = Config::getConnexion();
// Si la requête est de type POST, c'est-à-dire si le formulaire de suppression est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_organization'])) {
    $organizationIdToDelete = $_POST['delete_organization'];

    // Utiliser une requête préparée pour éviter les injections SQL
    $stmtDeleteOrganization = $conn->prepare("DELETE FROM organisations WHERE ID_Organisation = :orgId");
    $stmtDeleteOrganization->bindParam(':orgId', $organizationIdToDelete, PDO::PARAM_INT);

    // Exécuter la requête de suppression
    if ($stmtDeleteOrganization->execute()) {
        // Rediriger vers la même page après la suppression
        header("Location: associations.php");
        exit();
    } else {
        // Gérer l'échec de la suppression, par exemple, afficher un message d'erreur
        echo "Failed to delete organization.";
    }
}

// Récupérer le terme de recherche s'il est présent dans l'URL
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Préparer la requête SQL
$sql = "SELECT * FROM organisations";

// Ajouter une clause WHERE à la requête SQL si un terme de recherche est fourni
if (!empty($searchTerm)) {
    $sql .= " WHERE Nom_Org LIKE :searchTerm";
}

$stmtOrganisations = $conn->prepare($sql);

// Binder le paramètre de recherche s'il est présent
if (!empty($searchTerm)) {
    $searchTerm = "%$searchTerm%";
    $stmtOrganisations->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
}

$stmtOrganisations->execute();
$rowsOrganisations = $stmtOrganisations->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associations List</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- You can keep your custom styles in a separate file -->
    <!-- Add Font Awesome CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="Consulter_profil.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="companies.php">
                            Sociétés
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
<div class="container">
<h1 class="mt-4">Associations</h1>
    <!-- Ajout du formulaire de recherche -->
    <form method="GET" class="form-inline mb-4">
    <div class="form-group">
        <label for="searchInput" class="sr-only">Search</label>
        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by Name" value="<?= htmlentities($searchTerm) ?>">
    </div>
    <button type="submit" class="btn btn-primary ml-2">Search</button>
</form>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Description</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rowsOrganisations as $row) : ?>
                <tr>
                    <td><img src="<?= $row['Image_Path'] ?>" alt="<?= $row['Image_Path'] ?>" class="img-thumbnail custom-logo"></td>
                    <td><?= $row['Nom_Org'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_organization" value="<?= $row['ID_Organisation'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<style>
    .custom-logo {
    max-width: 50px; /* Vous pouvez ajuster la valeur selon vos besoins */
}
</style>

<!-- Add Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    
#sidebar {
            position: fixed;
            top: 200px;
            left: 0;
            height: 100%;
            width: 260px;
            z-index: 1;
            background-color: #f8f9fa; /* Bootstrap default background color */
            padding-top: 20px;
            padding-right: 10px;
            overflow-x: hidden;
        }

        #sidebar a {
            text-decoration: none;
            color: #495057; /* Bootstrap default text color */
        }

        #sidebar .nav-link {
            padding: 8px 15px;
            font-size: 16px;
        }

        #sidebar .nav-link:hover {
            background-color: #007bff; /* Bootstrap primary color */
            color: #fff;
        }

        #sidebar .active {
            background-color: #007bff;
            color: #fff;
        }

        /* Content Styles */
        .container {
            margin-top: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #sidebar {
                position: relative;
                width: 100%;
                margin-bottom: 20px;
                height: auto;
                padding: 10px;
            }

            #sidebar a {
                text-align: center;
            }
        }
        .logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 180px;
    height: 180px;
    background-color: #D7B20B;
    border-radius: 50%;
    border :1px solid #000000;
    position: fixed;
    top: 20px;
    left: 20px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    z-index: 3;
}
table {
        table-layout: fixed;
        width: 100%;
    }
    th, td {
        word-wrap: break-word;
        max-width: 150px; /* Adjust the maximum width as needed */
    }

    .container {
        margin-top: 20px;
        overflow-x: auto; /* Enable horizontal scrolling if needed */
    }

.logo img {
    width: 150px;
    height: 70px;
}
    </style>
</body>
</html>