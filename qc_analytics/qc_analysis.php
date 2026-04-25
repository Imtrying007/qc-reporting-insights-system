<?php

session_start();
$email = $_SESSION["email"];
$user_type=$_SESSION["user_type"];
date_default_timezone_set("Asia/Kolkata");

$date = date("d/m/Y");
$time =  date("H:i a");

if (empty($email)) {
    ?>
    <script>
      window.open('logout.php', '_self');
    </script>
     <?php
}

include('../connection.php');
$query_summary = "SELECT 
    q.name AS qc_name,
    COUNT(*) AS total_entries,
    SUM(CASE WHEN pqs.`precision` > 98 THEN 1 ELSE 0 END) AS above_98,
    SUM(CASE WHEN pqs.`precision` BETWEEN 95 AND 98 THEN 1 ELSE 0 END) AS between_95_98,
    SUM(CASE WHEN pqs.`precision` BETWEEN 90 AND 95 THEN 1 ELSE 0 END) AS between_90_95,
    SUM(CASE WHEN pqs.`precision` BETWEEN 85 AND 90 THEN 1 ELSE 0 END) AS between_85_90,
    SUM(CASE WHEN pqs.`precision` BETWEEN 80 AND 85 THEN 1 ELSE 0 END) AS between_80_85,
    SUM(CASE WHEN pqs.`precision` < 80 THEN 1 ELSE 0 END) AS below_80
FROM project_qc_status pqs
JOIN cluster c ON pqs.cluster_id = c.id
JOIN qc q ON pqs.qc_id = q.id
GROUP BY q.name
ORDER BY q.name;";

$result_summary = mysqli_query($conn, $query_summary);
$data_summary = [];

while ($row = mysqli_fetch_assoc($result_summary)) {
    $row['total'] = $row['total_entries'];
    $qc_name = $row['qc_name'];
    $data_summary[$qc_name] = $row;
}

$query_detailed = "SELECT 
    c.id AS cluster_id,
    c.cluster AS cluster_name,
    c.Cluster_head_name AS cluster_head,
    q.id AS qc_id,
    q.name AS qc_name,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) > 98 THEN 1 ELSE 0 END) AS above_98,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 95 AND 98 THEN 1 ELSE 0 END) AS between_95_98,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 90 AND 95 THEN 1 ELSE 0 END) AS between_90_95,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 85 AND 90 THEN 1 ELSE 0 END) AS between_85_90,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 80 AND 85 THEN 1 ELSE 0 END) AS between_80_85,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) < 80 THEN 1 ELSE 0 END) AS below_80
FROM project_qc_status pqs
JOIN cluster c ON pqs.cluster_id = c.id
JOIN qc q ON pqs.qc_id = q.id
GROUP BY c.id, c.cluster, c.Cluster_head_name, q.id, q.name
ORDER BY c.id, q.id;";

$result_detailed = mysqli_query($conn, $query_detailed);
$data_detailed = [];

while ($row = mysqli_fetch_assoc($result_detailed)) {
    $row['total'] = $row['above_98'] + $row['between_95_98'] + $row['between_90_95'] +
                    $row['between_85_90'] + $row['between_80_85'] + $row['below_80'];
    $qc_name = $row['qc_name'];

    if (!isset($data_detailed[$qc_name])) {
        $data_detailed[$qc_name] = [];
    }
    $data_detailed[$qc_name][] = $row;
}

$query = "SELECT 
    c.id AS cluster_id,
    c.cluster AS cluster_name,
    c.Cluster_head_name AS cluster_head,
    q.id AS qc_id,
    q.name AS qc_name,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) > 98 THEN 1 ELSE 0 END) AS above_98,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 95 AND 98 THEN 1 ELSE 0 END) AS between_95_98,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 90 AND 95 THEN 1 ELSE 0 END) AS between_90_95,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 85 AND 90 THEN 1 ELSE 0 END) AS between_85_90,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) BETWEEN 80 AND 85 THEN 1 ELSE 0 END) AS between_80_85,
    SUM(CASE WHEN CAST(pqs.`precision` AS DECIMAL(5,2)) < 80 THEN 1 ELSE 0 END) AS below_80
FROM project_qc_status pqs
JOIN cluster c ON pqs.cluster_id = c.id
JOIN qc q ON pqs.qc_id = q.id
GROUP BY c.id, c.cluster, c.Cluster_head_name, q.id, q.name
ORDER BY c.id, q.id;";

$result = mysqli_query($conn, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row['total'] = $row['above_98'] + $row['between_95_98'] + $row['between_90_95'] +
                    $row['between_85_90'] + $row['between_80_85'] + $row['below_80'];
    $qc_name = $row['qc_name'];

    if (!isset($data[$qc_name])) {
        $data[$qc_name] = [];
    }
    $data[$qc_name][] = $row;
}
$jsonSummary = json_encode($data_summary);
$jsonDetailed = json_encode($data_detailed);
$jsonData = json_encode($data);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QC Analytics</title> 

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        .chart-container {
            width: 100%;
            max-width: 1000px;
            height: 500px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        canvas {
            max-height: 450px;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- Simple Buttons -->
    <a href="../index.php" class="btn btn-secondary">⬅ Back</a>
    <a href="../project_qc_view.php" class="btn btn-primary float-end">📊 Project QC View</a>
    <a href="../tagger_project_qc_view.php" class="btn btn-danger float-end me-2">⚠️ Taggers Inconsistency View</a>

    <h2 class="text-center my-4">QC Analytics Dashboard</h2>
      <!-- Overall Table Section -->
    <div class="table-container">
        <h4 class="text-center">Overall QC Summary</h4>
        <table id="summaryTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>QC Name</th>
                    <th>>98%</th>
                    <th>95-98%</th>
                    <th>90-95%</th>
                    <th>85-90%</th>
                    <th>80-85%</th>
                    <th><80%</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data_summary as $qc_name => $qc_data) {
                    echo "<tr>
                        <td>{$qc_name}</td>
                        <td>{$qc_data['above_98']}</td>
                        <td>{$qc_data['between_95_98']}</td>
                        <td>{$qc_data['between_90_95']}</td>
                        <td>{$qc_data['between_85_90']}</td>
                        <td>{$qc_data['between_80_85']}</td>
                        <td>{$qc_data['below_80']}</td>
                        <td>{$qc_data['total']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Graphs Section -->
      <h4 class="text-center">QC/Cluster Wise Summary</h4>
    <div id="charts-container" class="row justify-content-center"></div>

    <!-- Dynamic QC-Wise Tables -->
       <h4 class="text-center">QC/Cluster Table Summary</h4>
    <div id="tables-container" class="mt-4"></div>
</div>

<script>
    $(document).ready(function () {
        let data = <?php echo $jsonData; ?>;
        let chartsContainer = document.getElementById("charts-container");
        let tablesContainer = document.getElementById("tables-container");

        Object.keys(data).forEach(qc_name => {
            let chartId = "chart_" + btoa(qc_name).replace(/=/g, "");
            let tableId = "table_" + btoa(qc_name).replace(/=/g, "");

            // Add Chart
            chartsContainer.innerHTML += `
                <div class="col-lg-6 col-md-12">
                    <div class="chart-container">
                        <h4 class="text-center">${qc_name}</h4>
                        <canvas id="${chartId}"></canvas>
                    </div>
                </div>
            `;

            // Add Table
            let tableHTML = `
                <div class="table-container">
                    <h4 class="text-center">${qc_name} Data Table</h4>
                    <table id="${tableId}" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Cluster Head</th>
                                <th>Cluster Name</th>
                                <th>>98%</th>
                                <th>95-98%</th>
                                <th>90-95%</th>
                                <th>85-90%</th>
                                <th>80-85%</th>
                                <th><80%</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>`;

            data[qc_name].forEach(cluster => {
                tableHTML += `
                    <tr>
                        <td>${cluster.cluster_head}</td>
                        <td>${cluster.cluster_name}</td>
                        <td>${cluster.above_98}</td>
                        <td>${cluster.between_95_98}</td>
                        <td>${cluster.between_90_95}</td>
                        <td>${cluster.between_85_90}</td>
                        <td>${cluster.between_80_85}</td>
                        <td>${cluster.below_80}</td>
                        <td>${cluster.total}</td>
                    </tr>`;
            });

            tableHTML += `</tbody></table></div>`;
            tablesContainer.innerHTML += tableHTML;

            // Initialize DataTable
            setTimeout(() => {
                $(`#${tableId}`).DataTable();
            }, 100);

            // Generate Chart
            let clusters = data[qc_name];
            let labels = clusters.map(c => c.cluster_head);
            let datasets = [
                { label: ">98%", data: clusters.map(c => c.above_98), backgroundColor: "green" },
                { label: "95-98%", data: clusters.map(c => c.between_95_98), backgroundColor: "blue" },
                { label: "90-95%", data: clusters.map(c => c.between_90_95), backgroundColor: "orange" },
                { label: "85-90%", data: clusters.map(c => c.between_85_90), backgroundColor: "purple" },
                { label: "80-85%", data: clusters.map(c => c.between_80_85), backgroundColor: "red" },
                { label: "<80%", data: clusters.map(c => c.below_80), backgroundColor: "gray" }
            ];

            setTimeout(() => {
                let ctx = document.getElementById(chartId).getContext("2d");

                new Chart(ctx, {
                    type: "bar",
                    data: { labels: labels, datasets: datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 5 } },
                            x: { title: { display: true, text: "Cluster Head Name" } }
                        }
                    }
                });
            }, 100);
        });
    });
</script>

</body>
</html>
