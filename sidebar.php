<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <div class="sidebar-content">
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
<?php
            
                   if($user == 'admin')
                   {
                      ?>
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Setup</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="sub_admin.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Sub Admin</span></a></li>
                <li class="nav-item"><a href="cluster.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Cluster</span></a></li>
                <li class="nav-item"><a href="qc.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC</span></a></li>
                <li class="nav-item"><a href="project_managment.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects</span></a></li>

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">QC Status</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects QC Status</span></a></li>
                <li class="nav-item"><a href="taggers_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project QC</span></a></li>
                <li class="nav-item"><a href="project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Project View</span></a></li>
                <li class="nav-item"><a href="tagger_project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project View</span></a></li>
                <li class="nav-item"><a href="summary_notes_csv_upload.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>upload csv summary/notes</span></a></li>
                <li class="nav-item"><a href="summary_notes_mode_view_delete.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC_stats_new_pipeline</span></a></li>
                <li class="nav-item"><a href="p_q_c_da_i.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Edit Project QC Data</span></a></li>
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Training & Completed Tickets</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="test_t_Q.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Training Queue</span></a></li>
                <li class="nav-item"><a href="dstab_qc_status_ad.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>DS Completed Tickets</span></a></li>
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Analytics</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="qc_analytics/qc_analysis.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Analytics</span></a></li>
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Requests & Messages</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <!-- <li class="nav-item"><a href="request.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Requests</span></a></li> -->
                <li class="nav-item"><a href="Message_query.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Message Query</span></a></li>
                <!-- <li class="nav-item"><a href="send_request.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Send Request</span></a></li> -->
                <li class="nav-item"><a href="message_request.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Send Message Request</span></a></li>
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Restore</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="summary_notes_mode_view_delete_log.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Summary_Notes_deleted_log</span></a></li>
                <li class="nav-item"><a href="restore_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Restore Project QC</span></a></li>
                <li class="nav-item"><a href="restore_project.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Restore Projects</span></a></li>
                <li class="nav-item"><a href="restore_qc.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Restore QC</span></a></li>
                <li class="nav-item"><a href="restore_cluster.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Restore Cluster</span></a></li>
                <li class="nav-item"><a href="restore_taggers_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Restore Taggers Project QC</span></a></li>
                <?php
                   }
                   elseif($user == 'dsuser')
                   {
                       ?>
                       <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Setup</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="project_managment.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects</span></a></li>

                       <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">QC Status</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <!--<li class="nav-item"><a href="ds_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects QC Status</span></a></li>-->
                <li class="nav-item"><a href="project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Project View</span></a></li>
                <li class="nav-item"><a href="tagger_project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project View</span></a></li>
                <li class="nav-item"><a href="summary_notes_csv_upload.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>upload csv summary/notes</span></a></li>
                <li class="nav-item"><a href="summary_notes_mode_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC_stats_new_pipeline</span></a></li>
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Training & Completed Tickets</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="test_t_Q.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Training Queue</span></a></li>
                <li class="nav-item"><a href="dstab_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>DS Completed Tickets</span></a></li>
                
                <!-- <li class="nav-item-header">-->
                <!--    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Analytics</div>-->
                <!--    <i class="ph-dots-three sidebar-resize-show"></i>-->
                <!--</li>-->
                <!--<li class="nav-item"><a href="qc_analytics/qc_analysis.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Analytics</span></a></li>-->

                       
                <?php
                   }
                   elseif($user == 'tagger')
                   {
                       ?>
                       <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">QC Status</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="taggers_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project QC</span></a></li>
                <li class="nav-item"><a href="tagger_project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project View</span></a></li>
                <li class="nav-item"><a href="summary_notes_csv_upload.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>upload csv summary/notes</span></a></li>
                <li class="nav-item"><a href="summary_notes_mode_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC_stats_new_pipeline</span></a></li>
                       
                 <?php
                   }
                       
                   else {
                       ?>
                    <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Setup</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="project_managment.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects</span></a></li>
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">QC Status</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <!-- <li class="nav-item"><a href="summary_notes_csv_upload.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>upload csv summary/notes</span></a></li> -->
                <li class="nav-item"><a href="summary_notes_mode_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC_stats_new_pipeline</span></a></li>
                <li class="nav-item"><a href="project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Project View</span></a></li>
                <li class="nav-item"><a href="tagger_project_qc_view.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project View</span></a></li>
                <li class="nav-item"><a href="taggers_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Taggers Project QC Status</span></a></li>
                <!--<li class="nav-item"><a href="ds_project_qc_status.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Projects QC Status</span></a></li>-->
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Training & Completed Tickets</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item"><a href="cs_training_q.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Training Queue</span></a></li>
                
                <!--<li class="nav-item-header">-->
                <!--    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Analytics</div>-->
                <!--    <i class="ph-dots-three sidebar-resize-show"></i>-->
                <!--</li>-->
                <!--<li class="nav-item"><a href="qc_analytics/qc_analysis.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>QC Analytics</span></a></li>-->
                
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Requests & Messages</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <!-- <li class="nav-item"><a href="send_request.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Send Request</span></a></li> -->
                <li class="nav-item"><a href="message_request.php" class="nav-link"><i class="fa-solid fa-map-pin"></i><span>Send Message Request</span></a></li>
                       
                       
                       <?php
                   }
                ?> 
            
                <li class="nav-item"><a href="logout2.php" class="nav-link"><i class="fa-solid fa-right-from-bracket"></i><span>Sign Out</span></a></li>
            </ul>
        </div>
    </div>
</div>
