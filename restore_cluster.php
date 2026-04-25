<?php
include('head.php');
include('connection.php');

// Ensure only admin or dsuser can access
if ($user_type != "admin" && $user_type != "dsuser") { 
    echo "<script>window.open('logout.php', '_self');</script>";
    exit;
}
?>

<!-- Include jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.min.css">

<body>
    <?php include('header.php'); ?>

    <div class="page-content">
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-inner">
                <!-- Page Header -->
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex align-items-center justify-content-between">
                        <h4 class="page-title mb-0 text-primary fw-bold">
                            <i class="fas fa-undo-alt"></i> Restore Deleted Clusters
                        </h4>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="content">
                    <div id="messageBox"></div> <!-- Alert Box for Status Messages -->
                    <div class="row">
                        <div class="col-xl-12">
                            <?php
                            $sql = "SELECT * FROM `dump_cluster` ORDER BY `id` DESC";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                            ?>
                                <table id="restoreClusterTable" class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Cluster Name</th>
                                            <th>Cluster Head</th>
                                            <th>Status</th>
                                            <th>Deleted By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                                            <tr id="row_<?php echo $data['id']; ?>">
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['cluster']; ?></td>
                                                <td><?php echo $data['Cluster_head_name']; ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo ($data['status'] == 'Active') ? 'success' : 'danger'; ?>">
                                                        <?php echo $data['status']; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $data['del_person_id']; ?></td>
                                                <td>
                                                    <button id="restore-btn-<?php echo $data['id']; ?>" 
                                                            class="btn btn-success btn-sm" 
                                                            onclick="restoreCluster(<?php echo $data['id']; ?>)">
                                                        <i class="fas fa-recycle"></i> Restore
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php
                            } else {
                                echo "<div class='alert alert-info text-center'><strong>No deleted clusters found.</strong></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            new DataTable('#restoreClusterTable'); // Apply DataTable styling
        });

        function restoreCluster(id) {
            if (!confirm("Are you sure you want to restore this cluster?")) return;

            let button = $("#restore-btn-" + id);
            button.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Restoring...');

            $.ajax({
                type: "POST",
                url: "Restore/restore_cluster.php",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#row_" + id).fadeOut("slow", function () {
                            $(this).remove();
                            showMessage(response.message, "success");
                        });
                    } else {
                        button.prop("disabled", false).html('<i class="fas fa-recycle"></i> Restore');
                        showMessage(response.message, "danger");
                    }
                },
                error: function () {
                    button.prop("disabled", false).html('<i class="fas fa-recycle"></i> Restore');
                    showMessage("An unexpected error occurred!", "danger");
                }
            });
        }

        function showMessage(message, type) {
            let alertBox = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $("#messageBox").html(alertBox);
            setTimeout(() => $(".alert").fadeOut("slow"), 3000);
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
