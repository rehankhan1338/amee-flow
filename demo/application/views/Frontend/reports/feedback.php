<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#export_feedback").click(function(event) {
        	$("#page_feedback").wordExport('feedback_report');
      	});
    });
</script>
<div class="pull-right">
	<a class="btn btn-primary" id="export_feedback" style="padding:3px 10px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>
<div class="clearfix"></div>
<div id="page_feedback"> 
	<div style=" margin-bottom: 20px; text-align: center;">
	    <h2 style="color: #485b79; font-weight:600;"><?php echo $dept_session_details->department_name;?></h2>    
    </div>     

	<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">Feedback</th>
				<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Date</th>
			</tr>
		</thead>
		<tbody>	
		<?php foreach($department_feedback as $feedback){?>            
			<tr>
				<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
					<?php if(isset($feedback->feedback)&& $feedback->feedback!=''){echo $feedback->feedback;}?>
				</td>
				<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
					<?php if(isset($feedback->add_date)&& $feedback->add_date!=''){echo date('m/d/Y h:i A',$feedback->add_date);}?>
				</td>
			</tr>			
		<?php }?>	      
		</tbody>
	</table>
 
</div>