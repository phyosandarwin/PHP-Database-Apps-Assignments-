<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Phyo's Automobile Tracker</title>

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>

<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<?php
// not logged in yet
if (!isset($_SESSION['name'])) {
    echo("<p><a href='login.php'>Please log in</a></p>");
    echo("<p>Attempt to <a href='add.php'>add data</a> without logging in</p>");
}
// logged in 
else {
    // display successful record insertion msg
    if (isset($_SESSION['success'])){
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
    else if (isset($_SESSION['error'])){
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    //EXTRACT RECORDS
    $sql = "SELECT * FROM autos";
    $stmt = $pdo->query($sql);
    // check if there are any records
    if ($stmt->rowCount() == 0){
        echo("No rows found");
    }
    else{
        // if there are records, display them in a table with headers
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo" <thead><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr></thead>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo htmlentities($row['make']);
            echo "</td><td>";
            echo htmlentities($row['model']);
            echo "</td><td>";
            echo $row['year'];
            echo "</td><td>";
            echo $row['mileage'];
            echo "</td><td>";
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }
        echo "</table>";
    }
    echo "<br/>";
    echo "<p><a href = 'add.php'>Add New Entry</a></p>\n";
    echo "<p><a href = 'logout.php'>Logout</a></p>\n";
    echo "<p>
    <b>Note:</b> Your implementation should retain data across multiple 
    logout/login sessions.  This sample implementation clears all its
    data on logout - which you should not do in your implementation.
    </p>";     
}
?>


</div>

</body>
</html>

