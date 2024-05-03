<?php
require __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../Controller/CategoriesController.php';
$categoriesController = new CategoriesController(Config::getConnexion());
$categories = $categoriesController->getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap');


    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8; /* Light gray background */
    }

    header {
        background-color: #f1c40f; /* Yellow background */
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    #dashboard {
        display: flex;
        background-color: #ffffff ; /* Dark blue background for the dashboard */
        color: #fff; /* White text color */
    }

    nav {
        width: 250px;
        background-color: #2980b9; /* Dark blue background for the navigation sidebar */
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    #content {
        flex: 1;
        padding: 20px;
        background-color:#f1c40f; /* Light blue background for the content area */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th  {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
        background-color: #3498db; /* Light blue background for table headers and cells */
        color: #fff; /* White text color */
    }
    td {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
       /* Light blue background for table headers and cells */
        color: #000000; /* White text color */
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
        color: #fff; /* White text color for links */
        text-decoration: underline; /* Underline for links */
        font-size: 18px; /* Larger font size for links */
    }
    .delete-button {
    background-color: #f1c40f; /* Yellow background for delete button */
    color: #fff;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
}

.delete-button:hover {
    background-color: #e74c3c; /* Darker red background on hover */
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



    <table>
        <thead>
            <tr>
                <th>Nom Categorie</th>
                <th>Montant</th>
                <th>Quantite</th>
                <th>Id_id</th>
                <th>Actions</th>
            </tr>
          
        </thead>
        <tbody>
        <?php 
        foreach ($categories as $category) : ?>
                    <tr>
                        
                        <td contenteditable="true"><?php echo $category['nom_categorie']; ?></td>
                        <td contenteditable="true"><?php echo $category['montant']; ?></td>
                        <td contenteditable="true"><?php echo $category['quantite']; ?></td>
                        <td contenteditable="true"><?php echo $category['id_id']; ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete?');">
                            <input type="hidden" name="delete_nom_categorie" value="<?php echo $category['nom_categorie']; ?>">
                            <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; 
                ?>
            <!-- Sample row, replace with PHP loop generating rows -->
            <!-- Repeat the above row structure for each category -->
        </tbody>
    </table>

    <script>
        function removeCategory(categoryId) {
            // Implement your logic to remove the category using AJAX or form submission
            alert(`Remove category ID ${categoryId}`);
        }
    </script>
</body>
</html>