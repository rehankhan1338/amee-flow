<section class="content">
    <div class="box">  
 
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteReport();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageReport('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>

        <!-- Toolbar: Search -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i data-feather="search"></i></span>
                    <input type="text" class="af-roles-search-input" id="afGrSearchInput" placeholder="Search reports..." autocomplete="off">
                    <button type="button" class="af-roles-search-clear" id="afGrSearchClear"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <!-- Date Filter -->
                <div class="af-date-filter-wrap" id="afGrDateFilterWrap">
                    <span class="af-date-filter-btn" id="afGrDateFilterBtn" role="button">
                        <i data-feather="calendar"></i>
                        <span class="af-date-filter-label">Last Updated</span>
                        <span class="af-date-filter-clear" id="afGrDateFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-date-filter-dropdown" id="afGrDateFilterDropdown">
                        <div id="afGrDatePicker"></div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Topic Name</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>
                            <th>Last Updated</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($userGeneralReportDataArr as $row){                        
                        ?>
                        <tr data-date="<?php echo date('m/d/Y',$row['createOn']);?>">
                            <td> <input type="checkbox" class="case" id="rIds[]" name="rIds[]" value="<?php echo $row['rId'];?>" /> </td>
                            <td style="font-weight:500;"> <a href="<?php echo base_url().'general_reports/view/'.$row['erId'];?>"> <?php echo $row['topicName']; ?> <i class="fa fa-external-link" aria-hidden="true"></i> </a> </td>
                            <td class="fw600"> <a id="vfbkLnk<?php echo $row['rId'];?>" class="pro_name" onclick="return viewFeedback('<?php echo $row['rId'];?>','<?php echo $shareReportFor;?>');">View</a> &nbsp;<?php echo '('.$row['feedbackCnt'].')';?> </td>
                            <td>
                                <?php $spApprovalDataArr = getApprovalDataArrCh($row['rId'],$shareReportFor);
                                if(count($spApprovalDataArr)>0){
                                    echo '<table class="">';
                                    foreach($spApprovalDataArr as $spApp){
                                        echo '<tr><td class="py-2">';
                                        echo $spApp['swName'].'</td> <td  class="px-2 py-2">';
                                        if($spApp['actionTakenSts']==0){echo '<label class="cscritical spAppSts">Pending</label>';}
                                        if($spApp['actionTakenSts']==1){echo '<label class="cslow spAppSts">Approved</label>';}
                                        if($spApp['actionTakenSts']==2){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="csmedium spAppSts">Approved w/Changes</label>';}
                                        if($spApp['actionTakenSts']==3){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="cshigh spAppSts">Rejected</label>';}
                                        
                                        echo '</td></tr>';
                                    } 
                                    echo '</table>';
                                }?>
                            </td>
                            <td> <?php echo date('m/d/Y, h:i A',$row['createOn']);?></td>                              
                            <td nowrap>                                
                                <a class="btn btn-secondary btn-sm" id="edrole<?php echo $row['rId'];?>" onclick="return manageReport('<?php echo $row['rId'];?>');">Edit</a>
                                <button type="button" class="af-row-delete-btn" title="Delete" onclick="return deleteSingleReport('<?php echo $row['rId'];?>');">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $i++; }?>
                        <tr class="af-roles-no-results" style="display:none;">
                            <td colspan="6">
                                <div style="padding:20px 0;"><i class="fa fa-search" style="font-size:1.5rem;color:#ccc;display:block;margin-bottom:8px;"></i>
                                No matching records found</div>
                            </td>
                        </tr>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 

<?php 
include(APPPATH.'views/Frontend/reports/general_reports/pop-model.php');
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php'); 
?>
</section>
