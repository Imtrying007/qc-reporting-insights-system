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
            $tagger=$_POST['taggers'];
            $project_grade=$_POST['Project_Grade'];
            $T_S_P=$_POST['T_S_P'];
            $T_O_P=$_POST['T_O_P'];
            $T_C_P=$_POST['T_C_P'];
            $G_A_C=$_POST['G_A_C'];
            $G_B_C=$_POST['G_B_C'];
            $G_C_C=$_POST['G_C_C'];
            $G_D_C=$_POST['G_D_C'];
            
            $runn=false;
            $xchk=(int)$total_annotations  + (int)$missed_annotations;
            $date = date('Y-m-d');
            if( $total_annotations!="" && $missed_annotations!="" &&  $incorrect_self !="" && $incorrect_comp!="" && $incorrect_others!="" && $project_id !="" && $xchk!=0 )		    
		    {
		    $sql_query="INSERT INTO `project_qc_status`(`project_id`, `project_name`, `cluster_id`, `qc_id`, `total_annotations`, `missed_annotations`, `incorrect_self`, `incorrect_comp`, `incorrect_others`, `precision`, `recall`, `url`, `time`, `date`, `status`,`taggers`, `T_self_pres`, `T_others_pres`, `T_comp_pres`, 
            `Grade_A_Category`, `Grade_B_Category`, `Grade_C_Category`, `Grade_D_Category`, `Proj_Grade`)
		         VALUES ('$project_id','$project_name','$cluster_id','$qc_id','$total_annotations','$missed_annotations','$incorrect_self','$incorrect_comp','$incorrect_others','$precision','$recall','$url','$time','$date','SHOW','$tagger','$T_S_P', '$T_O_P', '$T_C_P', '$G_A_C', '$G_B_C', '$G_C_C', '$G_D_C', '$project_grade')";
		    
            echo "&nbsp";
             
            $runn=mysqli_query($conn,$sql_query);
            
		    }
		   
            
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
						title: 'Project Status Added Successfully'
					});
                      
					 setTimeout("window.open('project_qc_status.php', '_self');", 2000);
				  </script>
				<?php
			}
			
			else{
			    ?>
			    <script>
			    alert("failed");
			    setTimeout("window.open('project_qc_status.php', '_self');", 1000);
			    
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Project QC Stats</h5>
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
        							
                							 $sql_location3="SELECT * FROM `add_project` ORDER BY `add_project`.`owner_name` ASC";
                                             $runn3=mysqli_query($conn,$sql_location3);
                                                   while($data3=mysqli_fetch_assoc($runn3)){
                        							?>
                        							       <option value="<?php echo $data3['id']; ?>"><?php echo $data3['owner_name']; ?>(<?php echo $data3['project_name']; ?>)</option>
                                     				<?php
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
                                    <label for="exampleInputEmail1" style="font-size: small;">Cluster</label>
                                      
                                      <select id="cars"  name="cluster_id" class="form-control">
                              
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">QC_Iteration</label>
                                    
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
                                    <label for="exampleInputEmail1" style="font-size: small;" >Total annotations*</label>
                                    <input type="number" class="form-control" name="total_annotations" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter total annotations">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;" >Missed annotations*</label>
                                    <input type="number" class="form-control" name="missed_annotations" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Missed annotations">
                                </div>
                            </div>
                          </div>
                           <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;"  >Total Self Present*</label>
                                    <input type="number" class="form-control" name="T_S_P" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Total others Present</label>
                                    <input type="text" class="form-control" name="T_O_P" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                            </div>
                         <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;"  >Total Comp Present*</label>
                                    <input type="number" class="form-control" name="T_C_P" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Grade_A_categories</label>
                                    <input type="number" class="form-control" name="G_A_C" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;"  >Grade_B_categories</label>
                                    <input type="number" class="form-control" name="G_B_C" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Grade_C_categories</label>
                                    <input type="number" class="form-control" name="G_C_C" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;"  >Grade_D_categories</label>
                                    <input type="number" class="form-control" name="G_D_C" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Project_Grade</label>
                                    <input type="text" class="form-control" name="Project_Grade" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                            </div>
                        
                          <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;" >Incorrect self*</label>
                                    <input type="number" class="form-control" name="incorrect_self" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect self">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Incorrect comp*</label>
                                    <input type="number" class="form-control" name="incorrect_comp" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect comp">
                                </div>
                            </div>
                          </div>
                          
                            <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;"  >Incorrect Others*</label>
                                    <input type="number" class="form-control" name="incorrect_others" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Incorrect Others">
                                 </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Precision</label>
                                    <input type="text" class="form-control" name="precision" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Precision">
                                </div>
                            </div>
                          </div>
                        
                         <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Recall</label>
                                    <input type="text" class="form-control" name="recall" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Recall">
                                 </div>
                            </div>
                          <div class="col-6">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-size: small;">Tagger's No</label>
                                    <input type="number" class="form-control" name="taggers" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter No. of Taggers Assigned">
                                 </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="exampleInputPassword1" style="font-size: small;" >URL*</label>
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
							
							 $sql_location="SELECT * FROM `project_qc_status` ORDER BY `date` DESC";
                 $runn=mysqli_query($conn,$sql_location);
                 $count=mysqli_num_rows($runn);
                 if($count != '0')
                 {
                     
							?>
							
		
		<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Project id <br> Name <br> Taggers : </th>
                <th>Cluster <br> QC</th>
                <th>Total_annotations<br>Missed_annotations</th>
                <th>Incorrect self,comp and others</th>
                <th>Precision <br> Recall</th>
                <th>URL</th>
                <th>Status</th>
                <th>Date,Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            
                      
                      $ser='1';
                      while($data=mysqli_fetch_assoc($runn)){
                          
                          // Set default values if keys are missing or empty
                            $t   = !empty($data['total_annotations']) ? $data['total_annotations'] : 0;
                            $m   = !empty($data['missed_annotations']) ? $data['missed_annotations'] : 0;
                            $s   = !empty($data['incorrect_self']) ? $data['incorrect_self'] : 0;
                            $t_s = !empty($data['T_self_pres']) ? $data['T_self_pres'] : 0;
                            $c   = !empty($data['incorrect_comp']) ? $data['incorrect_comp'] : 0;
                            $t_c = !empty($data['T_comp_pres']) ? $data['T_comp_pres'] : 0;
                            $o   = !empty($data['incorrect_others']) ? $data['incorrect_others'] : 0;
                            $t_o = !empty($data['T_others_pres']) ? $data['T_others_pres'] : 0;

                            // Safe calculation of $p
                            if (!empty($t) && $t != 0) {
                                $ca = $t - ($s + $c + $o);
                                $p = $ca / $t;
                            } else {
                                $p = 0; // or 0 or fallback value
                            }
                            
                            // Safe calculation of $r
                            if (!empty($t) && isset($m) && ($t + $m) != 0) {
                                $r = $ca / ($t + $m);
                            } else {
                                $r = 0; // or 0 or fallback value
                            }
                          if (!empty($t_s) && $t_s != 0) {
                                $spi = ($t_s - $s) / $t_s;
                            } else {
                                $spi = 0; // or 0 or any fallback value you prefer
                            }
                            $npd = (!empty($t) && $t != 0) ? ($t_o / $t) : 0;
                          
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
                                    <td>ID : <?php echo ucfirst($dpidn['owner_name']); ?><br> Name : <?php echo ucfirst($dpidn['project_name']); ?><br> Taggers: <?php echo ucfirst($data['taggers']); ?></td>
                                    <td>Cluster : <?php echo $cnameh['Cluster_head_name']; ?><br> <?php echo $qcn['name']; ?></td>
                                    <td>Total : <?php echo $data['total_annotations']; ?><br>Missed : <?php echo $data['missed_annotations']; ?><br>T_Self_present : <?php echo $data['T_self_pres']; ?><br>T_others_present : <?php echo $data['T_others_pres']; ?><br>T_Comp_present : <?php echo $data['T_comp_pres']; ?></td>
                                    <td>Self : <?php echo ucfirst($data['incorrect_self']); ?><br>Comp : <?php echo ucfirst($data['incorrect_comp']); ?><br>
                                    Others : <?php echo ucfirst($data['incorrect_others']); ?></td>
                                    <td>Precision : <?php echo round(($p * 100),3); ?> % <br>Recall : <?php echo round(($r * 100),3); ?> %<br>SPI: <?php echo round(($spi * 100),3); ?> %<br>NPD: <?php echo round(($npd * 100),3); ?> %</td>
                                    <td><a href="<?php echo $data['url']; ?>" target="_blank">URL</a></td>
                                     
                                     <!--status-->
                                     <th>
                                        <span id="project-qc-text-<?php echo $data['id']; ?>">
                                            <?php echo $data['status']; ?>
                                        </span>
                                    
                                        <label class="switch">
                                            <input type="checkbox"
                                                   <?php echo ($data['status'] == 'SHOW') ? 'checked' : ''; ?>
                                                   onchange="updateProjectQCStatus('<?php echo $data['id']; ?>', this)">
                                            <span class="slider round"></span>
                                        </label>
                                    </th>
                                    
                                    <td><?php echo $data['date']; ?><br><?php echo $data['time']; ?></td>
                                              <th id="del_<?php echo $data['id']; ?>">
                                                    <button class="btn btn-danger btn-sm" onclick="deleteData(<?php echo $data['id']; ?>)">DELETE</button>
                                              </th>

                                    <!-- Alert Message -->
                                    <div id="alert-message" class="alert alert-danger" style="display: none;"></div>
                                    
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
				
				
				     function updateProjectQCStatus(id, checkbox) {

                                let newStatus = checkbox.checked ? 'SHOW' : 'HIDE';
                            
                                $.ajax({
                                    type: "POST",
                                    url: "Status/project_qc_status.php",
                                    data: {
                                        id: id,
                                        status: newStatus
                                    },
                                    success: function(response) {
                            
                                        // Update status text instantly
                                        document.getElementById("project-qc-text-" + id).innerText = newStatus;
                            
                                        // Snackbar feedback
                                        var x = document.getElementById("snackbar");
                                        x.innerText = "Status updated to " + newStatus;
                                        x.className = "show";
                                        setTimeout(() => x.className = x.className.replace("show", ""), 1500);
                                    },
                                    error: function () {
                                        // rollback if failed
                                        checkbox.checked = !checkbox.checked;
                                        alert("Update failed");
                                    }
                                });
                            }
    
				
				    
				     function deleteData(id) {
                                if (!confirm("Are you sure?")) return;
                            
                                $.post("Delete/project_qc_status.php", { id: id }, function(response) {
                                    let alertBox = $("#alert-message");
                            
                                    if (response === "error_no_session") {
                                        alertBox.text("Session expired! Please log in again.")
                                                .fadeIn().delay(3000).fadeOut();
                                        return;
                                    }
                            
                                    alertBox.text(response === '0' ? "Deletion failed!" : "Record deleted successfully.")
                                            .fadeIn().delay(2000).fadeOut();
                            
                                    if (response !== '0') {
                                        $("#del_" + id).fadeOut(500);
                                    } else {
                                        setTimeout(() => window.location.reload(), 2000);
                                    }
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

