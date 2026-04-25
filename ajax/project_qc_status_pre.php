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
          
		    $project_id=$_POST['project_id']; 
		    $project_name=$_POST['project_name']; 
		    $cluster_id=$_POST['cluster_id']; 
		    $qc_id=$_POST['qc_id']; 
            $total_annotations=$_POST['total_annotations']; 
            $missed_annotations=$_POST['missed_annotations']; 
            $incorrect_self=$_POST['incorrect_self']; 
            $incorrect_comp=$_POST['incorrect_comp']; 
            $incorrect_others=$_POST['incorrect_others']; 
            $precision=$_POST['precision']; 
            $recall=$_POST['recall']; 
            $url=$_POST['url']; 
            
            		    
		    $sql_query="INSERT INTO `project_qc_status`(`project_id`, `project_name`, `cluster_id`, `qc_id`, `total_annotations`, `missed_annotations`, `incorrect_self`, `incorrect_comp`, `incorrect_others`, `precision`, `recall`, `url`, `time`, `date`, `status`)
		         VALUES ('$project_id','$project_name','$cluster_id','$qc_id','$total_annotations','$missed_annotations','$incorrect_self','$incorrect_comp','$incorrect_others','$precision','$recall',
		         '$url','$time','$date','SHOW')";
            
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
						title: 'Add Project Status in Successfully'
					});
                      
					 setTimeout("window.open('project_qc_status.php', '_self');", 2000);
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
								<span style="font-size: 16px;" class="fw-normal">
								    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Project Qc Status </a></span>
							</h4>
                        </div>
					</div>
                </div>
				<!-- /page header -->
				
				<form method="POST" action="project_qc_status.php">
				    
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
                        
                            <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Project id</label>
                                      <select id="cars"  name="project_id" class="form-control" onChange="getState(this.value);">
                              
                                            <option disabled selected>Select project id</option>
                                      		<?php
        							
                							 $sql_location3="SELECT * FROM `add_project`";
                                             $runn3=mysqli_query($conn,$sql_location3);
                                             $count3=mysqli_num_rows($runn);
                                             if($count3 != '0')
                                             {
                                                   while($data3=mysqli_fetch_assoc($runn3)){
                        							?>
                        							       <option value="<?php echo $data3['id']; ?>"><?php echo $data3['owner_name']; ?></option>
                                     				<?php
                							 }
                                             }
                                             
                							?>
                                     </select>
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Project Name</label>
                                    <input type="text" class="form-control" name="project_name" id="project_name" disabled aria-describedby="emailHelp" placeholder="Enter Project Name">
                                </div>
                            </div>
                          </div>
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Cluster id</label>
                                      
                                      <select id="cars"  name="cluster_id" class="form-control">
                              
                                      		<?php
        							
                							 $sql_location="SELECT * FROM `cluster`";
                                             $runn=mysqli_query($conn,$sql_location);
                                             $count=mysqli_num_rows($runn);
                                             if($count != '0')
                                             {
                                                   while($data=mysqli_fetch_assoc($runn)){
                        							?>
                        							       <option value="<?php echo $data['id']; ?>"><?php echo $data['cluster']; ?></option>
                                     				<?php
                							 }
                                             }
                                             
                							?>
                                     </select>
                                
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">QC id</label>
                                    
                                       <select id="cars"  name="qc_id" class="form-control">
                              
                                      		<?php
        							
                							 $sql_location2="SELECT * FROM `qc`";
                                             $runn2=mysqli_query($conn,$sql_location2);
                                             $count2=mysqli_num_rows($runn2);
                                             if($count2 != '0')
                                             {
                                                   while($data2=mysqli_fetch_assoc($runn2)){
                        							?>
                        							       <option value="<?php echo $data2['id']; ?>"><?php echo $data2['name']; ?></option>
                                     				<?php
                							 }
                                             }
                                             
                							?>
                                     </select>
                                     
                                </div>
                            </div>
                          </div>
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Total annotations</label>
                                    <input type="text" class="form-control num1 key" name="total_annotations" aria-describedby="emailHelp" placeholder="Enter total annotations">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Missed annotations</label>
                                    <input type="text" class="form-control num5 key" name="missed_annotations" aria-describedby="emailHelp" placeholder="Enter Missed annotations">
                                </div>
                            </div>
                          </div>
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Incorrect self</label>
                                    <input type="text" class="form-control num2 key" name="incorrect_self" aria-describedby="emailHelp" placeholder="Enter Incorrect self">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Incorrect comp</label>
                                    <input type="text" class="form-control num3 key" name="incorrect_comp" aria-describedby="emailHelp" placeholder="Enter Incorrect comp">
                                </div>
                            </div>
                          </div>
                          
                            <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Incorrect Others</label>
                                    <input type="text" class="form-control num4 key" name="incorrect_others" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Precision</label>
                                    <input type="text" class="form-control sum" name="precision" disabled aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                          </div>
                        
                         <div class="row">
                            <div class="col-12">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Recall</label>
                                    <input type="text" class="form-control recall" name="recall" disabled id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Recall">
                                 </div>
                            </div>
                          
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputPassword1" style="font-size: small;">URL</label>
                            <textarea type="text" class="form-control" name="url" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter URL"></textarea>
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
							
							 $sql_location="SELECT * FROM `project_qc_status`";
                 $runn=mysqli_query($conn,$sql_location);
                 $count=mysqli_num_rows($runn);
                 if($count != '0')
                 {
                     
							?>
							
		
		<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Project id <br> Name</th>
                <th>Cluster <br> QC</th>
                <th>Total_annotations<br>Missed_annotations</th>
                <th>Incorrect self,comp and others</th>
                <th>Precision <br> Recall</th>
                <th>URL</th>
                <th>Date,Time</th>
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
                                    <td>ID : <?php echo ucfirst($data['project_id']); ?><br> Name : <?php echo ucfirst($data['project_name']); ?></td>
                                    <td>Cluster id : <?php echo $data['cluster_id']; ?><br>Qc : <?php echo $data['qc_id']; ?></td>
                                    <td>Total : <?php echo $data['total_annotations']; ?><br>Missed : <?php echo $data['missed_annotations']; ?></td>
                                    <td>Self : <?php echo ucfirst($data['incorrect_self']); ?><br>Comp : <?php echo ucfirst($data['incorrect_self']); ?><br>
                                    Others : <?php echo ucfirst($data['incorrect_self']); ?></td>
                                    <td>Precision : <?php echo ucfirst($data['precision']); ?><br>Recall : <?php echo ucfirst($data['recall']); ?></td>
                                    <td><a href="<?php echo $data['url']; ?>" target="_blank">URL</a></td>
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
                                    
                                    <td><?php echo $data['date']; ?><br><?php echo $data['time']; ?></td>
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
				
				     function getState(val) {
				        
				        
				        
                    	$.ajax({
                    		type: "POST",
                    		url: "Status/get-state-ep.php",
                    		data:'country_id='+val,
                    		success: function(data){
                    		    document.getElementById("project_name").value = data;
                    		}
                    	});
                    	
                    }
				
				
				     function status(id){
				          
				           $.ajax({
                                type: "POST",
                                url: "Status/project_qc_status.php",
                                data: "id=" + id,
                                success: function(data) {
                                  
                                
                                      var x = document.getElementById("snackbar");
                                      x.className = "show";
                                      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                      
                                  
                                  
                                }
                        }); 
				     }    
				
				     function delete_date(id){
				         
				         
				        $.ajax({
                                type: "POST",
                                url: "Delete/project_qc_status.php",
                                data: "id=" + id,
                                success: function(data) {
                                  
                                  if(data == '0'){
                                      var x = document.getElementById("danger");
                                      x.className = "show";
                                      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                      setTimeout(function(){ window.open('sub_admin.php','_self'); }, 2000);
                                  }else{
                                      var x = document.getElementById("danger");
                                      x.className = "show";
                                      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                      setTimeout(function(){ $('#del_'+id).hide(500); }, 2000);
                                      
                                  }
                                  
                                }
                        }); 
				         
				        
				     }
				     
				     
				     
				    $(document).ready(function(){
				        
                        function calc(){
                        
                        var $num1=Number($(".num1").val());
                        var $num2=Number($(".num2").val());
                        var $num3=Number($(".num3").val());
                        var $num4=Number($(".num4").val());
                        var $num5=Number($(".num5").val());
                        
                        
                        var $suu=$num1-($num2+$num3+$num4);
                        var $suu2= $(".sum").val($suu/$num1);
                        
                        var $recall =($suu/($num1+$num5));
                        
                        var $precise = $recall.toPrecision(4); //"6.123"
                        var $result = parseFloat($precise);
                        
                        var $recall =$(".recall").val($result);
                        
                            
                        }
                     
                        $(".key").keyup(function(){
                          calc();
                        });
                        
                    });
                    
				     
				     	
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

