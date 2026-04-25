<?php 
include('head.php');
include('connection.php');

$email = $_SESSION['email'];

if (isset($_POST['p_id'], $_POST['qc_id'])) {

    $p_id = $_POST['p_id'];
    $qc_id = $_POST['qc_id'];

    // ✅ OPTIMIZED SINGLE QUERY (NO LOOP QUERY)
    $query = "
    SELECT 
        q1.*,
        GROUP_CONCAT(DISTINCT q2.qc_name SEPARATOR ', ') AS qcNames
    FROM qc_notes q1
    LEFT JOIN qc_notes q2 
        ON q1.p_id = q2.p_id
        AND q1.category_id = q2.category_id
        AND q1.category_name = q2.category_name
        AND q1.actual = q2.actual
        AND q1.predicted = q2.predicted
    WHERE q1.p_id = ? AND q1.qc_id = ?
    GROUP BY q1.id
    ORDER BY q1.id DESC
    ";

    if ($stmt = mysqli_prepare($conn, $query)) {
        $query_start = microtime(true);
        mysqli_stmt_bind_param($stmt, "si", $p_id, $qc_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $query_end = microtime(true);
        $query_time = $query_end - $query_start;

        // For header buttons
        $info_row = mysqli_fetch_assoc($result);
        mysqli_data_seek($result, 0);

    } else {
        die("Failed to prepare SQL statement.");
    }

} else {
    die("Project ID or QC ID not specified.");
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
                            <button type="button" class="btn btn-primary">
                                <?= htmlspecialchars($info_row['p_id_name']) ?>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <?= htmlspecialchars($info_row['p_name']) ?>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <?= htmlspecialchars($info_row['qc_name']) ?>
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.open('<?= htmlspecialchars($info_row['sheet_url']) ?>','_blank')">
                                View image sheet
                            </button>
                            <form action="summary_notes_issue_list_projects_all_round.php" 
                                method="post" 
                                style="display:inline;" 
                                target="_blank">
                                <input type="hidden" name="p_id" value="<?= htmlspecialchars($p_id) ?>">
                                <button type="submit" class="btn btn-primary">
                                    All qc round issue list
                                </button>
                            </form>
                        </h4>
                    </div>
                </div>

                <!-- Content area -->
                <div class="content">
                    <div class="row">
                        <div class="col-xl-12">
                            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                  <div class="mb-2">
                                        <strong>Query executed in:</strong> <?= number_format($query_time, 4) ?> seconds
                                    </div>
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Category ID</th>
                                                <th>Category Name</th>
                                                <th>Actual</th>
                                                <th>Predicted</th>
                                                <th>Case_Count(A,P)</th>
                                                <th>T_Actual_count</th>
                                                <th>Total incosistenciest</th>
                                                <th>Category Ratio</th>
                                                <th>Submitted By</th>
                                                <th>Submitted Date</th>
                                                <th>Refer_image</th>
                                                <th>Persistency</th>
                                                <th>Review_update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['category_id']) ?></td>
                                                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                                                    <td><?= htmlspecialchars($row['actual']) ?></td>
                                                    <td><?= htmlspecialchars($row['predicted']) ?></td>
                                                    <td><?= htmlspecialchars($row['count']) ?></td>
                                                    <td><?= htmlspecialchars($row['actual_count'] ?? 0) ?></td>
                                                    <td><?= htmlspecialchars($row['total_count'] ?? 0) ?></td>
                                                    <td><?= htmlspecialchars($row['category_ratio']) ?></td>
                                                    <td><?= htmlspecialchars($row['submitted_by']) ?></td>
                                                    <td><?= htmlspecialchars($row['submitted_date']) ?></td>
                                                    <td>
                                                        <a href="<?='https://view.shelfwatch.io/?url='.htmlspecialchars($row['refer_sheet_url']) ?>" target="_blank">
                                                            view
                                                        </a>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['qcNames']) ?></td>
                                                    <td>
                                                        <button class="toggle-status" data-id="<?= $row['id'] ?>">
                                                            <?= htmlspecialchars($row['status']) ?>
                                                        </button>
                                                        <br>
                                                        <span id="approved-info-<?= $row['id'] ?>">
                                                            <?= htmlspecialchars($row['approved_by']) ?><br>
                                                            <?= htmlspecialchars($row['approved_date']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
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
   
   document.addEventListener("click", function(e) {
    if (e.target.classList.contains("toggle-status")) {

        let btn = e.target;
        let id = btn.getAttribute("data-id");

        fetch("new_pipeline/skulist_update_approved_status.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                // Update approved info
                document.getElementById("approved-info-" + id).innerHTML =
                    (data.approved_by ?? '') + "<br>" + (data.approved_date ?? '');

                // Update button text (status shown here)
                btn.innerText =
                    data.status === "approved" ? "approved" :
                    data.status === "rejected" ? "rejected" :
                    "pending ⏳";
            }
        });
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

