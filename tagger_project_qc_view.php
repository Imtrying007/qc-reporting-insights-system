<?php include('head.php');
include('connection.php');
// $id = $_GET['id'];
        // if($user_type!="admin")
        // { 
        //  ?>
                <!--  <script>-->
                <!--   window.open('logout.php', '_self');-->
                <!-- </script>-->
   <?php
        // }
    ?>
<?php
// Disable any previous output (avoid extra HTML output)
ob_start(); // Start output buffering to capture and discard any unwanted output
if (isset($_GET['export_excel'])) {
    // SQL query to fetch data
    $sql_export = "
    SELECT 
        p.id AS project_id, 
        p.owner_name, 
        p.project_name, 
        p.status AS project_status, 
        c.Cluster_head_name AS cluster_name, 
        qc.name AS qc_name, 
        pqc.precision, 
        pqc.recall,
        pqc.url
    FROM add_project p
    LEFT JOIN cluster c ON p.cluster = c.id
    LEFT JOIN taggers_qc_status pqc ON p.id = pqc.project_id
    LEFT JOIN qc ON pqc.qc_id = qc.id
    ORDER BY p.date DESC";

    // Execute SQL query
    $result_export = mysqli_query($conn, $sql_export);

    if (!$result_export) {
        // If query fails, don't output anything else
        die("Error fetching data for export: " . mysqli_error($conn));
    }

    // Set headers for CSV export (for Excel compatibility)
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=projects_export.csv"); // Use .csv for Excel compatibility
    header("Cache-Control: max-age=0");

    // Open output stream
    $output = fopen("php://output", "w");

    // Print column headers
    $columns = ["Project ID", "Owner Name", "Project Name", "Cluster", "QC Name", "Precision", "Recall", "Status","URL"];
    fputcsv($output, $columns); // fputcsv handles comma separation

    // Print rows with data
    while ($row = mysqli_fetch_assoc($result_export)) {
        $data = [
            $row['project_id'] ?? '', // Handle null values gracefully
            $row['owner_name'] ?? '',
            $row['project_name'] ?? '',
            $row['cluster_name'] ?? '',
            $row['qc_name'] ?? '',
            $row['precision'] ?? '', // Default value for precision
            $row['recall'] ?? '',    // Default value for recall
            $row['project_status'] ?? '',
            $row['url'] ?? ''
        ];
        fputcsv($output, $data); // Writes each row to the CSV
    }

    // Close the output stream
    fclose($output);
    exit; // Terminate the script to ensure nothing else is sent
}

// End output buffering if necessary
ob_end_clean(); // Clean and discard any buffered output
?>



<script src="../../../assets/demo/demo_configurator.js"></script>
<script src="../../../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="../../../assets/js/jquery/jquery.min.js"></script>
<script src="../../../assets/js/vendor/tables/datatables/datatables.min.js"></script>

<script src="assets/js/app.js"></script>
<script src="../../../assets/demo/pages/datatables_basic.js"></script>

<!-- cdn for datatable -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- /cdn for datatable -->

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
	crossorigin="anonymous"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>	

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"></script>
<script src="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css"></script>

<body>

	<!-- Main navbar -->
	<?php include('header.php') ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include('sidebar.php') ?>
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
								<span style="font-size: 16px;" class="fw-normal"> <a type="button" class="btn btn-primary" onclick="updateQCStatus()" >Refresh Accuracy </a>  <a> <button id="export-button" class="btn btn-success">Export to Excel</button></a></span>
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
            // Fetch project and QC data in a single query
            $sql_projects_qc = "
                SELECT 
                    p.id AS project_id, 
                    p.owner_name, 
                    p.project_name, 
                    p.status AS project_status, 
                    c.Cluster_head_name AS cluster_name, 
                    qc.id AS qc_id, 
                    qc.name AS qc_name, 
                    pqc.precision, 
                    pqc.recall,
                    pqc.url
                FROM add_project p
                LEFT JOIN cluster c ON p.cluster = c.id
                LEFT JOIN taggers_qc_status pqc ON p.id = pqc.project_id
                LEFT JOIN qc ON pqc.qc_id = qc.id
                ORDER BY p.date DESC";
            $result_projects_qc = mysqli_query($conn, $sql_projects_qc);

            if (!$result_projects_qc) {
                die("Error fetching data: " . mysqli_error($conn));
            }

            // Process data into structured arrays
            $projects = [];
            $qc_headers = [];

            while ($row = mysqli_fetch_assoc($result_projects_qc)) {
                $project_id = $row['project_id'];

                // Add project data if not already present
                if (!isset($projects[$project_id])) {
                    $projects[$project_id] = [
                        'owner_name' => $row['owner_name'],
                        'project_name' => $row['project_name'],
                        'cluster_name' => $row['cluster_name'],
                        'status' => $row['project_status'],
                        'qc_data' => []
                    ];
                }

                // Add QC data
                if ($row['qc_id']) {
                    $projects[$project_id]['qc_data'][$row['qc_id']] = [
                        'name' => $row['qc_name'],
                        'precision' => $row['precision'] ?? '-',
                        'recall' => $row['recall'] ?? '-',
                        'url' => $row['url'] ?? '#'
                    ];
                    $qc_headers[$row['qc_id']] = $row['qc_name'];
                }
            }

            // Generate table
            if (!empty($projects)) {
                echo '<table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Project</th>';

                // Add QC columns dynamically
                foreach ($qc_headers as $qc_name) {
                    echo "<th>{$qc_name} (P/R)</th>";
                }

                echo '<th>Status</th>
                      </tr>
                      </thead>
                      <tbody>';

                // Populate table rows
                foreach ($projects as $project) {
                    echo "<tr>
                            <td>
                                ID: {$project['owner_name']}<br>
                                Name: {$project['project_name']}<br>
                                Cluster: {$project['cluster_name']}
                            </td>";

                    // Add QC data dynamically
                    foreach ($qc_headers as $qc_id => $qc_name) {
                        $qc_data = $project['qc_data'][$qc_id] ?? [];

                        $precision = $qc_data['precision'] ?? '-';
                        $recall    = $qc_data['recall'] ?? '-';
                        $url       = $qc_data['url'] ?? '#';

                        echo "<td>
                                P: {$precision}%<br>
                                R: {$recall}%<br>
                                <a href='{$url}' target='_blank'>View Details</a>
                            </td>";
                    }
                    echo "<td>{$project['status']}</td>
                          </tr>";
                }

                echo '</tbody>
                      </table>';
            } else {
                echo '<center><h3>No data found...</h3></center>';
            }
            ?>
        </div>
    </div>
</div>


              	
			</div>
		
		</div>
		
	</div>
	
</body>

</html>

<script type="text/javascript">
   new DataTable('#example');
   
				     function updateQCStatus() {
                                    // AJAX Request
                                    var xhr = new XMLHttpRequest();
                                    xhr.open("POST", "ajax/update_qc_status.php", true); // Backend PHP file
                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            // Handle response
                                            document.getElementById("result").innerHTML = xhr.responseText;
                                        }
                                    };
                        
                                    xhr.send("action=updateQCStatus");
                                }
                     $(document).ready(function () {
                                                      $('#export-button').on('click', function () 
                                                       {
                                                            window.location.href = '?export_excel=true';
                                                        });
                                                   });
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

