<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php

include('connection.php');

if (isset($_POST['submit'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `admin` WHERE email = '$email' and password = '$password'";
    $data = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($data) == 1) {
        while ($rows = mysqli_fetch_assoc($data)) {
            
            $_SESSION["email"] = $rows["email"];
            $_SESSION["login"] = $rows["id"];
            $_SESSION["user_type"] = $rows["type"];
            
            // Set the current login time and location_name
            $current_time = date('Y-m-d H:i:s'); // Get current date and time UTC
            $update_query = "UPDATE `admin` SET location_name = '$current_time' WHERE email = '$email'";
            mysqli_query($conn, $update_query); // Execute the update query

            // Check if session variables are set correctly
            if (empty($_SESSION["email"]) && empty($_SESSION["login"])) {
                ?>
                    <script>
                        alert('Sorry no such user......');
                    </script>
                <?php
            } else {
                ?>
                    <script>
                        window.open('index.php', '_self');
                    </script>
                <?php
            }
        }
    } else {
        $msg = "<p style='color:red;'>Invalid Email or Password</p>";       
    }
}

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login to PMS</title>

    <!-- Global stylesheets -->
    <link href="assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="assets/demo/demo_configurator.js"></script>
    <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="assets/js/app.js"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login card -->
                    <form class="login-form" action="" method="post">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                        <img src="../img/logo.png" class="h-48px" alt="">
                                    </div>
                                    <h5 class="mb-0">Login to your account</h5>
                                    <span class="d-block text-muted">Enter your credentials below</span>
                                </div>
                                 
                                <center>
                                    <?php
                                        if(isset($msg)){
                                         echo $msg;
                                        }
                                    ?>
                                </center>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input name="email" type="text" class="form-control"
                                            placeholder="email@gmail.com">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-user-circle text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input name="password" type="password" class="form-control"
                                            placeholder="•••••••••••">
                                        <div class="form-control-feedback-icon">
                                            <i class="ph-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="submit" class="btn btn-primary w-100">Sign in</button>
                                </div>

                                <span class="form-text text-center text-muted">By continuing, you're confirming that
                                    you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie
                                        Policy</a></span>
                            </div>
                        </div>
                    </form>
                    <!-- /login card -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>

</html>
