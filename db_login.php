<?php

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$numOfRow = 0;
if (isset($email) && isset($password) && !empty($email) && !empty($password)) {
    //TODO check if empty -> tra ve string error, check confirm password
    // xu li trim cua email, password

//    $DBConnect = mysqli_connect("localhost", "root", "root", "wad_assignment1")
    $DBConnect = @mysqli_connect("feenix-mariadb.swin.edu.au", "s100861469", "090891", "s100861469_db")
            Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

    $SQLstring = 'select * from Customer where email="' . $email . '" and password="' . $password . '"';

    $queryResult = mysqli_query($DBConnect, $SQLstring)
            Or die("<p>Unable to query the customer table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
    $numOfRow = mysqli_num_rows($queryResult);
    $row = mysqli_fetch_array($queryResult);
    mysqli_close($DBConnect);

    if ($numOfRow != 0) {
        // going to admin with account and password
        if ($email == 'admin@abc.com' && $password == 'admin') {
            header("Location: admin.php");
            exit();
        }
        // go to booking because it is a customer
        else {
            header("Location: booking.php?email=" . urlencode($email));
            exit();
        }
    }
    // login again because no matching with customer database
    else {
        header("Location: login.php?message=notmatch");
        exit();
    }
}
// login again because empty account and password
else {
    header("Location: login.php?message=inputerror");
    exit();
}
?>