<?php include('head.php');
// include('connection.php');
// $id = $_GET['id'];
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

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
    
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
								<span style="font-size: 16px;" class="fw-normal"><b> Stats :  </b></span>
							</h4>
                        </div>
					</div>
                </div>
                
				<!-- /page header -->
	<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row" style="gap: 15px; display: flex; flex-wrap: wrap;">

        <!-- Box 1: Total Projects -->
        <?php
        $totalProjects = $conn->query("SELECT COUNT(*) AS total FROM add_project")->fetch_assoc();
        $activeProjects = $conn->query("SELECT COUNT(*) AS active FROM add_project WHERE status = 'active'")->fetch_assoc();
        $inactiveProjects = $conn->query("SELECT COUNT(*) AS inactive FROM add_project WHERE status = 'inactive'")->fetch_assoc();
        ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box" style="background: linear-gradient(135deg, #1E90FF, #87CEFA); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 150px;">
                <div class="inner">
                    <h3>Project Stats</h3><br>
                    <h4>Total: <?= $totalProjects['total'] ?></h4>
                    <p>Active: <?= $activeProjects['active'] ?> | Inactive: <?= $inactiveProjects['inactive'] ?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-clipboard"></i>
                </div>
                <!--<a href="#" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
        </div>
        
        
        
         <!-- Box 2: Training Queue Data -->
        <?php
        $trainingTotal = $conn->query("SELECT COUNT(*) AS total FROM `training _queue`")->fetch_assoc();
        $trainingPending = $conn->query("SELECT COUNT(*) AS pending FROM `training _queue` WHERE info_status = 'pending'")->fetch_assoc();
        $trainingCompleted = $conn->query("SELECT COUNT(*) AS completed FROM `training _queue` WHERE info_status = 'recieved'")->fetch_assoc();
        ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box" style="background: linear-gradient(135deg, #FF4500, #FFA07A); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 150px;">
                <div class="inner">
                    <h4>Training Queue Data</h4>
                    <h6>Total: <?= $trainingTotal['total'] ?></h6>
                    <p>Pending: <?= $trainingPending['pending'] ?> | Recieved: <?= $trainingCompleted['completed'] ?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-clock"></i>
                </div>
                <a href="cs_training_q.php" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <!--boox 6 DS Table-->
<?php
        // Query to count total, done, and pending statuses from the ds_table_qc_status table
        $totalQCStatus = $conn->query("SELECT COUNT(*) AS total FROM ds_table_qc_status")->fetch_assoc();
        $doneStatus = $conn->query("SELECT COUNT(*) AS done FROM ds_table_qc_status WHERE status = 'done'")->fetch_assoc();
        $pendingStatus = $conn->query("SELECT COUNT(*) AS pending FROM ds_table_qc_status WHERE status = 'pending'")->fetch_assoc();
        ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box" style="background: linear-gradient(135deg, #FF7F50, #FFD700); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 150px;">
                <div class="inner">
                    <h4>DS Requests</h4>
                    <h6>Total: <?= $totalQCStatus['total'] ?></h6>
                    <p>Done: <?= $doneStatus['done'] ?> | Pending: <?= $pendingStatus['pending'] ?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="dstab_qc_status.php" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>


 
        <!-- Box 3: Cluster-wise Stats -->
         <?php
// Query to fetch cluster stats and join with cluster details
$query3 = "
    SELECT 
        c.cluster AS cluster_name, 
        c.Cluster_head_name, 
        SUM(CASE WHEN p.status = 'active' THEN 1 ELSE 0 END) AS active_count, 
        SUM(CASE WHEN p.status = 'inactive' THEN 1 ELSE 0 END) AS pending_count, 
        COUNT(*) AS total_count
    FROM 
        add_project p
    JOIN 
        cluster c 
    ON 
        p.cluster = c.id
    GROUP BY 
        p.cluster
    ORDER BY 
         `cluster_name` ASC;
";

$clusters = $conn->query($query3);

if ($clusters && $clusters->num_rows > 0) {
    // Start rendering the single box
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="small-box" style="background: linear-gradient(135deg, #6A0DAD, #DDA0DD); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: auto; padding: 20px;">
            <div class="inner">
                <h3>Cluster Stats</h3>
                <table style="width: 100%; color: white; text-align: left; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 10px; border-bottom: 1px solid white;">Cluster</th>
                            <th style="padding: 10px; border-bottom: 1px solid white;">Cluster Head</th>
                            <th style="padding: 10px; border-bottom: 1px solid white;">Projects</th>
                            <th style="padding: 10px; border-bottom: 1px solid white;">Active Projects</th>
                            <th style="padding: 10px; border-bottom: 1px solid white;">Inactive Projects</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cluster = $clusters->fetch_assoc()) { ?>
                            <tr>
                                <td style="padding: 10px;"><?= htmlspecialchars($cluster['cluster_name']) ?></td>
                                <td style="padding: 10px;"><?= htmlspecialchars($cluster['Cluster_head_name']) ?></td>
                                <td style="padding: 10px;"><?= $cluster['total_count'] ?></td>
                                <td style="padding: 10px;"><?= $cluster['active_count'] ?></td>
                                <td style="padding: 10px;"><?= $cluster['pending_count'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="ds_project_qc_status.php" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <?php
}
?>

<!-- Box 4 QC iteration-->
<?php
    // Query to get the QC ID, QC name, and total count for each QC ID in a single query
    $result = $conn->query(" 
        SELECT 
            p.qc_id, 
            q.name AS qc_name,
            COUNT(*) AS total_records 
        FROM 
            project_qc_status p
        JOIN 
            qc q ON p.qc_id = q.id
        GROUP BY 
            p.qc_id, q.name;
    ");
?>

<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box" style="background: linear-gradient(135deg, #008080, #20B2AA); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 300px;">
        <div class="inner">
            <h3>QC Iterations</h3>
            <table style="width: 100%; color: white; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 5px; border-bottom: 1px solid white;">QC Iteration</th>
                        <th style="text-align: left; padding: 5px; border-bottom: 1px solid white;">Projects</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Using a while loop to fetch and display all rows from the database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $qc_name = $row['qc_name'];
                                $total_records = $row['total_records'];
                                echo "<tr>
                                        <td style='padding: 5px;'>$qc_name</td>
                                        <td style='padding: 5px;'>$total_records</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' style='padding: 5px; text-align: center;'>No data available</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="icon">
            <i class="ion ion-checkmark"></i>
        </div>
        <a href="project_qc_view.php" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
       

       


        <!-- Box 5  request training and message -->
              <?php
// Optimized query to fetch counts for both Request and mesage_request tables
$combinedQuery = "
    SELECT 
        -- Request counts
        (SELECT COUNT(*) FROM Request) as total_requests,
        (SELECT SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) FROM Request) as pending_requests,
        (SELECT SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) FROM Request) as done_requests,
        
        -- mesage_request counts
        (SELECT COUNT(*) FROM mesage_request) as total_messages,
        (SELECT SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) FROM mesage_request) as pending_messages,
        (SELECT SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) FROM mesage_request) as done_messages
";

// Execute the query
$result = $conn->query($combinedQuery);

// Fetch results
$data = $result->fetch_assoc();
$totalRequests = $data['total_requests'];
$pendingRequests = $data['pending_requests'];
$doneRequests = $data['done_requests'];

$totalMessages = $data['total_messages'];
$pendingMessages = $data['pending_messages'];
$doneMessages = $data['done_messages'];
?>

<div class="col-lg-4 col-md-6 col-sm-12 mb-3">
    <div class="small-box" style="background: linear-gradient(135deg, #32CD32, #98FB98); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
        <div class="inner" style="flex-grow: 1; padding: 15px;">
            <h4>Requests & Messages</h4>
            <div style="margin-bottom: 10px;">
                <h6>Total Requests: <?php echo $totalRequests; ?></h6>
                <p>Pending: <?php echo $pendingRequests; ?> || Done: <?php echo $doneRequests; ?></p>
                <div class="icon" style="text-align: center; padding: 5px;">
            <i class="ion ion-ios-paper" style="font-size: 40px;"></i> <!-- Icon for both requests and messages -->
        </div>
        <a href="send_request.php" class="small-box-footer" style="color: white; text-decoration: underline; text-align: center; padding: 10px 0;">More Request info <i class="fa fa-arrow-circle-right"></i></a><br>
    
            </div>
            
            <div>
                <h6>Total Messages: <?php echo $totalMessages; ?></h6>
                <p>Pending: <?php echo $pendingMessages; ?> || Done: <?php echo $doneMessages; ?></p>
                <div class="icon" style="text-align: center; padding: 10px;">
            <i class="ion ion-ios-paper" style="font-size: 40px;"></i> <!-- Icon for both requests and messages -->
        </div>
        <a href="message_request.php" class="small-box-footer" style="color: white; text-decoration: underline; text-align: center; padding: 10px 0;">More Message info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!--<div class="icon" style="text-align: center; padding: 10px;">-->
        <!--    <i class="ion ion-ios-paper" style="font-size: 40px;"></i> <!-- Icon for both requests and messages -->
        <!--</div>-->
        <!--<a href="" class="small-box-footer" style="color: white; text-decoration: underline; text-align: center; padding: 10px 0;">More Message info <i class="fa fa-arrow-circle-right"></i></a>-->
    </div>
</div>
<!-- Box 6 Taggers QC iteration-->
<?php
    // Query to get the QC ID, QC name, and total count for each QC ID in a single query
    $result = $conn->query(" 
        SELECT 
            p.qc_id, 
            q.name AS qc_name,
            COUNT(*) AS total_records 
        FROM 
            taggers_qc_status p
        JOIN 
            qc q ON p.qc_id = q.id
        GROUP BY 
            p.qc_id, q.name;
    ");
?>

<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="small-box" style="background: linear-gradient(135deg, #008080, #20B2AA); color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); height: 300px;">
        <div class="inner">
            <h3>Taggers QC Iterations</h3>
            <table style="width: 100%; color: white; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 5px; border-bottom: 1px solid white;">QC Iteration</th>
                        <th style="text-align: left; padding: 5px; border-bottom: 1px solid white;">Projects</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Using a while loop to fetch and display all rows from the database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $qc_name = $row['qc_name'];
                                $total_records = $row['total_records'];
                                echo "<tr>
                                        <td style='padding: 5px;'>$qc_name</td>
                                        <td style='padding: 5px;'>$total_records</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' style='padding: 5px; text-align: center;'>No data available</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="icon">
            <i class="ion ion-checkmark"></i>
        </div>
        <a href="tagger_project_qc_view.php" class="small-box-footer" style="color: white; text-decoration: underline;">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

        
    
</section>

				
			</div>
		
		</div>
		
	</div>
	
</body>


</html>

<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>