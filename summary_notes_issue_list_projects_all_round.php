<?php 
include('head.php');
include('connection.php');

$email = $_SESSION['email'];
if (!isset($_POST['p_id'])) die("Project ID not specified.");

$p_id = $_POST['p_id'];

// 1️⃣ Execute query & measure SQL execution time
$query_start = microtime(true);

$query = "SELECT * FROM qc_notes WHERE p_id = ? ORDER BY qc_id DESC, category_id";

if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $p_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $query_end = microtime(true);
    $query_time = $query_end - $query_start;

    // 2️⃣ Process table data & measure processing time
    $process_start = microtime(true);

    $qc_columns = [];
    $table_data = [];
    $info_row = ['p_id_name' => 'N/A', 'p_name' => 'N/A'];

    if ($first_row = mysqli_fetch_assoc($result)) {
        // Project info
        $info_row['p_id_name'] = $first_row['p_id_name'];
        $info_row['p_name'] = $first_row['p_name'];

        $qc_columns = []; // initialize once here

        $first_qc_key = $first_row['qc_id'] . '_' . date('Y-m-d', strtotime($first_row['submitted_date']));

        // add column
        $qc_columns[$first_qc_key] = $first_row['qc_name'] . ' / ' . date('Y-m-d', strtotime($first_row['submitted_date']));

        // build row
        $key = $first_row['category_id'].'|'.$first_row['category_name'].'|'.$first_row['actual'].'|'.$first_row['predicted'];

        $table_data[$key] = [
            'category_id' => $first_row['category_id'],
            'category_name' => $first_row['category_name'],
            'actual' => $first_row['actual'],
            'predicted' => $first_row['predicted'],
            'qcs' => [
                $first_qc_key => $first_row['category_ratio'].'<br>'.$first_row['refer_sheet_url']
            ]
        ];
        while ($row = mysqli_fetch_assoc($result)) {
            $qc_key = $row['qc_id'] . '_' . date('Y-m-d', strtotime($row['submitted_date']));
            if (!isset($qc_columns[$qc_key])) {
                $qc_columns[$qc_key] = $row['qc_name'] . ' / ' . date('Y-m-d', strtotime($row['submitted_date']));
            }

            // Build table data as before
            $key = $row['category_id'].'|'.$row['category_name'].'|'.$row['actual'].'|'.$row['predicted'];
            if (!isset($table_data[$key])) {
                $table_data[$key] = [
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'],
                    'actual' => $row['actual'],
                    'predicted' => $row['predicted'],
                    'qcs' => []
                ];
            }
            $table_data[$key]['qcs'][$qc_key] = $row['category_ratio'].'<br>'.$row['refer_sheet_url'];
        }
    }

    // Reverse QC columns (latest QC first)
    krsort($qc_columns);

    $process_end = microtime(true);
    $process_time = $process_end - $process_start;

    mysqli_stmt_close($stmt);
} else {
    die("Failed to prepare SQL statement.");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary Notes Issue List</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
    <!-- Main navbar -->
    <?php include('header.php'); ?>

    <div class="page-content">
        <!-- Main sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header page-header-light shadow mb-3">
                    <div class="page-header-content d-lg-flex">
                        <h4 class="page-title mb-0">
                           <!-- Buttons for project info -->
                            <button type="button" class="btn btn-primary">
                                <?= htmlspecialchars($info_row['p_id_name']) ?>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <?= htmlspecialchars($info_row['p_name']) ?>
                            </button>
                            
                        </h4>
                    </div>
                </div>

                <!-- Content area -->
                <div class="content">
                    <div class="row">
                        <div class="col-xl-12">
                            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <div class="mb-2">
                                <strong>Query executed in:</strong> <?= number_format($query_time, 6) ?> seconds
                                <br>
                                <strong>Table processing/rendering time:</strong> <?= number_format($process_time, 6) ?> seconds
                            </div>

                            <!-- Dynamic Table -->
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category ID</th>
                                            <th>Category Name</th>
                                            <th>Actual</th>
                                            <th>Predicted</th>
                                            <?php foreach ($qc_columns as $qc_id => $qc_name): ?>
                                                <th><?= htmlspecialchars($qc_name) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($table_data as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['category_id']) ?></td>
                                                <td><?= htmlspecialchars($row['category_name']) ?></td>
                                                <td><?= htmlspecialchars($row['actual']) ?></td>
                                                <td><?= htmlspecialchars($row['predicted']) ?></td>
                                                <?php foreach ($qc_columns as $qc_id => $qc_name): ?>
                                                    <td>
                                                        <?php if (isset($row['qcs'][$qc_id])): 
                                                            list($ratio, $url) = explode('<br>', $row['qcs'][$qc_id]); ?>
                                                            <?= htmlspecialchars($ratio) ?><br>
                                                            <a href="<?='https://view.shelfwatch.io/?url='.htmlspecialchars($url) ?>" target="_blank">View</a>
                                                        <?php else: ?>
                                                            0
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                                <div class="text-center">
                                    <h3>No Data Found Here...</h3>
                                </div>
                            <?php endif; ?>
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
<script type="text/javascript">
   new DataTable('#example');
</script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

