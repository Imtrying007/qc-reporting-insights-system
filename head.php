<?php
session_start();
$email = $_SESSION["email"] ?? "";
$user_type = $_SESSION["user_type"] ?? "";
date_default_timezone_set("Asia/Kolkata");

$date = date("d/m/Y");
$time =  date("H:i a");

if (empty($email)) {
    ?>
    <script>
      window.open('logout.php', '_self');
    </script>
     <?php
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project Management Software</title>

    <!-- Global stylesheets -->
    <link href="assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="assets/demo/demo_configurator.js"></script>
    <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->
    <!-- datatable -->
    <script src="assets/js/jquery/jquery.min.js"></script>
    <script src="assets/demo/pages/datatables_basic.js"></script>
    <script src="assets/js/vendor/tables/datatables/datatables.min.js"></script>
    <!-- /datatable -->
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>

    <!-- Theme JS files -->
    <script src="assets/js/vendor/visualization/d3/d3.min.js"></script>
    <script src="assets/js/vendor/visualization/d3/d3_tooltip.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="assets/demo/pages/dashboard.js"></script>
    <script src="assets/demo/charts/pages/dashboard/streamgraph.js"></script>
    <script src="assets/demo/charts/pages/dashboard/sparklines.js"></script>
    <script src="assets/demo/charts/pages/dashboard/lines.js"></script>
    <script src="assets/demo/charts/pages/dashboard/areas.js"></script>
    <script src="assets/demo/charts/pages/dashboard/donuts.js"></script>
    <script src="assets/demo/charts/pages/dashboard/bars.js"></script>
    <script src="assets/demo/charts/pages/dashboard/progress.js"></script>
    <script src="assets/demo/charts/pages/dashboard/heatmaps.js"></script>
    <script src="assets/demo/charts/pages/dashboard/pies.js"></script>
    <script src="assets/demo/charts/pages/dashboard/bullets.js"></script>
    <!-- CK Editer CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
    <!-- /theme JS files -->
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

</head>