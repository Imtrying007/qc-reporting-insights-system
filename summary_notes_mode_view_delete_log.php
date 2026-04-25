<?php 
include('head.php');
include('connection.php');

$email = $_SESSION["email"];
if($user_type!="admin")
        { 
         ?><script>
              window.open('logout.php', '_self');
            </script>
            <?php
        }
    ?>
?>

<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

<body>
    <!-- Main navbar -->
    <?php include('header.php'); ?>
    <!-- /main navbar -->

    <div class="page-content">
        <!-- Main sidebar -->
        <?php include('sidebar.php'); ?>
        <!-- /main sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            <h4 style="font-size: 18px;" class="page-title mb-0">
                                <span style="font-size: 16px;" class="fw-normal">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Deleted Log
                                    </button>
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- /page header -->

                <!-- Content area -->
                <div class="content">
                    <div class="row">
                        <div class="col-xl-12">
                        <?php
                            $query = "
                                SELECT 
                                    id,
                                    p_id,
                                    p_id_name,
                                    p_name,
                                    qc_id,
                                    qc_name,
                                    sheet_url,
                                    deleted_by,
                                    qc_notes_deleted,
                                    qc_summary_deleted,
                                    deleted_at
                                FROM delete_log
                                ORDER BY deleted_at DESC
                            ";

                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                echo '<div class="table-responsive">';
                                echo '<table id="example" class="table table-bordered table-striped">';
                                echo '<thead>';
                                echo '<tr>
                                        <th>Project ID</th>
                                        <th>Project Name</th>
                                        <th>QC Name</th>
                                        <th>QC ID</th>
                                        <th>Deleted By</th>
                                        <th>QC Notes Deleted</th>
                                        <th>QC Summary Deleted</th>
                                        <th>Sheet Url</th>
                                        <th>Deleted At</th>
                                    </tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                            <td>' . htmlspecialchars($row['p_id']) . '</td>
                                            <td>' . htmlspecialchars($row['p_id_name']) . ' - ' . htmlspecialchars($row['p_name']) . '</td>
                                            <td>' . htmlspecialchars($row['qc_name']) . '</td>
                                            <td>' . htmlspecialchars($row['qc_id']) . '</td>
                                            <td>' . htmlspecialchars($row['deleted_by']) . '</td>
                                            <td>' . htmlspecialchars($row['qc_notes_deleted']) . '</td>
                                            <td>' . htmlspecialchars($row['qc_summary_deleted']) . '</td>
                                            <td>
                                                <a href="' . htmlspecialchars($sheet_link) . '" target="_blank">view</a>
                                            </td>
                                            <td>' . htmlspecialchars($row['deleted_at']) . '</td>
                                        </tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo '<center><h3>No Deleted Records Found...</h3></center>';
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <!-- /content area -->
            </div>
            <!-- /inner content -->
        </div>
        <!-- /main content -->
    </div>

</body>

</html>

<!-- Include jQuery and DataTables CSS/JS -->


<script type="text/javascript">
   new DataTable('#example');
</script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

