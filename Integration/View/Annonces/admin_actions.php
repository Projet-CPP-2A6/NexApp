<?php
 require __DIR__ . '/../../config.php';
 require_once __DIR__ . '/../../Controller/AnnoncesAdminController.php';


$conn = Config::getConnexion();
$annoncesAdminController = new AnnoncesAdminController($conn);
$annoncesAdminController->handleCRUDOperations();

$stmt = $conn->prepare("SELECT annonces.*, COUNT(comments.id_comments) AS comment_count
                        FROM annonces
                        LEFT JOIN comments ON annonces.id_annonces = comments.id_annonces
                        GROUP BY annonces.id_annonces");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtComments = $conn->prepare("SELECT * FROM comments");
$stmtComments->execute();
$comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap');


    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
        /* Light gray background */
    }

    header {
        background-color: #f1c40f;
        /* Yellow background */
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    #dashboard {
        display: flex;
        background-color: #001f3f;
        /* Dark blue background for the dashboard */
        color: #fff;
        /* White text color */
    }

    nav {
        width: 250px;
        background-color: #2980b9;
        /* Dark blue background for the navigation sidebar */
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    #content {
        flex: 1;
        padding: 20px;
        background-color: #ecf0f1;
        /* Light blue background for the content area */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
        background-color: #3498db;
        /* Light blue background for table headers and cells */
        color: #fff;
        /* White text color */
    }

    td {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
        /* Light blue background for table headers and cells */
        color: #000000;
        /* White text color */
    }

    .delete-button {
        background-color: #f1c40f;
        /* Yellow background for delete button */
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
    }

    .delete-button:hover {
        background-color: #e74c3c;
        /* Darker red background on hover */
    }

    .edit-field {
        border: none;
        padding: 8px 12px;
        width: 80%;
        box-sizing: border-box;
    }

    #searchBar {
        margin-bottom: 20px;
        padding: 10px;
        width: 80%;
        font-size: 16px;
        border: 1px solid #3498db;
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* Additional Styles for Dashboard Links */
    #dashboard a {
        color: #fff;
        /* White text color for links */
        text-decoration: underline;
        /* Underline for links */
        font-size: 18px;
        /* Larger font size for links */
    }
    </style>


</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <div id="dashboard">
        <nav>
            <!-- Navigation links for different sections of the dashboard -->
            <ul>

                <li><a href="/Integration/View/Dons/don.php">Dashboard</a></li>
                <li><a href="/Integration/View/Organisation/Consulter_Profil.php">Dashboard Association</a></li>
                <li><a href="/Integration/View/Product/add_product.php">Add Product</a></li>
                <li><a href="/Integration/View/Organisation/associations.php">Associations</a></li>
                <li><a href="/Integration/View/Annonces/admin_actions.php">Annonces Actions</a></li>
                <li><a href="/Integration/View/Product/addType.php">Add Type Product</a></li>
                <li><a href="/Integration/View/Organisation/companies.php">Companies</a></li>
                <li><a href="/Integration/View/Product/editProduct.php">Edit Product</a></li>
                <li><a href="/Integration/View/Product/indexType.php">Edit ProductType</a></li>
                <li><a href="/Integration/View/Dons/ListCategories.php">Gestion Categories</a></li>
                <li><a href="/Integration/View/User/index.php">Users</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>

        <div id="content">
            <!-- Search Bar for Announcements -->
            <input type="text" id="searchBar" onkeyup="filterTable('dataTable')" placeholder="Search by Title">

            <!-- Search Bar for Comments -->
            <input type="text" id="searchCommentsBar" onkeyup="filterCommentsTable()"
                placeholder="Search by Announcement ID">

            <table id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Comments</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= $row['id_annonces'] ?></td>
                        <td><?= $row['titre'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><?= $row['comment_count'] ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id_annonces" value="<?= $row['id_annonces'] ?>">
                                <input type="hidden" name="delete" value="1">
                                <input type="submit" value="Delete" class="delete-button"
                                    onclick="return confirm('Are you sure?')">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table id="commentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Announcement ID</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment) : ?>
                    <tr>
                        <td><?= $comment['id_comments'] ?></td>
                        <td><?= $comment['id_annonces'] ?></td>
                        <td><?= $comment['desc_comment'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function filterTable(tableId) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(tableId === 'dataTable' ? 'searchBar' : 'searchCommentsBar');
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[tableId === 'dataTable' ? 1 : 2];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function filterCommentsTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchCommentsBar');
        filter = input.value.toUpperCase();
        table = document.getElementById('commentsTable');
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Assuming Announcement ID is in the second column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>
    <button id="scrollToTopBtn">↑</button>
    <script src="accueil.js"></script>
    <script src="action.js"></script>
    <script src="connexion.js"></script>

</body>

</html>