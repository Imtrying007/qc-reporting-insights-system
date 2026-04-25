<?php include('head.php');
include('connection.php');
$email = $_SESSION["email"];
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
								    <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">qc_mode_file_upload_summary_notes_operation</a></span>
							</h4>
                        </div>
					</div>
                </div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">
                    
				    <div class="row">
						<div class="col-xl-12">
                             
							<!-- work on form and csv extraction logic -->

                            <form id="qcForm" enctype="multipart/form-data">

                                <h3>Upload QC Data</h3>

                                <!-- Project -->
                                <label>Project</label><br>
                                <select name="project_id" id="project_id" required>
                                    <option disabled selected>Select Project</option>
                                    <?php
                                    $res = mysqli_query($conn,"SELECT * FROM add_project ORDER BY add_project.owner_name ASC");
                                    while($row = mysqli_fetch_assoc($res)){
                                    ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['owner_name'] ?> (<?= $row['project_name'] ?>)
                                    </option>
                                    <?php } ?>
                                </select><br><br>

                                <!-- Project Name -->
                                <label>Project Name</label><br>
                                <input type="text" name="project_name" id="project_name" readonly required><br><br>

                                <!-- Cluster -->
                                <label>Cluster</label><br>
                                <select name="cluster_id" required>
                                    <option disabled selected>Select Cluster</option>
                                    <?php
                                    $res = mysqli_query($conn,"SELECT * FROM cluster");
                                    while($row = mysqli_fetch_assoc($res)){
                                    ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['cluster'] ?> (<?= $row['Cluster_head_name'] ?>)
                                    </option>
                                    <?php } ?>
                                </select><br><br>

                                <!-- QC -->
                                <label>QC Cycle</label><br>
                                <select name="qc_id" required>
                                    <option disabled selected>Select QC Cycle</option>
                                    <?php
                                    $res = mysqli_query($conn,"SELECT * FROM qc");
                                    while($row = mysqli_fetch_assoc($res)){
                                    ?>
                                    <option value="<?= $row['id'] ?>">
                                        <?= $row['name'] ?>
                                    </option>
                                    <?php } ?>
                                </select><br><br>

                                <!-- URL -->
                                <label>Sheet URL</label><br>
                                <textarea name="url" required></textarea><br><br>

                                <!-- Files -->
                                <label>Summary CSV</label><br>
                                <input type="file" name="summary_csv" accept=".csv" required><br><br>

                                <label>Notes CSV</label><br>
                                <input type="file" name="notes_csv" accept=".csv" required><br><br>

                                <button type="submit" id="submitBtn">Upload</button>

                            </form>

                            <!-- Progress UI -->
                            <div id="progress" style="display:none; width:100%; background:#eee; margin-top:10px;">
                                <div id="bar" style="width:0%; height:20px; background:green;"></div>
                            </div>

                            <p id="percent">0%</p>
                            <div id="result"></div>

           
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

<!-- JS for Project Name Autofill -->

// Fetch project name when project changes
document.getElementById("project_id").addEventListener("change", function(){

    let id = this.value;

    fetch("new_pipeline/get_project.php?id=" + id)
    .then(res => {
        if (!res.ok) throw new Error("Network error");
        return res.text();
    })
    .then(data => {
        document.getElementById("project_name").value = data.trim();
    })
    .catch(err => {
        console.error("Error:", err);
    });

});


// Submit form with progress bar
document.getElementById("qcForm").addEventListener("submit", function(e){

    e.preventDefault();

    const formData = new FormData(this);
    formData.append("submit_qc", "1");

    const xhr = new XMLHttpRequest();

    const progress = document.getElementById("progress");
    const bar = document.getElementById("bar");
    const percent = document.getElementById("percent");
    const result = document.getElementById("result");
    const btn = document.getElementById("submitBtn");

    // Reset UI
    progress.style.display = "block";
    bar.style.width = "0%";
    percent.innerText = "0%";
    result.innerHTML = "";
    btn.disabled = true;

    xhr.open("POST", "new_pipeline/upload_qc.php", true);

    // Upload progress
    xhr.upload.onprogress = function(e){
        if(e.lengthComputable){
            let p = Math.round((e.loaded / e.total) * 100);
            bar.style.width = p + "%";
            percent.innerText = p + "%";
        }
    };

    // Success response
    xhr.onload = function(){
        btn.disabled = false;

        if(xhr.status === 200){
            percent.innerText = "Done";
            result.innerHTML = xhr.responseText;
        } else {
            percent.innerText = "Error";
            result.innerHTML = "<span style='color:red'>Upload failed</span>";
        }
    };

    // Error handling
    xhr.onerror = function(){
        btn.disabled = false;
        percent.innerText = "Error";
        result.innerHTML = "<span style='color:red'>Network error</span>";
    };

    xhr.send(formData);

});


</script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

