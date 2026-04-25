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
							<h4 style="font-size: 18px;" class="page-title mb-0">
								<span style="font-size: 16px;" class="fw-normal">
								    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">EDIT Project Qc Status </a></span>
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
							
							 $sql_location="SELECT * FROM `project_qc_status` ORDER BY `date` DESC";
                 $runn=mysqli_query($conn,$sql_location);
                 $count=mysqli_num_rows($runn);
                 if($count != '0')
                 {
                     
							?>
							
		
		<table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>Project ID</th>
            <th>Project Name</th>
            <th>Cluster ID</th>
            <th>QC ID</th>
            <th>Total Annotations</th>
            <th>Missed Annotations</th>
            <th>Incorrect Self</th>
            <th>Incorrect Comp</th>
            <th>Incorrect Others</th>
            <th>Precision</th>
            <th>Recall</th>
            <th>URL</th>
            <th>Time</th>
            <th>Date</th>
            <th>Status</th>
            <th>Taggers</th>
            <th>T_Self_Pres</th>
            <th>T_Others_Pres</th>
            <th>T_Comp_Pres</th>
            <th>Grade A Categories</th>
            <th>Grade B Categories</th>
            <th>Grade C Categories</th>
            <th>Grade D Categories</th>
            <th>Project Grade</th>
        </tr>

        </thead>
          <tbody>
        <?php
        $editable_columns = [
            'project_name', 'time', 'date', 'status', 'taggers',
            'T_self_pres', 'T_others_pres', 'T_comp_pres',
            'Grade_A_Category', 'Grade_B_Category', 'Grade_C_Category', 'Grade_D_Category',
            'Proj_Grade' // must match exactly
        ];

        
        $sql_location = "SELECT * FROM project_qc_status ORDER BY STR_TO_DATE(date, '%d/%m/%Y') DESC";
        $runn = mysqli_query($conn, $sql_location);
        
        while ($data = mysqli_fetch_assoc($runn)) {
            echo "<tr>";
            $rowId = $data['id']; // Capture ID once per row
        
            foreach ($data as $column => $value) {
                if ($column == 'id') {
                    continue; // Skip displaying ID
                }
        
                if ($column == 'url') {
                    echo "<td><a href='" . htmlspecialchars($value) . "' target='_blank'>Link</a></td>";
                } elseif (in_array($column, $editable_columns)) {
                    echo "<td contenteditable='true'
                            onBlur=\"saveData(this, '{$column}', '{$rowId}')\"
                            data-column='{$column}' 
                            data-id='{$rowId}'>" . htmlspecialchars($value) . "</td>";
                } else {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
            }
        
            echo "</tr>";
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
function saveData(editableObj, column, id) {
    const value = editableObj.innerText.trim();

    // Send update via AJAX
    fetch('inline_edit/up_qc_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${encodeURIComponent(id)}&column=${encodeURIComponent(column)}&value=${encodeURIComponent(value)}`
    })
    .then(response => response.text())
    .then(data => {
        if (data !== "success") {
            alert("Error updating data: " + data);
        }
    })
    .catch(error => {
        alert("AJAX request failed: " + error);
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

