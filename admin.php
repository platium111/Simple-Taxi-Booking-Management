<?php
$refNumber = '';
$match = true;
if (isset($_POST['referenceNumber'])) {
    $refNumber = $_POST['referenceNumber'];

    if (!empty($refNumber)) {
//            $refNumber = mysql_real_escape_string(htmlspecialchars($refNumber));
        $DBConnect = mysqli_connect("localhost", "root", "root", "wad_assignment1")
                Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";
        $SQLstring = 'UPDATE Booking SET status="assigned" WHERE bookingNumber="' . $refNumber . '"';
        $sqlMatch = "select * from booking where bookingNumber='" . $refNumber . "'";
        $queryResult = mysqli_query($DBConnect, $SQLstring)
                Or die("<p>Unable to query the customer table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
        $queryMatch = mysqli_query($DBConnect, $sqlMatch);

        if (mysqli_num_rows($queryMatch) > 0) {
            $match = true;
        } else {
            $match = false;
        }
    }
}

$DBConnect = mysqli_connect("localhost", "root", "root", "wad_assignment1")
        Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

$currenttime = date("Y-m-d h:m:s");

$SQLstring = 'select * from customer c INNER JOIN booking b where c.email = b.email AND b.status="unassigned"';

$queryResult = mysqli_query($DBConnect, $SQLstring)
        Or die("<p>Unable to query the customer table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
mysqli_close($DBConnect);
//referenceNumber
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1> Admin page of CabsOnline </h1>
                    <p class="font-weight-bold"> 1. Click below button to search for all unassigned booking requests with a pick-up time within 2 hours. </p>
                    <a href="admin.php" class="btn btn-info" role="button">List All</a>
                    <table class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Reference #</th>
                                <th>Customer name</th>
                                <th>Passenger name</th>
                                <th>Passenger contact phone</th>
                                <th>Pick-up address</th>
                                <th>Destination suburb</th>
                                <th>Pick-time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($queryResult)) {
                                echo '<tr >';
                                // convert date string format 1 -> another
                                date_default_timezone_set('Australia/Melbourne');
                                $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $row['pickupDate']); // datetime format
                                $currentTime = date('Y-m-d H:i:s');
                                $diff = (strtotime($row['pickupDate']) - strtotime($currentTime)) / (60 * 60);
                                if ($diff > 0 && $diff <= 2) {
                                    // display data
                                    echo "<th>" . $row['bookingNumber'] . "</th>";
                                    echo "<td>" . $row['customerName'] . "</td>";
                                    echo "<td>" . $row['passengerName'] . "</td>";
                                    echo "<td>" . $row['phoneNumber'] . "</td>";
                                    echo "<td>" . $row['unitNumber'] . '/' . $row['streetNumber'] . ' ' . $row['streetName'] . ', ' . $row['suburb'] . "</td>";
                                    echo "<td>" . $row['destinationSuburb'] . "</td>";
                                    echo "<td>" . $myDateTime->format('Y M H:i') . "</td>";
                                    echo '</tr>';
                                } else {
                                    continue;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <br />
                    <p class="font-weight-bold">2.Input a reference number below and click "update" button to assign a taxi to that request </p>
                    <form action="admin.php" method="post">
                        <!--TODO lam chuc nang update, co the check isset(reference number)-->
                        <div class="form-group row">
                            <label for="idEmail" class="col-sm-3 col-form-label">Reference number:</label>
                            <div class="col-sm-9">
                                <div class="form-group row">
                                    <div class="col-sm-7">
                                        <input name="referenceNumber" type="text" class="form-control" id="idEmail" placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                    if ($match == false) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo 'Reference number is not matched';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </body>


</html>

