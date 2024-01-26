<?php // line added to turn on color syntax highlight
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
  die('Not logged in');
}
if ( isset($_SESSION['cancel'])){ //if cancel button pressed, return to view records
    header("Location: view.php");
    return;
}
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
    // when mileage or year field is not numeric
    if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: add.php");
        return;
    }
    // when make is empty
    else if (strlen($_POST['make']) < 1){
        $_SESSION['error'] = "Make is required";
        header("Location: add.php");
        return;
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
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
    }
}
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
        // print any error message
        if (isset($_SESSION['error'])){
            echo('<p style="color: red">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
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
        <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
    </body>
</html>