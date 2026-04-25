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

                
<?php 
    
    
      if(isset($_POST['submission'])){
          
		    $owner_name=$_POST['owner_name']; 
		   
		    $sql_query="INSERT INTO `qc`(`name`, `status`)
		                         VALUES ('$owner_name','SHOW')";
            
            echo "&nbsp";
             
            $runn=mysqli_query($conn,$sql_query);
            
            if($runn == true){
				?>
                  <script>

					var toastMixin = Swal.mixin({
						toast: true,
						icon: 'success',
						title: 'General Title',
						animation: false,
						position: 'top-right',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						didOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					});

					toastMixin.fire({
						animation: true,
						title: 'Added Successfully'
					});
                      
					 setTimeout("window.open('qc.php', '_self');", 2000);
				  </script>
				<?php
			}
	  }
	  
	  
?>

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
								<span style="font-size: 16px;" class="fw-normal"><b> QC :  </b> <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
								    QC
								</a></span>
							</h4>
                        </div>
					</div>
                </div>
				<!-- /page header -->
				
				<form method="POST" action="qc.php">
				    
                				<!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add QC</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                                                             
                          <div class="form-group">
                            <label for="exampleInputEmail1" style="font-size: small;">QC Name : </label>
                            <input type="text" class="form-control" name="owner_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter QC Name">
                          </div>
                     
                        
                      </div>
                      <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Save" name="submission"></input>
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
							
							 $sql_location="SELECT * FROM `qc`";
                             $runn=mysqli_query($conn,$sql_location);
                             $count=mysqli_num_rows($runn);
                             if($count != '0')
                             {
                     
							?>
							
		
		<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Ser No.</th>
                <th>Name</th>
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
                                    <td><?php echo $ser++; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                     <?php
                                         $status=$data['status'];
                                         if($status == 'SHOW')
                                         {
                                           ?>
                                                <th> 
                                                    <label class="switch">
                                                      <input type="checkbox"  onclick="status('<?php echo $data['id']; ?>')" checked>
                                                      <span class="slider round"></span>
                                                    </label>
                                                </th>
                                           <?php
                                         }else
                                         {
                                           ?>
                                                <th> 
                                                    <label class="switch">
                                                      <input type="checkbox"  onclick="status('<?php echo $data['id']; ?>')">
                                                      <span class="slider round"></span>
                                                    </label>
                                                </th>
                                           <?php
                                         }
                                    
                                    ?>
                                    <th> 
                                       <a class="btn btn-danger btn-sm" onclick="delete_date('<?php echo $data['id']; ?>')">DELETE</a>
                                    </th>
                                    <div id="alertBox" class="alert" style="display: none;"></div>
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
                                url: "Status/qc.php",
                                data: "id=" + id,
                                success: function(data) {
                                  
                                
                                      var x = document.getElementById("snackbar");
                                      x.className = "show";
                                      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                      
                                  
                                  
                                }
                        }); 
				     }    
				
				     function delete_date(id) {
                    if (!confirm("Are you sure you want to delete this record?")) {
                        return; // Exit if user cancels
                    }
                
                    $.ajax({
                        type: "POST",
                        url: "Delete/qc.php",
                        data: { id: id },
                        success: function(response) {
                            response = response.trim();
                
                            if (response === "0") {
                                showAlert("danger", "Failed to delete record!");
                                setTimeout(() => window.location.href = 'sub_admin.php', 2000);
                            } else {
                                showAlert("success", "Record deleted successfully!");
                                setTimeout(() => $("#del_" + id).fadeOut(500), 1000);
                            }
                        },
                        error: function() {
                            showAlert("danger", "An error occurred. Please try again.");
                        }
                    });
                }

                // Function to show alerts dynamically
                function showAlert(type, message) {
                    let alertBox = $("#alertBox"); // Make sure your HTML has an alert box with id="alertBox"
                    alertBox.removeClass("alert-success alert-danger alert-warning")
                            .addClass("alert-" + type)
                            .text(message)
                            .fadeIn();
                
                    setTimeout(() => alertBox.fadeOut(), 2000);
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

