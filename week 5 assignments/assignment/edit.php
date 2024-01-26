<?php
require_once "pdo.php";
session_start();

if ( isset ($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if ( isset($_POST['save']) && isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || 
        strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    if ( !is_numeric($_POST['year']) ) {
        $_SESSION['error'] = 'Year must be numeric';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }
    if (!is_numeric($_POST['mileage'])){
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    $sql = "UPDATE autos SET make = :make, year = :year, mileage = :mileage, model = :model 
            WHERE autos_id = :autos_id";
            
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':model' => $_POST['model']
    , ':autos_id' => $_POST['autos_id']));
        
    $_SESSION['success'] = 'Record edited';
    header( 'Location: index.php' ) ;
    return;
    
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :id");
$stmt->execute(array(":id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$y = $row['year'];
$mileage = $row['mileage'];
$autosid = $row['autos_id'];
?>

<html>
    <head>
    <title>Phyo's Automobile Tracker Edit Page</title>
    </head>
    <body>
        <div class= "container">
        <h1>Editing Automobile</h1>
        <?php
            // Flash pattern - show the error messages while editing the records
            if ( isset($_SESSION['error']) ) {
                echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                unset($_SESSION['error']);
            }
        ?>
            <form method="post">
            <p>Make:
            <input type="text" name="make" value="<?= $make ?>" size="60"></p>
            <p>Model:
            <input type="text" name="model" value="<?= $model ?>" size = "60"></p>
            <p>Year:
            <input type="text" name="year" value="<?= $y ?>"></p>
            <p>Mileage:
            <input type="text" name="mileage" value="<?= $mileage ?>"></p>
            <input type="hidden" name="autos_id" value="<?= $autosid ?>">
            <br/>
            <p><input type="submit" value="Save" name="save"/>
            <input type="submit" value="Cancel" name="cancel"></p>
            </form>
        </div>
        
    </body>
</html>