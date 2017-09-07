
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
                    <h1> Login to CabsOnline </h1>

                    <form method="post">
                        <div class="form-group row">
                            <label for="idEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="idEmail" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idPassword" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-10">
                                <input name="password" type="password" class="form-control" id="idPassword" placeholder="" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br />
                    <p class="font-weight-bold"> New Member? <a href="./register.php" > Register Now </a>
                </div>
            </div>
        </div>

    </body>

    <?php
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $numOfRow = 0;
    if (isset($email) && isset($password) && !empty($email) && !empty($password)) {
        //TODO check if empty -> tra ve string error, check confirm password
        // xu li trim cua email, password
        
        $DBConnect = mysqli_connect("localhost", "root", "root", "wad_assignment1")
                Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

        $SQLstring = 'select * from customer where email="' . $email . '" and password="' . $password . '"';

        $queryResult = mysqli_query($DBConnect, $SQLstring)
                Or die("<p>Unable to query the customer table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";
        $numOfRow = mysqli_num_rows($queryResult);
        $row = mysqli_fetch_array($queryResult);
        mysqli_close($DBConnect);

        if ($numOfRow != 0) {
            // going to admin with account and password
            if ($email =='admin@abc.com' && $password=='admin') {
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
            header("Location: login.php");
            exit();
        }
    }
// login again because empty account and password
    else {
        header("Location: login.php");
        exit();
    }
    ?>

</html>

