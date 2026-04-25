<?php 
include('head.php');
include('connection.php');
session_start();
?>

<script src="../../../assets/demo/demo_configurator.js"></script>
<script src="../../../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../../../assets/js/jquery/jquery.min.js"></script>
<script src="../../../assets/js/vendor/tables/datatables/datatables.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="../../../assets/demo/pages/datatables_basic.js"></script>

<!-- CDN for DataTable -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Additional Bootstrap and jQuery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<body>

	<!-- Main Navbar -->
	<?php include('header.php'); ?>
	<!-- /Main Navbar -->

	<!-- Page Content -->
	<div class="page-content">

		<!-- Main Sidebar -->
		<?php include('sidebar.php'); ?>
		<!-- /Main Sidebar -->

		<!-- Main Content -->
		<div class="content-wrapper">
			<div class="content-inner">

				<!-- Page Header -->
				<div class="page-header page-header-light shadow">
					<div class="page-header-content d-lg-flex">
						<div class="d-flex">
							<h4 class="page-title mb-0">
								<b>Restore QC Records</b>
							</h4>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!-- Content Area -->
				<div class="content">
					<div class="row">
						<div class="col-xl-12">

							<?php
							$sql_query = "SELECT * FROM `dump_qc`";
							$result = mysqli_query($conn, $sql_query);
							$count = mysqli_num_rows($result);

							if ($count > 0) {
							?>

							<table id="example" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Ser No.</th>
										<th>Name</th>
										<th>Status</th>
										<th>Deleted By</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php
									$ser = 1;
									while ($data = mysqli_fetch_assoc($result)) {
									?>
										<tr id="row_<?php echo $data['id']; ?>">
											<td><?php echo $ser++; ?></td>
											<td><?php echo $data['name']; ?></td>
											<td><?php echo $data['status']; ?></td>
											<td><?php echo $data['Del_person_id']; ?></td>
											<td>
												<button class="btn btn-success btn-sm" onclick="restore_qc('<?php echo $data['id']; ?>')">Restore</button>
											</td>
										</tr>
									<?php
									}
									?>

								</tbody>
							</table>

							<?php } else { ?>
								<center><h3>No deleted QC records found.</h3></center>
							<?php } ?>

						</div>
					</div>
				</div>

			</div>
		</div>

	</div>

</body>

</html>

<script>
    new DataTable('#example');

    function restore_qc(id) {
        if (!confirm("Are you sure you want to restore this QC record?")) {
            return;
        }

        $.ajax({
            type: "POST",
            url: "Restore/restore_qc.php",
            data: { id: id },
            success: function(response) {
                response = response.trim();

                if (response === "success") {
                    showAlert("success", "Record restored successfully!");
                    $("#row_" + id).fadeOut(500);
                } else {
                    showAlert("danger", "Failed to restore record!");
                }
            },
            error: function() {
                showAlert("danger", "An error occurred. Please try again.");
            }
        });
    }

    function showAlert(type, message) {
        let alertBox = $("#alertBox"); 
        alertBox.removeClass("alert-success alert-danger alert-warning")
                .addClass("alert-" + type)
                .text(message)
                .fadeIn();

        setTimeout(() => alertBox.fadeOut(), 2000);
    }
</script>
