<?php include('head.php');
include('connection.php');
// $id = $_GET['id'];


// session_start();
$email = $_SESSION["email"];
$sql = "SELECT * FROM `admin` WHERE email = '$email'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);
$name = $data['username'];
$user = $data['type'];

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
								
							</h4>
                        </div>
					</div>
                </div>
				<!-- /page header -->
				
				<form method="POST" action="send_request.php">
				    
                				<!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Cluster id</label>
                                    <input type="text" class="form-control" name="cluster_id" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Cluster id">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Project id</label>
                                    <input type="text" class="form-control" name="project_id" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Project id">
                                </div>
                            </div>
                          </div>
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Training Date</label>
                                    <input type="date" class="form-control" name="Training_date" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter training date">
                                 </div>
                            </div>
                            <div class="col-6">
                                 <div class="form-group">
                            <label for="exampleInputPassword1" style="font-size: small;">Status</label>
                            <select id="cars"  name="status" class="form-control">
                              <option value="Pending">Pending</option>
                              <option value="Done">Done</option>
                        
                            </select>
                          </div>
                            </div>
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
							
							 $sql_location="SELECT * FROM `mesage_request` ORDER BY `date` DESC";
                 $runn=mysqli_query($conn,$sql_location);
                 $count=mysqli_num_rows($runn);
                 if($count != '0')
                 {
                     
							?>
							
		
		<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Username <br> Email</th>
                <th>Message</th>
                <th>Date / Time</th>
                <th>Status</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
            
            <?php
            
                
                      $ser='1';
                      while($data=mysqli_fetch_assoc($runn)){
                          ?>
                                <tr id="del_<?php echo $data['id']; ?>"> 
                                    <td>Name : <?php echo ucfirst($data['name']); ?><br> Email : <?php echo $data['email']; ?></td>
                                  
                                  
                                    <td contenteditable="true" data-id="<?php echo $data['id']; ?>" data-column="message" onblur="updateCell(this)"><?php echo ucfirst($data['message']); ?></td>
                                    <td><?php echo $data['date']; ?><br><?php echo $data['time']; ?></td>
                                     <?php
                                         $status=$data['status'];
                                         if($status == 'Done')
                                         {
                                           ?>
                                                <th> <?php echo $data['status']; ?>
                                                    <label class="switch">
                                                      <input type="checkbox" onclick="status('<?php echo $data['id']; ?>')" checked>
                                                      <span class="slider round"></span>
                                                    </label>
                                                </th>
                                           <?php
                                         }else
                                         {
                                           ?>
                                                <th> <?php echo $data['status']; ?>
                                                    <label class="switch">
                                                      <input type="checkbox" onclick="status('<?php echo $data['id']; ?>')">
                                                      <span class="slider round"></span>
                                                    </label>
                                                </th>
                                           <?php
                                         }
                                    
                                    ?>
                                    
                                    <th> 
                                       <a class="btn btn-danger btn-sm" onclick="delete_date('<?php echo $data['id']; ?>')">DELETE</a>
                                    </th>
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
				
				     function status(id){
				          
				           $.ajax({
                                type: "POST",
                                url: "Status/Message_query.php",
                                data: "id=" + id,
                                success: function(data) {
                                  
                                
                                      var x = document.getElementById("snackbar");
                                      x.className = "Done";
                                      setTimeout(function(){ x.className = x.className.replace("Done", ""); }, 1000);
                                      setTimeout(function(){ window.open('Message_query.php','_self'); }, 1500);
                                      
                                  
                                  
                                }
                        }); 
				     }    
				
				     function delete_date(id){
				         
				          let val=confirm("Are you sure ?");
				         
				         if(val==true)
				           {
				         
				         
        				        $.ajax({
                                        type: "POST",
                                        url: "Delete/Message_query.php",
                                        data: "id=" + id,
                                        success: function(data) {
                                          
                                          if(data == '0'){
                                              var x = document.getElementById("danger");
                                              x.className = "show";
                                              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                              setTimeout(function(){ window.open('Message_query.php','_self'); }, 2000);
                                          }else{
                                              var x = document.getElementById("danger");
                                              x.className = "show";
                                              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                              setTimeout(function(){ $('#del_'+id).hide(500); }, 2000);
                                              
                                          }
                                          
                                        }
                                }); 
        				         
				           }
				     }
				     
				     function updateCell(cell) {
                                        const id = cell.getAttribute("data-id"); // Get the row ID
                                        const column = cell.getAttribute("data-column"); // Get the column name
                                        const newValue = cell.innerText.trim(); // Get the updated cell value
                                    
                                        if (!id || !column) {
                                            console.error("Missing ID or column information.");
                                            alert("Error: Missing necessary data for the update.");
                                            return;
                                        }
                                    
                                        // Disable the cell while the update is in progress to prevent further edits
                                        cell.contentEditable = false;
                                    
                                        // Send the updated value to the server via AJAX
                                        $.ajax({
                                            url: "inline_edit/update_cell_msgqry.php", // Backend URL for processing
                                            type: "POST",
                                            data: {
                                                id: id,
                                                column: column,
                                                value: newValue,
                                            },
                                            success: function (response) {
                                                try {
                                                    const result = typeof response === "string" ? JSON.parse(response) : response;
                                                    if (result.success) {
                                                        console.log("Cell updated successfully!");
                                                        //alert("Status updated");
                                                    } else {
                                                        console.error("Update failed:", result.error);
                                                        alert(`Failed to update the database: ${result.error}`);
                                                    }
                                                } catch (e) {
                                                    console.error("Failed to parse response:", e);
                                                    alert("Unexpected response from the server.");
                                                }
                                            },
                                            error: function (xhr, status, error) {
                                                console.error("AJAX error:", status, error);
                                                alert("Error occurred while updating the database. Please check your network connection.");
                                            },
                                            complete: function () {
                                                // Re-enable the cell for editing after the operation
                                                cell.contentEditable = true;
                                            },
                                        });
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

