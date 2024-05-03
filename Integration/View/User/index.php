<?php
 require __DIR__ . '/../../config.php';
 require_once "User.php";

 $conn = Config::getConnexion();

// Create a user object
$user = new User($conn);


// If not logged in, redirect to the login page
if (!$user->isLoggedIn()) {
    header("location: login.php");
}

// Get current user data
$currentUser = $user->getUser();

// Fetch all data from tblogin
$query = $conn->prepare("SELECT * FROM tblogin");
$query->execute();
$data = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="actions.css">
    <link rel="stylesheet" href="connexion.css">
    <style>
        /* Additional CSS styles for table customization */
        table {
            font-size: 18px;
            margin-top: 20px;
            width: 90%; /* Adjust the width as needed */
            max-width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            padding: 20px;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="container mt-5">
    <h3>Welcome <span style="color: red;"><?php echo $currentUser['name'] ?></span>, <a href="logout.php">Logout</a></h3>
        <h1>Liste des users</h1>
        <br>
        <hr /><br>
        <div>
        <button id="btPrint" onclick="createPDF()" class="export-pdf-btn">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
    </div>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search ..." class="form-control"
                id="search-input">
        <table class="table table-bordered" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>#ID</th>
                    <th onclick="sortTable(3)">NOM</th></th>
                    <th>Email</th>
                    <th>État</th> <!-- New column header -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <!-- Loop to display data -->
                <?php foreach ($data as $value): ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $value['id'] ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['email'] ?></td>
                        <td><?php echo $value['etat'] ?></td> <!-- Display the 'etat' column -->
                        <td>
                            <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Sure to delete data!');">Delete</a>
                            <?php if ($value['etat'] == 'Activé'): ?>
                                <a href="deactivate.php?id=<?php echo $value['id'] ?>" class="btn btn-secondary">Deactivate</a>
                            <?php elseif ($value['etat'] == 'Desactivé'): ?>
                                <a href="activate.php?id=<?php echo $value['id'] ?>" class="btn btn-secondary">Activate</a>
                            <?php endif; ?>
                            
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
      function createPDF() {
        var sTable = document.getElementById('table').outerHTML;
        var style = "<style>";
        style = style + "table {width: 100%; border-collapse: collapse; margin-top: 20px;}";
        style = style + "th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}";
        style = style + "th {background-color: #f2f2f2;}";
        style = style + "</style>";
    
        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');
        win.document.write('<html><head>');
        win.document.write('<title>product list PDF</title>');   // <title> FOR PDF HEADER.
        win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');
        win.document.close(); 	// CLOSE THE CURRENT WINDOW.
        win.print();    // PRINT THE CONTENTS.
    }
    </script>
    <script>
        function myFunction() {
          // Declare variables
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("table");
          tr = table.getElementsByTagName("tr");
        
          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
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

        function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("table");
          switching = true;
          dir = "asc";

          while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
              shouldSwitch = false;
              x = rows[i].getElementsByTagName("TD")[n];
              y = rows[i + 1].getElementsByTagName("TD")[n];

              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              }
            }

            if (shouldSwitch) {
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              switchcount++;
            } else {
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
              }
            }
          }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
