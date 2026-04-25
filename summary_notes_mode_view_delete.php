<?php 
include('head.php');
include('connection.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != "admin") {
    header("Location: logout.php");
    exit();
}
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
                                        Project QC Status
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
                                    o.id,
                                    o.p_id,
                                    o.p_id_name,
                                    o.p_name,
                                    o.qc_id,
                                    o.qc_name,
                                    o.sheet_url,
                                    o.status,
                                    o.approved_by,
                                    o.approved_date,
                                    o.submitted_by,
                                    o.submitted_date,
                                    o.category_id,
                                    o.category_name,
                                    o.total_image_count,
                                    o.self_count,
                                    o.comp_count,
                                    o.others_count,
                                    o.sticker_count,
                                    o.incorrect_self,
                                    o.incorrect_comp,
                                    o.incorrect_others,
                                    o.SPI,
                                    o.CPI,
                                    o.NPD,
                                    o.total_count,
                                    o.total_incorrect,
                                    o.accuracy,
                                    o.Ai_grade,
                                    o.recommendation,
                                    o.is_overall,
                                    o.created_at,
                                    IFNULL(c.total_categories, 0) AS total_categories
                                FROM qc_summary o
                                LEFT JOIN (
                                    SELECT p_id, qc_id, COUNT(*) AS total_categories
                                    FROM qc_summary
                                    WHERE is_overall = 0 
                                    AND category_id IS NOT NULL 
                                    AND category_name <> 'overall'
                                    GROUP BY p_id, qc_id
                                ) c ON o.p_id = c.p_id AND o.qc_id = c.qc_id
                                WHERE o.is_overall = 1
                                ORDER BY o.id DESC
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
                                        <th>Total Categories</th>
                                        <th>SPI</th>
                                        <th>CPI</th>
                                        <th>NPD</th>
                                        <th>Accuracy</th>
                                        <th>AI Grade</th>
                                        <th>Sheet URL</th>
                                        <th>Submitted By</th>
                                        <th>Submitted Date</th>
                                        <th>issue_list</th>
                                        <th>Status</th>
                                        <th>Approved by</th>
                                        <th>Action</th>
                                    </tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr id="row-' . $row['p_id'] . '-' . $row['qc_id'] . '">
                                            <td>' . htmlspecialchars($row['p_id_name']) . '</td>
                                            <td>' . htmlspecialchars($row['p_name']) . '</td>
                                            <td>' . htmlspecialchars($row['qc_name']) . '</td>
                                            <td class="total-categories" data-pid="' . $row['p_id'] . '" data-qcid="' . $row['qc_id'] . '" style="cursor:pointer;color:blue;">' 
                                                . htmlspecialchars($row['total_categories']) . '</td>
                                            <td>' . htmlspecialchars($row['SPI']) . '</td>
                                            <td>' . htmlspecialchars($row['CPI']) . '</td>
                                            <td>' . htmlspecialchars($row['NPD']) . '</td>
                                            <td>' . htmlspecialchars($row['accuracy']) . '</td>
                                            <td>' . htmlspecialchars($row['Ai_grade']) . '</td>
                                            <td>
                                                <a href="' . htmlspecialchars($row['sheet_url']) . '" target="_blank">
                                                    view_sheet
                                                </a>
                                            </td>
                                            <td>' . htmlspecialchars($row['submitted_by']) . '</td>
                                            <td>' . htmlspecialchars($row['submitted_date']) . '</td>
                                            <td style="cursor:pointer;color:blue;">
                                                <form action="summary_notes_issue_list.php" method="post" style="display:inline;" target="_blank">
                                                    <input type="hidden" name="p_id" value="' . htmlspecialchars($row['p_id']) . '">
                                                    <input type="hidden" name="qc_id" value="' . htmlspecialchars($row['qc_id']) . '">
                                                    <button type="submit" style="background:none; border:none; color:blue; cursor:pointer;">issue_list</button>
                                                </form>
                                            </td>
                        
                                            <td>
                                                <button class="toggle-status" data-id="' . $row['id'] . '">
                                                    ' . htmlspecialchars($row['status']) . '
                                                </button>
                                            </td>
                                            <td id="approved-info-' . $row['id'] . '">
                                                ' . htmlspecialchars($row['approved_by']) . '<br>
                                                ' . htmlspecialchars($row['approved_date']) . '
                                            </td>                                            
                                            <td >
                                                <button 
                                                    class="delete-record"
                                                    data-p_id="' . htmlspecialchars($row['p_id']) . '"
                                                    data-qc_id="' . htmlspecialchars($row['qc_id']) . '">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo '<center><h3>No Data Found Here...</h3></center>';
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


<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        // optional configurations here
    });

    $('#example tbody').on('click', '.total-categories', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var p_id = $(this).data('pid');
        var qc_id = $(this).data('qcid');

        // Debug popup showing what’s sent
        // alert('Sending to fetch_category_details.php:\nProject ID: ' + p_id + '\nQC ID: ' + qc_id);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: 'new_pipeline/fetch_category_details.php',
                method: 'POST',
                data: { p_id: p_id, qc_id: qc_id },
                success: function(data) {
                    row.child(data).show();
                    tr.addClass('shown');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error, xhr.responseText);
                    row.child('Error loading data').show();
                    tr.addClass('shown');
                }
            });
        }
    });
});


document.addEventListener("click", function(e) {
    if (e.target.classList.contains("toggle-status")) {

        let btn = e.target;
        let id = btn.getAttribute("data-id");

        fetch("new_pipeline/update_approved_status.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                // Update approved info (if exists on page)
                let info = document.getElementById("approved-info-" + id);
                if (info) {
                    info.innerHTML =
                        (data.approved_by ?? '') + "<br>" + (data.approved_date ?? '');
                }

                // Update button text (status)
                btn.innerText =
                    data.status === "approved" ? "approved" :
                    data.status === "rejected" ? "rejected" :
                    "pending";
            }
        });
    }
});
</script>
<!-- deleteion script -->
<script>

function handleDelete(btn) {
    const p_id = btn.getAttribute("data-p_id");
    const qc_id = btn.getAttribute("data-qc_id");

    if (!confirm("Are you sure you want to delete this record?")) {
        return;
    }

    fetch("new_pipeline/delete_sumary_notes.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "p_id=" + encodeURIComponent(p_id) +
            "&qc_id=" + encodeURIComponent(qc_id)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            // ✅ Remove row
            const row = document.getElementById("row-" + p_id + "-" + qc_id);
            if (row) row.remove();

            // ✅ Show detailed message
            alert(
                "Deleted successfully!\n\n" +
                "qc_notes: " + data.deleted_notes + " rows\n" +
                "qc_summary: " + data.deleted_summary + " rows"
            );

        } else {
            alert(data.message || "Delete failed!");
        }
    })
    .catch(error => {
        console.error(error);
        alert("Something went wrong!");
    });
}

// ✅ Only delete handler (no conflict)
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("delete-record")) {
        handleDelete(e.target);
    }
});
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

