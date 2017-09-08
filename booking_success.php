<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <style> 
            body {
                height: 100%;
            }

            .container {
                height: 100%;
                justify-content: center;
                align-items: center;
            }
            #message {
                margin: 200px;
                border: 5px solid #40943C;
            }
            .emailMessage {
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php
            $bookingNumber = $pickupTime = $pickupDate = $email = '';
            if (isset($_GET['bookingNumber']) && !empty($_GET['bookingNumber']) && isset($_GET['pickupTime']) && !empty($_GET['pickupTime']) && isset($_GET['pickupDate']) && !empty($_GET['pickupDate'])) {
                $bookingNumber = $_GET['bookingNumber'];
                $pickupTime = $_GET['pickupTime'];
                $pickupDate = $_GET['pickupDate'];
                $email = urldecode($_GET['email']);
            }
            // sending email
            $to = $email;
            $subject = 'Your booking request with CabsOnline!';
            $header = 'From booking@cabsonline.com.au';
            $message = "Thank you! Your booking reference number is $bookingNumber. 
                        We will pick up the passengers in front of your provided address at $pickupTime
                            on $pickupDate.";
            echo "<div class='row emailMessage'>";
            echo "<div class='col alert alert-success' role='alert'>";
            if (mail($email, $subject, $message, $header)) {
                echo("<p class='text-center'>Email successfully sent!</p>");
            } else {
                echo("<p class='text-center'>Email delivery failed…</p>");
            }
            echo "</div>";
            echo "<div class='row'>";
            ?>

            <div class="row" id='message'>
                <!--Hiep-exp: p-4 nghia la do rong margin-->
                <div class="text-center p-4 ">
                    <?php echo "Thank you! Your booking reference number is <span class='font-weight-bold'>$bookingNumber</span>. 
                        We will pick up the passengers in front of your provided address at <span class='font-weight-bold'>$pickupTime</span>
                            on <span class='font-weight-bold'>$pickupDate</span>."
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="alert alert-success" role="alert">
                        This is a success alert—check it out!
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>