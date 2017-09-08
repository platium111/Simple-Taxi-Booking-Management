<?php
$message = "";
if(isset($_GET['message'])) {
    $message = $_GET['message'];
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <!--HIEPEXP: neu chuyen sang nhieu loai trang can viet tach php ra-->
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

                    <form action="db_login.php" method="post">
                        <div class="form-group row">
                            <label for="idEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="idEmail" 
                                       placeholder="" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idPassword" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-10">
                                <input name="password" type="password" class="form-control" id="idPassword" placeholder="" required
                                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php
                    if ($message != '') {
                        echo '<div class="alert alert-danger" id="successMessage" role="alert">';
                        if($message == 'notmatch') {
                            echo 'Login fail because of wrong username or password';
                        } else {
                            echo 'You need to have valid username and password';
                        }
                        echo '</div>';
                    }
                    ?>
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
    
</html>

