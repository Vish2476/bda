<?php

session_start();

require_once "pdo.php";
$show = false;

if ( isset($_SESSION['name']) ) {
    // Model - Controller
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    #$show = true;
    
}

if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Carlo Nicolò Automobile Database CRUD</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>

<?php
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>

<?php
if(!isset($_SESSION['name'])){
    echo '<p><a href="login.php">Please log in</a></p>';
    echo '<p>Attempt to <a href="add.php">add data</a> without logging in.</p>';
    echo '<p><a href="https://www.wa4e.com/assn/autoscrud/" target="_blank">Specification for this Application</a></p>';
    }else{
        //print_r($rows);
        if(count($rows)){

            // print_r($rows);
            echo '<table border="1"."\n">
            <thead><tr>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Action</th>
            </tr></thead>';

            $stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                        
                // echo'<tr><td>'. htmlentities($row['make']) .'</td><td>'. htmlentities($row['model']) .'</td>
                // <td>'. htmlentities($row['year']) .'</td>
                // <td>'. htmlentities($row['mileage']) .'</td>
                // <td><a href="edit.php?autos_id="'. $row[autos_id] .'">Edit</a> / <a href="delete.php?autos_id="'.$row[autos_id].'">Delete</a></td></tr>';  
                
                echo "<tr><td>";
                echo(htmlentities($row['make']));
                echo("</td><td>");
                echo(htmlentities($row['model']));
                echo("</td><td>");
                echo(htmlentities($row['year']));
                echo("</td><td>");
                echo(htmlentities($row['mileage']));
                echo("</td><td>");
                echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                echo("</td></tr>\n");
                }
            } else {
                echo "No rows found </br>";
            }

            echo "</table>";

        
            echo '</br><p><a href="add.php">Add New Entry</a></p></br>';
            echo '<p><a href="logout.php">Logout</a></p>';
}

?>


</div>
</body>
</html>
