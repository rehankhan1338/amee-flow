<style>
.contentwrapper{padding:0 10px 20px}
.timeline{position:relative;margin:0 0 30px 0;padding:0;list-style:none}
.timeline:before{content:'';position:absolute;top:0;bottom:0;width:4px;background:#ddd;left:31px;margin:0;border-radius:2px}
.timeline>li{position:relative;margin-right:10px;margin-bottom:15px}
.timeline>li:before,.timeline>li:after{content:" ";display:table}
.timeline>li:after{clear:both}
.timeline>li>.timeline-item{-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);border-radius:3px;margin-top:0;background:#fff;color:#444;margin-left:60px;margin-right:15px;padding:0;position:relative}
.timeline>li>.timeline-item>.time{color:#999;float:right;padding:10px;font-size:12px}
.timeline>li>.timeline-item>.timeline-header{margin:0;color:#333;border-bottom:1px solid #f4f4f4;padding:10px 15px;font-size:16px;line-height:1.1}
.timeline>li>.timeline-item>.timeline-header>a{font-weight:600}
.timeline>li>.timeline-item>.timeline-body,.timeline>li>.timeline-item>.timeline-footer{padding:10px}
.timeline>li>.fa,.timeline>li>.glyphicon,.timeline>li>.ion{width:30px;height:30px;font-size:15px;line-height:30px;position:absolute;color:#666;background:#d2d6de;border-radius:50%;text-align:center;left:18px;top:0}
.timeline>.time-label>span{font-weight:600;padding:5px;display:inline-block;background-color:#fff;border-radius:4px}
.timeline-inverse>li>.timeline-item{background:#f0f0f0;border:1px solid #ddd;-webkit-box-shadow:none;box-shadow:none}
.timeline-inverse>li>.timeline-item>.timeline-header{border-bottom-color:#ddd}

.snapshot_page{margin:5px 0;}
.snapshot_page_title { background: #485b79;padding: 5px 15px; letter-spacing:0.2px; font-size: 16px;  color: #f6e4a5; border-radius: 5px; font-weight: 600;}
.snapshot_page .timeline > li > .timeline-item {-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);box-shadow: 0 1px 1px #f5f5f5;border-radius: 3px;margin-top: 15px;background: #f5f5f5;color: #333;margin-left: 60px;margin-right: 15px;padding: 0;position: relative;}
.snapshot_page .timeline-header p{margin:0px;line-height:25px; padding-bottom:5px; padding-top:5px;} 
.snapshot_page .timeline-header ul, .snapshot_page .timeline-header ol{list-style-position: inside;}
.snapshot_page .timeline-header ul li, .snapshot_page .timeline-header ol li{ padding:5px 15px;}

.snapshot_page .timeline-header b, .snapshot_page .timeline-header strong{ font-weight:600;}

#myDeptAnlaysisModel .modal-body{ padding:10px 15px 15px 15px;} 
#myDeptAnlaysisModel .modal-dialog { max-width:650px; width:650px;}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ padding:6px;}
.w100{width:100%}
</style>
<div class="box snapshot_page">
	
	<div class=" pull-right">
		<!--<a class="btn btn-default" onclick="return sendReport();" style="padding:3px 15px; margin-right:5px; font-size:15px;">Send Report</a>-->
		<?php if(count($myDeptReportingData)>0){?> <a class="btn btn-primary" onclick="return manageMyDeptAnlaysis();" style="padding:3px 15px; font-size:15px;">Manage Report Option</a><?php } ?>
		<a class="btn btn-default" href="<?php echo base_url().'department/analyze';?>" style="padding:3px 15px; margin-left:5px; font-size:15px;"><i class="fa fa-long-arrow-left"></i> Back to Report List</a>
	</div>	
	
<div class="col-md-12">
	<?php if(count($myDeptReportingData)>0){?>
 	<ul class="timeline">
 		<?php foreach($myDeptReportingData as $reportDetails){?>
		<li>
			<label class="snapshot_page_title"><?php $fMas = filter_array_chk($optionsMasterArr,$reportDetails['anlaysisType'],'id'); echo $fMas[0]['title'];?></label>
				<div class="timeline-item">
				<div class="timeline-header"><?php echo $reportDetails['reportDesc'];?></div>
			</div>
		</li>
 		<?php } ?> 
	</ul>
	<?php }else{ ?>
		<div align="center">
			<p>&nbsp;</p>
			<h3><i>No option has been created.</i></h3>
			<p style="font-size:18px;">please click the button Create Reporting Option for <strong><?php echo ucwords($deptReportDetails->reportTitle.' - '.$deptReportDetails->reportYear);?></strong> to start.</p>
			<a class="btn btn-default" onclick="return manageMyDeptAnlaysis();" style="padding:4px 30px; font-size:16px;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Create Reporting Option</a>
		</div>
	<?php } ?>
</div>
</div>

<div class="modal fade" id="myDeptAnlaysisModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong><?php echo $deptReportDetails->reportTitle.' - '.$deptReportDetails->reportYear.' Analysis Reporting';?></strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>   
			<div class="modal-body">
				<?php if(count($myDeptReportingData)>0){?>
					<a class="btn btn-default" onclick="return popCreateReport();" style="padding:3px 15px; margin-right:5px; font-size:15px; margin-bottom:10px;"><i class="fa fa-plus"></i> &nbsp;Create Report Option</a>
					<a class="btn btn-default" id="prioritySetBtn" onclick="return setOptionsOrder();" style="padding:3px 15px; font-size:15px; margin-bottom:10px;"><i class="fa fa-sort-amount-asc"></i> &nbsp;Set Priority Order</a>
				<?php } ?>
				<form method="post" id="anlaysisFrm" class="" action="analyze/save_my_reporting">
					<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
					<input type="hidden" id="h_reportId" name="h_reportId" value="<?php echo $deptReportDetails->reportId;?>" />
					<input type="hidden" id="h_action_sts" name="h_action_sts" value="0" />
					<input type="hidden" id="h_anlaysisType" name="h_anlaysisType" value="0" />
					<div id="resMsg"></div>
					<div class="form-group" id="anlyTypeFld" style="display:<?php if(count($myDeptReportingData)>0){echo 'none';}else{echo 'block';}?>;">
						<label style="font-weight:600;">Analysis Type *</label>
						<select class="form-control" id="anlaysisType" name="anlaysisType" onchange="return getTypeDetails(this.value);">
							<option value="">Select....</option>
							<?php foreach($optionsMasterArr as $master){?>
							<option value="<?php echo $master['id'];?>"><?php echo $master['title'];?></option>
							<?php } ?>
						</select>	
					 </div>
					 <div id="placeholderReport"></div>	
					 					 
				</form>
					<?php if(count($myDeptReportingData)>0){?>
					<form method="post" id="priorityFrm" class="" action="<?php echo base_url();?>analyze/setPriority">
					<input type="hidden" id="h_encryptReportId" name="h_encryptReportId" value="<?php echo $deptReportDetails->encryptReportId;?>" />
					<table class="table table-striped" id="reportingTbl" style="font-size:15px; margin-bottom:0; ">
					 	<thead>
							<tr>
								<th width="3%">#</th>
								<th>Analysis Type</th>
								<th>Last Modifdication</th>
								<th width="10%">Priority</th>
								<th width="12%" style="text-align:right;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $lp=1;foreach($myDeptReportingData as $reportDetails){?>
								<tr>
									<td><?php echo $lp;?></td>
									<td style="font-weight:600;"><?php $fMas = filter_array_chk($optionsMasterArr,$reportDetails['anlaysisType'],'id'); echo $fMas[0]['title'];?></td>
									<td><?php echo date('d M Y, h:i A',$reportDetails['lastModiTime']);?></td>
									<td>
										<input type="hidden" value="<?php echo $reportDetails['id'];?>" id="optionIds[]" name="optionIds[]" />
										<select class="form-control" id="optionId_<?php echo $reportDetails['id'];?>" name="optionId_<?php echo $reportDetails['id'];?>" style="height: 30px; padding: 0px 5px;">
											<?php for($pri=1;$pri<=count($myDeptReportingData);$pri++){?>
											<option value="<?php echo $pri;?>" <?php if($reportDetails['priority']==$pri){?> selected="selected"<?php } ?>><?php echo $pri;?></option>
											<?php } ?>
										</select>
									</td>
									<td style="text-align:right;">
										<a title="Edit" id="editLnk<?php echo $reportDetails['id'];?>" style="font-size:17px;" onclick="return editReporting('<?php echo $reportDetails['id'];?>','<?php echo $reportDetails['anlaysisType'];?>');"> <i class="fa fa-pencil-square-o"></i> </a>
										<a title="Delete" id="deletingLnk_<?php echo $reportDetails['id'];?>" style="padding-left:5px; padding-right:5px; font-size:17px;" onclick="return deleteReportOption('<?php echo $reportDetails['id'];?>');"> <i class="fa fa-trash-o"></i> </a>
									</td>
								</tr>
							<?php $lp++;} ?>
						</tbody>
					 </table>
					 </form>
					 <?php } ?>
				<div class="clearfix"></div>			 
			</div>
    	</div>
	</div>
</div>
<script>
function setOptionsOrder(){
	jQuery('#prioritySetBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
	$( "#priorityFrm" ).submit();
}
function deleteReportOption(id){
	if(id!=""){		
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
			jQuery.ajax({
				type: "POST",
				url: '<?php echo base_url();?>analyze/deleteReportOption?id='+id,
				beforeSend: function(){
					jQuery('#deletingLnk_'+id).html('<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						window.location = '<?php echo base_url().'analyze/view/'.$deptReportDetails->encryptReportId;?>';
					}
				}
			});	
 		}		 
 	}
}
function sendReport(){

}
function cancelEditAction(){
	jQuery('#placeholderReport').html('');
	jQuery('#reportingTbl').show();
	<?php if(count($myDeptReportingData)>0){?>jQuery('#anlyTypeFld').hide();<?php } ?>	
}
function editReporting(id,anlaysisType){
	jQuery.ajax({
		type: "POST",
		url: '<?php echo base_url();?>analyze/ajaxEditReportingDetails?id='+id,
		beforeSend: function(){
			jQuery('#h_action_sts').val('1');
			jQuery('#h_anlaysisType').val(anlaysisType);
			jQuery('#editLnk'+id).html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			jQuery('#placeholderReport').html(result);
			jQuery('#editLnk'+id).html('<i class="fa fa-pencil-square-o"></i>');	
			jQuery('#reportingTbl').hide();				
		}
	});		
}
function getTypeDetails(val){
	if(val!=''){
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url();?>analyze/getTypeDetails?id='+val,
			beforeSend: function(){
				jQuery('#placeholderReport').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				jQuery('#placeholderReport').html(result);					
			}
		});	
	}
}
function popCreateReport(){
	jQuery('#h_action_sts').val('0');
	jQuery('#h_anlaysisType').val('0');
	jQuery('#anlyTypeFld').show();	
	jQuery('#anlaysisType').val('');
	jQuery('#placeholderReport').html('');
	jQuery('#reportingTbl').hide();		
}
function manageMyDeptAnlaysis(){
	jQuery('#h_action_sts').val('0');
	jQuery('#h_anlaysisType').val('0');
	jQuery('#anlaysisType').val('');
	jQuery('#placeholderReport').html('');	
	<?php if(count($myDeptReportingData)>0){?>jQuery('#anlyTypeFld').hide();<?php } ?>	
	jQuery('#reportingTbl').show();	
	jQuery("#myDeptAnlaysisModel").modal('show');	
}
jQuery(function () {
	jQuery('#anlaysisFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#anlaysisFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#saveBtn').html('Saving <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'analyze/view/<?php echo $deptReportDetails->encryptReportId;?>';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#saveBtn').html('Save!');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#saveBtn').html('Save!');
				}
			});		
			return false;
		}
	});
});
</script>
