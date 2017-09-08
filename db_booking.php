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
$message = '';

if (isset($passengerName) && isset($phoneNumber) && isset($streetNumber) && isset($streetName) && isset($suburb) && isset($destinationSuburb) && isset($pickupDate) && isset($pickupTime) && !empty($passengerName) && !empty($phoneNumber) && !empty($streetNumber) && !empty($streetName) && !empty($suburb) && !empty($pickupDate) && !empty($pickupTime)) {
    //TODO check if empty -> tra ve string error, cac truong deu phai nhap tru destinationSuburb
    // check date, check hour
    if (checkDateTime($pickupDate)) {
        date_default_timezone_set('Australia/Melbourne');
        $currenttime = date("Y-m-d h:m:s");
        $diff = (strtotime($pickupDate . ' ' . $pickupTime) - strtotime($currentTime)) / (60 * 60);
//        echo 'here';
        if ($diff > 1) {
//            $DBConnect = @mysqli_connect("localhost", "root", "root", "wad_assignment1")
            $DBConnect = @mysqli_connect("feenix-mariadb.swin.edu.au", "s100861469", "090891", "s100861469_db")
                    Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";
            $amDate = $pickupDate . ' ' . $pickupTime;
            $stmt = $DBConnect->prepare('INSERT INTO Booking(email, passengerName, phoneNumber, unitNumber, streetNumber, streetName, suburb, destinationSuburb, pickupDate) values(?,?,?,?,?,?,?,?,?)');
            $stmt->bind_param("sssssssss", $email, $passengerName, $phoneNumber, $unitNumber, $streetNumber, $streetName, $suburb, $destinationSuburb, $amDate);
            $stmt->execute();


            // get last booking number
            $SQLstring = 'select * from Booking ORDER BY bookingNumber DESC LIMIT 1 ';
            $queryResult = mysqli_query($DBConnect, $SQLstring)
                    Or die("<p>Unable to query the booking table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
            $row = mysqli_fetch_array($queryResult);
            $stmt->close();
            mysqli_close($DBConnect);

            $pick = strtotime($row['pickupDate']); // get pickupdate from row in db to seperate to pickupDate and pickupTime
//            echo $pickupTime;
            header("Location: booking_success.php?bookingNumber=" . $row['bookingNumber'] . '&pickupTime=' . urlencode(date('H:i', $pick)) . '&pickupDate=' . urlencode(date('Y-m-d', $pick)) . '&email=' . urlencode($email) . '&message=' . $message);
            exit();
        } else {
            $message = "time";
            header("Location: booking.php?email='" . urlencode($email) . "&message=' . $message");
            exit();
        }
    } else {
        $message = "dateFormat";
        header("Location: booking.php?email='" . urlencode($email) . "&message=' . $message");
        exit();
    }
} else {
    $message = 'input';
    header("Location: booking.php?email='" . urlencode($email) . "&message=' . $message");
    exit();
}

function checkDateTime($date) {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
        return true;
    } else {
        return false;
    }
}

?>