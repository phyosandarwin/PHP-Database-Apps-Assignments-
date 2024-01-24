<?php
require_once "pdo.php";

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

//messages for outcome of record insertion
$failure = false;
$success = false;

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
    // when mileage or year field is not numeric
    if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
        $failure = "Mileage and year must be numeric";
    }
    // when make is empty
    else if (strlen($_POST['make']) < 1){
        $failure = "Make is required";
    }
    // all fields validated, can insert record into database
    else{
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) 
                                  VALUES (:mk, :yr, :mi)');
        $stmt->execute(array(
                ':mk'   => $_POST['make'],
                ':yr'   => $_POST['year'],
                ':mi'   => $_POST['mileage'],
        ));
            $success = "Record inserted";
    }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html>
    <head><title>Phyo's Automobile Tracker 58b8e243</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    </head>
    <body>
    <div class="container">
        <?php
            if ( isset($_REQUEST['name']) ) {
                echo "<h1>Tracking Autos for ";
                echo htmlentities($_REQUEST['name']);
                echo "</h1>\n";
            }
        ?>
        <?php
            if ($failure !==false){
                echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
            }
            if ($success!==false){
                echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
            }
        ?>
        
        <form method="post">
        <p>Make:
        <input type="text" name="make" size="60"/></p>
        <p>Year:
        <input type="text" name="year"/></p>
        <p>Mileage:
        <input type="text" name="mileage"/></p>
        <input type="submit" value="Add">
        <input type="submit" name="logout" value="Logout">
        </form>

        <h2>Automobiles</h2>
        <table border="1" style="border-collapse: collapse; width: 80%;">
            <?php
            echo "<tr><th>Make</th><th>Year</th><th>Mileage</th></tr>";
            foreach ($rows as $row) {
                echo "<tr><td>";
                echo htmlentities($row['make']);
                echo "</td><td>";
                echo $row['year'];
                echo "</td><td>";
                echo $row['mileage'];
                echo "</td></tr>";
            }
            ?>
        </table>
    </body>
</html>

