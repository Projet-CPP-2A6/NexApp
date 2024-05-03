<?php
 require __DIR__ . '/../../config.php';

 $conn = Config::getConnexion();
function create_unique_id(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
 }
 
 if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
 }
// Fetch types from the database
$types_query = $conn->query("SELECT * FROM `types`");
$types = $types_query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Types</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Additional stylesheets if needed -->
</head>
<body>

<?php include 'header.php'; ?>

<section class="types">

    <h1 class="heading">Product Types</h1>
    <a href="addType.php" class="btn btn-primary">Add Type</a>
    <div class="container">
    <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>
    <link rel="stylesheet" href="../General/Accueil/accueil.css">
    <link rel="stylesheet" href="../General/Actions/actions.css">
    <link rel="stylesheet" href="../General/Boutique/Boutique.css">
   <link rel="stylesheet" href="css/style.css">

   <link rel="stylesheet" href="css/style.css">
   <button id="btPrint" onclick="createPDF()" class="export-pdf-btn">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search ..." class="form-control"
                id="search-input">
        </div>
        <table class="table table-striped table-dark" id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th onclick="sortTable(0)">Name</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?= $type['id']; ?></td>
                        <td><?= $type['name']; ?></td>
                        <td>
                  <a href="editType.php?id=<?= $type['id']; ?>" class="btn btn-primary">Edit</a>
                  <a href="Controller/deleteTypeController.php?id=<?= $type['id']; ?>" class="btn btn-danger">Delete</a>
               </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../General/scriptIndex.js"></script>
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
        win.document.write('<title>Order list PDF</title>');   // <title> FOR PDF HEADER.
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
            td = tr[i].getElementsByTagName("td")[1];
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

<?php include '../User/components/alert.php'; ?>

</body>
</html>
