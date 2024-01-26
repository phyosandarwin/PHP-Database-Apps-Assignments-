<!-- view.php shows the correctly inserted entries -->

<?php // line added to turn on color syntax highlight
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
  die('Not logged in');
}
/* only if using the form buttons then uncomment this
if ( isset($_POST['add'])){
    header('Location: add.php');
    return;
}
if ( isset($_POST['logout']) ){
    header('Location: logout.php');
    return;
}
*/

$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
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
        <h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>

        <?php
        //print the success message when record is added
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
        ?>
        <h2>Automobiles</h2>
        <!--
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
        -->
        <ul>
            <?php
                
                foreach($rows as $row){
                    echo "<li> ";
                    echo $row['year']." ";
                    echo htmlentities($row['make'])." / ";
                    echo $row['mileage'];
                    echo "</li>";
                }
            ?>
        </ul>
        <br/><br/>
        <!--
        <form method= "post">
            <input type = "submit" name = "add" value = "Add" />
            <input type="submit" name="logout" value="Log Out"/>
        </form>
        -->
        
        <p>
            <a href="autos.php">Add New</a>
            |
            <a href="logout.php">Logout</a>

        </p>
    </div>
    </body>
</html>