<?php include('head.php');
include('connection.php');
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
								<span style="font-size: 16px;" class="fw-normal">
								    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Project</a></span>
							</h4>
                        </div>
					</div>
                </div>
				<!-- /page header -->
				
				<form method="POST" id="addProjectForm">
				    
                				<!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                          <div class="form-group">
                            <label for="exampleInputEmail1" style="font-size: small;">Project id</label>
                            <input type="text" class="form-control" name="project_id" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Project id">
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputEmail1" style="font-size: small;">Project Name</label>
                            <input type="text" class="form-control" name="project_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Project Name">
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputPassword1" style="font-size: small;">Status</label>
                            <select id="cars"  name="status" class="form-control">
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                              <!--<option value="Aborted">Aborted</option>-->
                              <!--<option value="Hold">Hold</option>-->
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputPassword1" style="font-size: small;">Cluster</label>
                            <select id="cars"  name="cluster" class="form-control">
                              
                              		<?php
							
        							 $sql_location="SELECT * FROM `cluster`";
                                     $runn=mysqli_query($conn,$sql_location);
                                     $count=mysqli_num_rows($runn);
                                     if($count != '0')
                                     {
                                           while($data=mysqli_fetch_assoc($runn)){
                							?>
                							       <option value="<?php echo $data['id']; ?>"><?php echo $data['cluster']; ?>(<?php echo $data['Cluster_head_name']; ?>)</option>
                             				<?php
        							 }
                                     }
        							?>
                              
                             
                            </select>
                          </div>
                        
                        
                      </div>
                      <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Add Project" name="submission"></input>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                </form>
                
                
 

				<!-- Content area -->
				<div class="content">
                    
				    <div class="row">
						<div class="col-xl-12">
                                
						   	
							<?php
							
							 $sql_location="SELECT * FROM `add_project` ORDER BY `add_project`.`status` ASC, `add_project`.`owner_name` ASC;";
                 $runn=mysqli_query($conn,$sql_location);
                 $count=mysqli_num_rows($runn);
                 if($count != '0')
                 {
                     
							?>
							
							             <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Ser No.</th>
                <th>Project Id</th>
                <th>Project name</th>
                <th>Cluster</th>
                <th>Date / Time</th>
                <th>Status</th>
                <th>Mode</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            
                
                      $ser='1';
                      while($data=mysqli_fetch_assoc($runn)){
                          ?>
                                <tr id="del_<?php echo $data['id']; ?>">
                                    <td><?php echo $ser++; ?></td>
                                    <td><?php echo ucfirst($data['owner_name']); ?></td>
                                    <td><?php echo $data['project_name']; ?></td>
                                    <td>
                                    <?php $cluster=$data['cluster']; 
                                    
                                     $sql_location1="SELECT * FROM `cluster` where `id`='$cluster'";
                                     $runn1=mysqli_query($conn,$sql_location1);
                                     $data1=mysqli_fetch_assoc($runn1);
                					  
                					 echo $data1['cluster']; 
                					  
                                    ?>
                                    ( <?php echo $data1['Cluster_head_name']; ?> )
                                    </td>
                                    <td><?php echo ucfirst($data['date']); ?><br><?php echo ucfirst($data['time']); ?></td>
                                    
                                    <!--Status-->
                                    <th> 
                                        <span id="status-text-<?php echo $data['id']; ?>">
                                            <?php echo $data['status']; ?>
                                        </span><br>
                                    
                                        <label class="switch">
                                            <input type="checkbox"
                                                   <?php echo ($data['status'] == 'Active') ? 'checked' : ''; ?>
                                                   onchange="updateStatus('<?php echo $data['id']; ?>', this)">
                                            <span class="slider round"></span>
                                        </label>
                                    </th>

                                    
                                    <!--MODE-->
                                    <th>
                                        <span id="mode-text-<?php echo $data['id']; ?>">
                                            <?php echo $data['mode']; ?>
                                        </span><br>
                                    
                                        <label class="switch">
                                            <input type="checkbox"
                                                   <?php echo ($data['mode'] == 'Auto_S2C') ? 'checked' : ''; ?>
                                                   onchange="updateMode('<?php echo $data['id']; ?>', this)">
                                            <span class="slider round"></span>
                                        </label>
                                    </th>

                                     <th> 
                                       <a class="btn btn-danger btn-sm" onclick="delete_date('<?php echo $data['id']; ?>')">DELETE</a>
                                    </th>
                                    <div id="alertBox" class="alert text-center" style="display:none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); width: 300px;"></div>
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
				       function updateMode(id, checkbox) {

                            let newMode = checkbox.checked ? 'Auto_S2C' : 'Manual';
                        
                            $.ajax({
                                type: "POST",
                                url: "Status/mode.php",
                                data: {
                                    id: id,
                                    mode: newMode
                                },
                                success: function(response) {
                        
                                    // Update mode text live
                                    document.getElementById("mode-text-" + id).innerText = newMode;
                        
                                    // Snackbar
                                    var x = document.getElementById("snackbar");
                                    x.innerText = "Mode updated to " + newMode;
                                    x.className = "show";
                                    setTimeout(() => x.className = x.className.replace("show", ""), 1500);
                                },
                                error: function () {
                                    // rollback on failure
                                    checkbox.checked = !checkbox.checked;
                                    alert("Mode update failed");
                                }
                            });
                        }
    
        				function updateStatus(id, checkbox) {
                                
                                    let newStatus = checkbox.checked ? 'Active' : 'Inactive';
                                
                                    $.ajax({
                                        type: "POST",
                                        url: "Status/project_managment.php",
                                        data: {
                                            id: id,
                                            status: newStatus
                                        },
                                        success: function(response) {
                                
                                            // Update text without refresh
                                            document.getElementById("status-text-" + id).innerText = newStatus;
                                
                                            // Snackbar feedback
                                            var x = document.getElementById("snackbar");
                                            x.innerText = "Status updated to " + newStatus;
                                            x.className = "show";
                                            setTimeout(() => x.className = x.className.replace("show", ""), 1500);
                                        },
                                        error: function() {
                                            // rollback toggle if error
                                            checkbox.checked = !checkbox.checked;
                                            alert("Status update failed");
                                        }
                                    });
                                }
        // below status function is old version uncomment for retrack
        				function status(id){
        				          
        				           $.ajax({
                                        type: "POST",
                                        url: "Status/project_managment.php",
                                        data: "id=" + id,
                                        success: function(data) {
                                          
                                        
                                              var x = document.getElementById("snackbar");
                                              x.className = "show";
                                              setTimeout(function(){ x.className = x.className.replace("Active", ""); }, 1000);
                                              setTimeout(function(){ window.open('project_managment.php','_self'); }, 1500);
                                          
                                          
                                        }
                                }); 
        				     }
                    	function delete_date(id) {
                            if (confirm("Are you sure you want to delete this record?")) {
                                $.ajax({
                                    type: "POST",
                                    url: "Delete/project_managment.php",
                                    data: { id: id },
                                    success: function(response) {
                                        if (response.trim() === "0") {
                                            showAlert("danger", "Failed to delete the record!");
                                            setTimeout(() => window.location.reload(), 2000);
                                        } else {
                                            showAlert("success", "Record deleted successfully!");
                                            setTimeout(() => $("#del_" + id).fadeOut(500), 2000);
                                        }
                                    },
                                    error: function() {
                                        showAlert("danger", "An error occurred. Please try again.");
                                    }
                                });
                            }
                        }
        
                 // Function to display alerts dynamically
                        function showAlert(type, message) {
                            let alertBox = $("#alertBox");
                            alertBox.removeClass("alert-success alert-danger").addClass("alert-" + type).text(message).fadeIn();
                        
                            setTimeout(() => {
                                alertBox.fadeOut();
                            }, 2000);
                        }

				     	
				</script>	                   
  
                            </div>

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

    $("#addProjectForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "ajax/add_project.php",
        data: $(this).serialize(),
        success: function(response){

            Swal.fire({
                icon: 'success',
                title: 'Added Project Successfully',
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000
            });

            $("#exampleModal").modal('hide');

            setTimeout(() => {
                location.reload();
            }, 800);
        },
        error: function(){
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong'
            });
        }
    });
});
</script>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

