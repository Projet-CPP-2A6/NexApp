<?php

// Function to generate a unique ID
function create_unique_id() {
    return uniqid('user_', true);
}

require __DIR__ . '/../../config.php';

$conn = Config::getConnexion();

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = create_unique_id();

    // Using the create_unique_id() function to generate a unique ID
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../General/style.css">

</head>
<body>

<?php include '../Product/frontheader.php'; ?>

<section class="orders">
    <h1 class="heading">My Orders</h1>
    <button id="btPrint" onclick="createPDF()" class="export-pdf-btn">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search ..." class="form-control"
                id="search-input">
        </div>
    <div class="container">
    <table class="table table-striped table-dark" id="table">
  <thead>
                <tr> 
                <th>Price</th>
                    <th onclick="sortTable(0)">Product Name</th>
                   
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);
                if($select_orders->rowCount() > 0){
                    while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_product->execute([$fetch_order['product_id']]);
                        if($select_product->rowCount() > 0){
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr <?php if($fetch_order['status'] == 'canceled'){echo 'style="border:.2rem solid red";';}; ?>>
                <td><?= $fetch_order['price']; ?></td>
                    <td><?= $fetch_product['name']; ?></td>
                    <td><?= $fetch_order['qty']; ?></td>
                    <td style="color:<?php if($fetch_order['status'] == 'delivered'){echo 'green';}elseif($fetch_order['status'] == 'canceled'){echo 'red';}else{echo 'orange';}; ?>">
                        <?= $fetch_order['status']; ?>
                    </td>
                    <td>
                        <a href="delete_order.php?order_id=<?= $fetch_order['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php
                            }
                        }
                    }
                } else {
                    echo '<tr><td colspan="6">No orders found!</td></tr>';
                }
            ?>

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
        win.document.write('<title>Order list PDF</title>');   
        win.document.write(style);         
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         
        win.document.write('</body></html>');
        win.document.close(); 	
        win.print();    
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
