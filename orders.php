<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/8eba15a111.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
<?php 

require_once 'auth.php';

if (!Auth::checkauth()) {
   die('Authorization required
   </div>
   </body>
   </html>');
}

require_once 'crud.php';

$orders = CRUD::read();



echo '<table class="table">';

echo "<thead><tr>"
. "<th>ID</th>"
. "<th>product</th>"
. "<th>price</th>"
. "<th>amount</th>"
. "<th>total_price</th>"
. "<th>status</th>"
. "</tr></thead>";

foreach ($orders as $elem) {
    #print_r($elem);
    echo "<tr>"
    . "<td>{$elem['id']}</td>"
    . "<td>{$elem['product']}</td>"
    . "<td>{$elem['price']}</td>"
    . "<td>{$elem['amount']}</td>"
    . "<td>{$elem['total_price']}</td>"
    . "<td>{$elem['status']}</td>"
    . "<td><a href='crud.php?delete=1&id={$elem['id']}'><i class='fa-solid fa-trash'></i></a><td>"
    . "</tr>";
    

}
echo '</table>';
?>
<hr class="hr" />



<form action="crud.php" method="POST">
<select name="action">
 <option>update</option>
 <option>create</option>
</select> 
 <p>ID: <input type="text" name="id" /></p>
 <p>Product: <input type="text" name="product" /></p>
 <p>Price: <input type="text" name="price" /></p>
 <p>Amount: <input type="text" name="amount" /></p>
 Status:
 <select name="status">
 <option>ordered</option>
 <option>delivered</option>
 <option>paid</option>
 <option>canceled</option>
</select> 
 <p><input type="submit" /></p>
</form>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalUserInfo">
  Данные
</button>

<div class="modal fade" id="ModalUserInfo" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<?php 
if (!Auth::checkauth()) {
    die('Authorization required');
 } else {
    require 'config.php';
    $sql = "SELECT * FROM `users` WHERE `login` = ?";
    $sth = $pdo->prepare($sql);
    $sth->bindParam(1,$_COOKIE['Login'],PDO::PARAM_STR);
    $sth->execute();
    $sql_resp = ($sth->fetch(PDO::FETCH_ASSOC));

    echo "You are {$sql_resp['login']}. Your email is {$sql_resp['email']}. Your account was created at {$sql_resp['created_at']}. Your password is hashed. Password's hash: {$sql_resp['password']}"; 
 }

?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</div>
</body>
</html>