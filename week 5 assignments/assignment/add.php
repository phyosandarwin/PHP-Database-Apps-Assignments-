<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name'])){
    die("ACCESS DENIED");
}

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
    // if there are any fields empty
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    // when mileage or year field is not numeric
    if (!is_numeric($_POST['mileage'])){
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['year'])){
        $_SESSION['error'] = "Year must be numeric";
        header("Location: add.php");
        return;
    }
    
    // all fields validated, can insert record into database
    else{
        $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) 
                                  VALUES (:mk, :md, :yr, :mi)');
        $stmt->execute(array(
                ':mk'   => $_POST['make'],
                ':md'   => $_POST['model'],
                ':yr'   => $_POST['year'],
                ':mi'   => $_POST['mileage'],
        ));
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
    }
}

?>

<html>
<head><title>Phyo's Automobile Tracker Add Page</title>
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
        <p>Model:
        <input type="text" name="model" size="60"/></p>
        <p>Year:
        <input type="text" name="year"/></p>
        <p>Mileage:
        <input type="text" name="mileage"/></p>
        <p>
        <input type="submit" value="Add">
        <a href = "index.php">Cancel</a>
        </p>
        </form>
    </div>
    </body>
</html>