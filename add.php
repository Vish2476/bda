<?php

session_start();

require_once "pdo.php";
// Demand a Session name parameter
if ( ! isset($_SESSION['name']) ){
    die('ACCESS DENIED');
}


// If the user requested cancel go back to view.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$failure = false;
$insertMessage = false;
$show = false;

if(isset($_POST['add'])){
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ){
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }
    elseif (!is_numeric($_POST['year']) ) {
        $_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return;
    }
    elseif (!is_numeric($_POST['mileage']) ) {
        $_SESSION['error'] = "Mileage must be an integer";
        header("Location: add.php");
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':md' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );
        $_SESSION['success'] = "Record Added";
        header("Location: index.php");
        return;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Carlo Nicolò Automobile Database CRUD - Add page</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for
<?php
if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name']);
    echo "</h1>\n";
}
?>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}


?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"></p>
<p>Model:
<input type="text" name="model" size="60"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<input type="submit" name="add" value="Add"/>
<input type="submit" name="logout" value="Cancel"/>
</form>

</div>
</body>
</html>