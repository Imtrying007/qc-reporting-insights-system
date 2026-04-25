<?php include('head.php');
include('connection.php');
$email = $_SESSION["email"];
// $id = $_GET['id'];
        if($user_type!="admin")
        { 
         ?><script>
              window.open('logout.php', '_self');
            </script>
            <?php
        }
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
							<h4 class="page-title mb-0 fw-bold text-primary">
                                Restore Deleted QC Status</span>
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
							 $sql = "SELECT * FROM `dump_taggers_qc_status` ORDER BY `date` DESC";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                            ?>
							
		
                        		<table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                        <tr>
                                            <th>Project ID</th>
                                            <th>Project Name</th>
                                            <th>Cluster</th>
                                            <th>QC ID</th>
                                            <th>Total Annotations</th>
                                            <th>Missed Annotations</th>
                                            <th>Incorrect Self</th>
                                            <th>Incorrect Comp</th>
                                            <th>Incorrect Others</th>
                                            <th>Precision</th>
                                            <th>Recall</th>
                                            <th>URL</th>
                                            <th>Date, Time</th>
                                            <th>Status</th>
                                            <th>Deleted By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
        <tbody>
            
            <?php
                      while ($data = mysqli_fetch_assoc($result)) {
                                                    
                          ?>
                                <tr id="del_<?php echo $data['id']; ?>">
                                    <?php $q_pnid ="SELECT * FROM `add_project` WHERE `id`=".$data['project_id'];
                                          $rqnid=mysqli_query($conn,$q_pnid);
                                          $dpidn=mysqli_fetch_assoc($rqnid);
                                          
                                          $qcname ="SELECT * FROM `qc` WHERE `id`=".$data['qc_id'];
                                          $rqcn=mysqli_query($conn,$qcname);
                                          $qcn=mysqli_fetch_assoc($rqcn);
                                          
                                          $clustername ="SELECT * FROM `cluster` WHERE `id`=".$data['cluster_id'];
                                          $chcn=mysqli_query($conn,$clustername);
                                          $cnameh=mysqli_fetch_assoc($chcn);
                                          
                                    ?>
                                    <td><?php echo ucfirst($dpidn['owner_name']); ?></td> 
				    <td>Name : <?php echo ucfirst($dpidn['project_name']); ?></td>
                                    <td>Cluster : <?php echo $cnameh['Cluster_head_name']; ?></td>
                                    <td> <?php echo $qcn['name']; ?></td>
                                    <td><?php echo $data['total_annotations']; ?></td>
                                                <td><?php echo $data['missed_annotations']; ?></td>
                                                <td><?php echo $data['incorrect_self']; ?></td>
                                                <td><?php echo $data['incorrect_comp']; ?></td>
                                                <td><?php echo $data['incorrect_others']; ?></td>
                                                <td><?php echo $data['precision']; ?>%</td>
                                                <td><?php echo $data['recall']; ?>%</td>
                                                <td><a href="<?php echo $data['url']; ?>" target="_blank">View</a></td>
                                                <td><?php echo $data['date'] . "<br>" . $data['time']; ?></td>
                                                <td><?php echo $data['status']; ?></td>
                                                <td><?php echo $data['Del_person_id']; ?></td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="restoreRecord(<?php echo $data['id']; ?>)">Restore</button>
                                                </td>
                                </tr>
                          <?php
                      }    
                 
                 
                 
            ?>
            
        </tbody>
    </table>    
    
    <?php
       } else{
                     ?>
                         <center><h3>Not data Found Here...</h3></center>
                     <?php
                 }
    
    ?>
							                     
  
              
					<script>

    function restoreRecord(id) { if (confirm("Are you sure you want to restore this record?")) {
            $.ajax({
                type: "POST",
                url: "Restore/restore_tagger.php",
                data: { id: id },
                dataType: "json", // Expecting a JSON response
                success: function(response) {
                    if (response.status === "success") {
                        $("#row_" + id).fadeOut("slow", function () {
                            showMessage(response.message, "success");
                        });
                    } else {
                        showMessage(response.message, "error");
                    }
                },
                error: function() {
                    showMessage("An unexpected error occurred!", "error");
                }
            });
        }
    }

    function showMessage(message, type) {
        let alertBox = $("<div>")
            .addClass("alert")
            .addClass(type === "success" ? "alert-success" : "alert-danger")
            .text(message)
            .hide()
            .fadeIn("slow");

        $(".content").prepend(alertBox); // Add message to the page

        setTimeout(function () {
            alertBox.fadeOut("slow", function () {
                $(this).remove();
            });
        }, 3000);
    }
</script>         
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
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

