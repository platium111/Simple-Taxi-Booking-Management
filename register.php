
<?php
$customerName = htmlspecialchars($_POST['customerName']);
$password = htmlspecialchars($_POST['password']);
$confirmPassword = htmlspecialchars($_POST['confirmPassword']);
$email = htmlspecialchars($_POST['email']);
$phoneNumber = htmlspecialchars($_POST['phoneNumber']);
$message = '';
$insertOk = 'not';


if (isset($customerName) && isset($password) && isset($confirmPassword) && isset($email) && isset($phoneNumber)
        && !empty($customerName) && !empty($password) && !empty($confirmPassword) && !empty($email) && !empty($phoneNumber) ) {
    //TODO check if empty -> tra ve string error, check confirm password
    //TODO check if run success -> redirect to login.php

    if ($password == $confirmPassword) {
        $DBConnect = mysqli_connect("localhost", "root", "root", "wad_assignment1")
                Or die("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

        $stmt = $DBConnect->prepare('INSERT INTO customer(customerName, email, password, phoneNumber) values(?,?,?,?)');
        $stmt->bind_param("ssss", $customerName, $email, $password, $phoneNumber);

        $sqlMatch = "select * from customer where email='" . $email . "'";
        $queryMatch = mysqli_query($DBConnect, $sqlMatch);
        if (!$stmt->execute() && mysqli_num_rows($queryMatch) == 0) {
            $message = "Error occured! Use the different email";
        } else {
            $message = '';
            $insertOk = 'ok';
        }

        $stmt->close();
        mysqli_close($DBConnect);
    } else {
        $message = 'Password is not match';
    }
}

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
                    <h1> Register to CabsOnline </h1>
                    <p> Please fill the fields below to complete your registration </p>
                    <form action="register.php" method="post">
                        <div class="form-group row">
                            <label for="idName" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                <input name="customerName" type="text" class="form-control" id="idName"
                                       value="<?php echo isset($_POST['customerName']) ? $_POST['customerName'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idPassword" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-10">
                                <input name="password" type="text" class="form-control" id="idPassword" 
                                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idConfirmPassword" class="col-sm-2 col-form-label">Confirm password:</label>
                            <div class="col-sm-10">
                                <input name="confirmPassword" type="text" class="form-control" id="idConfirmPassword" 
                                       value="<?php echo isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="idEmail" 
                                       value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idPhone" class="col-sm-2 col-form-label">Phone:</label>
                            <div class="col-sm-10">
                                <input name="phoneNumber" type="text" class="form-control" id="idPhone" 
                                       value="<?php echo isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '' ?>" placeholder="" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>

                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <?php
                    if ($message != '') {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo $message;
                        echo '</div>';
                    } if ($insertOk === 'ok') {
                        echo '<div class="alert alert-success" role="alert">';
                        echo 'Register successful';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br />
                    <p class="font-weight-bold"> Already registered? <a href="./login.php" > Login here </a>
                </div>
            </div>
        </div>

    </body>

</html>