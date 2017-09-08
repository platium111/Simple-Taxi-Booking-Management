<?php
$email = '';
if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
}
?>
<!DOCTYPE html>
<!--TODOTODAY- 
-hien thi error o booking | https://stackoverflow.com/questions/827368/using-the-get-parameter-of-a-url-in-javascript
-dua ve 1 page, 
-check them assignment document
-check error dateTime
    -->
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    </head>

    <script type="text/javascript">
        var displaySuccess = '<?php echo urldecode($message); ?>';
//        alert(displaySuccess);
        var divSuccess = document.getElementById("successMessage");
        if (displaySuccess !== '') {
            divSuccess.style.display = 'block';
        } else {
            divSuccess.style.display = 'none';
        }
    </script>F
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1> Booking a cab</h1>
                    <p>Please fill the fields below to book a taxi</p>
                    <?php echo '<form action="db_booking.php?email=' . urlencode($email) . '" method="post">' ?>
                    <div class="form-group row">
                        <label for="idEmail" class="col-sm-3 col-form-label">Passenger name:</label>
                        <div class="col-sm-9">
                            <input name="passengerName" type="text" class="form-control" id="idEmail" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="idPassword" class="col-sm-3 col-form-label">Contact phone of the passenger:</label>
                        <div class="col-sm-9">
                            <input name="phoneNumber" type="text" class="form-control" id="idPassword" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="idPassword" class="col-sm-3 col-form-label">Pick up address:</label>
                        <div class="col-sm-9">
                            <div class="form-group row">
                                <label for="idPassword" class="col-sm-4 col-form-label">Unit number:</label>
                                <div class="col-sm-8">
                                    <input name="unitNumber" type="text" class="form-control" id="idPassword" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idPassword" class="col-sm-4 col-form-label">Street number:</label>
                                <div class="col-sm-8">
                                    <input name="streetNumber" type="text" class="form-control" id="idPassword" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idPassword" class="col-sm-4 col-form-label">Street name:</label>
                                <div class="col-sm-8">
                                    <input name="streetName" type="text" class="form-control" id="idPassword" placeholder="" required>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="idPassword" class="col-sm-4 col-form-label">Suburb:</label>
                                <div class="col-sm-8">
                                    <input name="suburb" type="text" class="form-control" id="idPassword" placeholder="" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="idPassword" class="col-sm-3 col-form-label">Destination suburb:</label>
                        <div class="col-sm-9">
                            <input name="destinationSuburb" type="text" class="form-control" id="idPassword" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="idPassword" class="col-sm-3 col-form-label">Pickup date:</label>
                        <div class="col-sm-9">
                            <input name="pickupDate" type="text" class="form-control" id="idPassword" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="idPassword" class="col-sm-3 col-form-label">Pickup time:</label>
                        <div class="col-sm-9">
                            <input name="pickupTime" type="text" class="form-control" id="idPassword" placeholder="" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Book</button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php
                    if ($message != '') {
                        echo '<div class="alert alert-danger" id="successMessage" role="alert">';
                        if ($message === 'dateFormat') {
                            echo 'Pickup date has wrong format';
                        } else if ($message === 'time') {
                            echo 'Booking time needs to be more than 1 hour from now';
                        } else if ($message === 'input') {
                            echo 'You need to input properly';
                        }

                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </body>
    <?php
    $message = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }
    ?>

</html>