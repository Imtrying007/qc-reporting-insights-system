<?php
session_start();
$email = $_SESSION["email"];

include "../connection.php";

if(isset($_POST['submit_qc'])){

    mysqli_begin_transaction($conn);

    $logs = [];
    $errors = [];

    try {

        // ================= BASIC DATA =================
        $p_id = $_POST['project_id'];
        $p_name = $_POST['project_name'];
        $qc_id = $_POST['qc_id'];
        $sheet_url = $_POST['url'];
        $submitted_date = date('Y-m-d H:i:s');

        // ================= FETCH PROJECT OWNER (p_id_name) =================
        $p_id_name = '';

        $proj_res = mysqli_query($conn, "SELECT owner_name FROM add_project WHERE id='$p_id' LIMIT 1");
        if($proj_res && mysqli_num_rows($proj_res) > 0){
            $proj_row = mysqli_fetch_assoc($proj_res);
            $p_id_name = $proj_row['owner_name']; // ✅ pd109 type
        } else {
            throw new Exception("Invalid Project ID");
        }

        // ================= FETCH QC NAME =================
        $qc_name = '';

        $qc_res = mysqli_query($conn, "SELECT name FROM qc WHERE id='$qc_id' LIMIT 1");
        if($qc_res && mysqli_num_rows($qc_res) > 0){
            $qc_row = mysqli_fetch_assoc($qc_res);
            $qc_name = $qc_row['name'];
        } else {
            throw new Exception("Invalid QC ID");
        }

        // ================= DUPLICATE QC CHECK =================
        $check = mysqli_query($conn, "
            SELECT 1 FROM qc_summary 
            WHERE p_id='$p_id' AND qc_id='$qc_id' 
            LIMIT 1
        ");

        if(mysqli_num_rows($check) > 0){
            throw new Exception("QC already uploaded for this Project + QC Cycle");
        }

        $logs[] = "QC Upload started for Project: $p_name ($p_id_name) | QC: $qc_name";

        // ================= SUMMARY CSV =================
        if(!file_exists($_FILES['summary_csv']['tmp_name'])){
            throw new Exception("Summary CSV missing");
        }

        $logs[] = "Reading Summary CSV...";

        $handle = fopen($_FILES['summary_csv']['tmp_name'], "r");
        fgetcsv($handle);

        $rowCount = 0;

        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

            if(empty(array_filter($data))) continue;

            if(count($data) < 18){
                $errors[] = "Invalid summary row skipped";
                continue;
            }

            $data = array_map('trim', $data);

            $category_id   = $data[0];
            $category_name = $data[1];

            // OVERALL handling
            if(strtoupper($category_name) == 'OVERALL'){
                $is_overall = 1;
                $category_id = 0;
            } else {
                $is_overall = 0;
            }

            // DUPLICATE ROW CHECK
            $safe_category = mysqli_real_escape_string($conn, $category_name);

            $exists = mysqli_query($conn, "
                SELECT 1 FROM qc_summary 
                WHERE p_id='$p_id' 
                AND qc_id='$qc_id' 
                AND category_name='$safe_category'
                LIMIT 1
            ");

            if(mysqli_num_rows($exists) > 0){
                $errors[] = "Duplicate summary skipped: $category_name";
                continue;
            }
          // Insert using  prepare statement
                $sql = "INSERT INTO qc_summary (
                p_id, p_id_name, p_name, qc_id, qc_name, sheet_url, submitted_date, submitted_by,
                category_id, category_name, total_image_count, self_count, comp_count, others_count,
                sticker_count, incorrect_self, incorrect_comp, incorrect_others, SPI, CPI, NPD,
                total_count, total_incorrect, accuracy, Ai_grade, recommendation, is_overall
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param(
                "sssissssisiiiiiiiidddiidssi",
                $p_id, $p_id_name, $p_name, $qc_id, $qc_name, $sheet_url, $submitted_date, $email,
                $category_id, $category_name, $data[2], $data[3], $data[4], $data[5],
                $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12],
                $data[13], $data[14], $data[15], $data[16], $data[17], $is_overall
            );

            if (!$stmt->execute()) {
                throw new Exception("Summary Insert Error: " . $stmt->error);
            }

            $stmt->close();

            $rowCount++;
        }

        fclose($handle);
        $logs[] = "Summary rows inserted: $rowCount";

        // ================= NOTES CSV =================
        if(!file_exists($_FILES['notes_csv']['tmp_name'])){
            throw new Exception("Notes CSV missing");
        }

        $logs[] = "Reading Notes CSV...";

        $handle = fopen($_FILES['notes_csv']['tmp_name'], "r");
        fgetcsv($handle);

        $rowCount = 0;

        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

            if(empty(array_filter($data))) continue;

            if(count($data) < 8){
                $errors[] = "Invalid notes row skipped";
                continue;
            }

            $data = array_map('trim', $data);
            $safe_category_id = mysqli_real_escape_string($conn, $data[0]);
            $safe_category = mysqli_real_escape_string($conn, $data[1]);
            $safe_actual   = mysqli_real_escape_string($conn, $data[3]);
            $safe_pred     = mysqli_real_escape_string($conn, $data[4]);
            $safe_qc_class_id= mysqli_real_escape_string($conn, $data[2]);
            $safe_class_id= mysqli_real_escape_string($conn, $data[5]);

            // DUPLICATE CHECK
            $exists = mysqli_query($conn, "
                SELECT 1 FROM qc_notes 
                WHERE p_id='$p_id' 
                AND qc_id='$qc_id' 
                AND category_id= '$safe_category_id'
                AND qc_class_id='$safe_qc_class_id'
                AND class_id='$safe_class_id'
                LIMIT 1
            ");

            if(mysqli_num_rows($exists) > 0){
                $errors[] = "Duplicate notes skipped: ".$data[1];
                continue;
            }

            // INSERT
            // Prepare the statement
            $stmt = $conn->prepare("INSERT INTO qc_notes 
                (p_id, p_id_name, p_name, qc_id, qc_name, sheet_url,refer_sheet_url, submitted_date, submitted_by, 
                category_id, category_name, actual, predicted,qc_class_id,class_id, count, total_count, category_ratio,actual_count)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

            // Check for errors in prepare
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Bind parameters (s = string, i = integer, d = double/decimal)
            $stmt->bind_param(
                "sssssssssssssssiidi",
                $p_id,
                $p_id_name,
                $p_name,
                $qc_id,
                $qc_name,
                $sheet_url,
                $data[9],     // file_path<-> refer_image
                $submitted_date,
                $email,
                $data[0],      // category_id
                $data[1],      // category_name
                $data[3],      // actual
                $data[4],      // predicted
                $data[2],      // qc_class_id
                $data[5],      // class_id
                $data[6],      // count
                $data[7],      // total_count
                $data[8],       // category_ratio
                $data[11]      // actual count

            );

            // Execute
            if (!$stmt->execute()) {
                throw new Exception("Notes Insert Error: " . $stmt->error);
            }

            // Close statement
            $stmt->close();
            $rowCount++;
        }

        fclose($handle);
        $logs[] = "Notes rows inserted: $rowCount";

        // ================= FINAL =================
        $logs[] = (count($errors) > 0)
            ? "Completed with warnings"
            : "All data inserted successfully";

        mysqli_commit($conn);

        // ================= OUTPUT =================
        echo "<div style='background:#000;color:#0f0;padding:15px;font-family:monospace;'>";

        foreach($logs as $log){
            echo "✔ $log<br>";
        }

        if(count($errors) > 0){
            echo "<br><span style='color:yellow;'>⚠ WARNINGS:</span><br>";
            foreach($errors as $err){
                echo "- $err<br>";
            }
        }

        echo "<br><span style='color:lightgreen;'>✅ SUCCESS</span>";
        echo "</div>";

    } catch (Exception $e) {

        mysqli_rollback($conn);

        echo "<div style='background:#000;color:red;padding:15px;font-family:monospace;'>";

        echo "❌ FAILED: ".$e->getMessage()."<br><br>";

        echo "LOG TRACE:<br>";
        foreach($logs as $log){
            echo "- $log<br>";
        }

        echo "</div>";
    }
}
?>