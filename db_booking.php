<?php

$passengerName = htmlspecialchars($_POST['passengerName']);
$phoneNumber = htmlspecialchars($_POST['phoneNumber']);
$unitNumber = htmlspecialchars($_POST['unitNumber']);
$streetNumber = htmlspecialchars($_POST['streetNumber']);
$streetName = htmlspecialchars($_POST['streetName']);
$suburb = htmlspecialchars($_POST['suburb']);
$destinationSuburb = htmlspecialchars($_POST['destinationSuburb']);
$pickupDate = htmlspecialchars($_POST['pickupDate']);
$pickupTime = htmlspecialchars($_POST['pickupTime']);

$email = urldecode($_GET['email']);

if (isset($passengerName) && isset($phoneNumber) && isset($unitNumber) && isset($streetNumber) && isset($streetName) && isset($suburb) && isset($destinationSuburb) && isset($pickupDate) && isset($pickupTime)) {
    //TODO check if empty -> tra ve string error, cac truong deu phai nhap tru destinationSuburb
    // check date, check hour

    $pickupDate = date('Y-m-d H:i', strtotime($pickupDate . $pickupTime));
    $DBConnect = @mysqli_connect("localhost", "root", "root", "wad_assignment1")
            Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

    $stmt = $DBConnect->prepare('INSERT INTO booking(email, passengerName, phoneNumber, unitNumber, streetNumber, streetName, suburb, destinationSuburb, pickupDate) values(?,?,?,?,?,?,?,?,?)');
    $stmt->bind_param("sssssssss", $email, $passengerName, $phoneNumber, $unitNumber, $streetNumber, $streetName, $suburb, $destinationSuburb, $pickupDate);    
    $stmt->execute();

    // get last booking number
    $SQLstring = 'select * from booking ORDER BY bookingNumber DESC LIMIT 1 ';
    $queryResult = mysqli_query($DBConnect, $SQLstring)
            Or die("<p>Unable to query the booking table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
    $row = mysqli_fetch_array($queryResult);
    $stmt->close();
    mysqli_close($DBConnect);
    
    $pick = strtotime($row['pickupDate']);// get pickupdate from row in db to seperate to pickupDate and pickupTime
    header("Location: booking_success.php?bookingNumber=".$row['bookingNumber'].'&pickupTime='. urlencode(date('Y-m-d', $pick)).'&pickupDate='. urlencode(date('H:i', $pick)). '&email='. urlencode($email));
    exit();
}

?>