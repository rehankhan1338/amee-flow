<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />
<script type="text/javascript">
jQuery(function() {
    jQuery('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = jQuery(this).sortable('toArray').toString();
    		// change order in the database using Ajax
    		jQuery.ajax({
                url: '<?php echo base_url();?>assignments_rubrics/set_order_questions',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                	var redirect_url = '<?php echo $actual_link; ?>';  
                	jQuery(location).attr('href',redirect_url);
                	
                }
            });
        }
    }); // fin sortable
});
</script>


<style type="text/css">
	#open_model_assignments_rubrics_setting .modal-dialog {
	    max-width: 800px;
	    width: 800px;
	}
	#open_model_assignments_rubrics_setting .modal-body {
	   padding:15px;
	}
	#open_model_assignments_rubrics_setting .modal-body  h4{line-height:25px;}
	#open_model_assignments_rubrics_setting option{padding:5px;}
	.que_hover:hover{ text-decoration:underline;}

	#open_model_assignments_rubrics_setting .modal-footer h4{line-height:35px; font-size:16px;}
	#open_model_assignments_rubrics_setting .modal-footer h4 span{ border:1px dashed #485b79; padding:2px 5px; color:#485b79; font-weight:600;}
	#new_skip_conditions{margin-top:10px;}
	#open_model_assignments_rubrics_setting  .contenttitle2 { margin: 5px 0; border-bottom: 2px dotted #FB9337;}
</style>

<div id="assignments_rubrics_questions" class="subcontent margin20">
	<div class="col-md-123">
		<div class="contenttitle2 nomargintop">
			<h3> Demographic Questions</h3>
		</div>
		
		<div class="pull-right">				
				<a class="btn btn-default" href="<?php echo base_url();?>department/create/assignments_rubrics/question/add/<?php echo $assignments_rubrics_row->id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>			
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12 instructions"><strong>Note:</strong> Participant first and last name are requested by default.</div>
		<div class="clearfix"></div>
		<ul id="sortable" class="sortable_drag">
		<?php if(count($assignments_rubrics_questions_detail)>0){
			$k=1; foreach($assignments_rubrics_questions_detail as $questions_details){?>		
			
			<li id="<?php echo $questions_details->question_id;?>">
				<span></span>
				<h4>
					<a class="que_hover" onclick="return open_model_assignments_question_description('<?php echo $assignments_rubrics_row->id;?>','<?php echo $questions_details->question_id;?>');"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){ echo 'Q'.$k.'. '.ucfirst($questions_details->question_title);}?> 
					</a>
				</h4>
				<div class="action_btns">
				
	 				<a href="<?php echo base_url();?>department/create/assignments_rubrics/question/edit/<?php echo $questions_details->question_id;?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>
					
					<a  href="<?php echo base_url();?>assignments_rubrics/delete_assignments_rubrics_question?question_id=<?php echo $questions_details->question_id;?>&ar_id=<?php echo $assignments_rubrics_row->id;?>" onclick="return confirm('Are you sure you want to delete this question?');" style="font-size:16px;color:#a94442;"><i class="fa fa-trash"></i></a>
				</div>
			</li>
		<?php $k++;} } ?>
		</ul>
	</div>
</div>


<script type="text/javascript">
function open_model_assignments_question_description(id,question_id){
	$.ajax({url: "<?php echo base_url();?>assignments_rubrics/question_description?ar_id="+id+"&question_id="+question_id, 
		beforeSend: function(){ 
			$('#skip_logic_btn'+question_id).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
		},
		success: function(result){ //alert(result);
			if(result!=''){
				$('#open_model_assignments_rubrics_setting').html(result);
				$('#skip_logic_btn'+question_id).html('<i class="fa fa-cog"></i>');
				jQuery("#open_model_assignments_rubrics_setting").modal('show');
			}
		}
	});	
}
</script>

<div class="modal fade" id="open_model_assignments_rubrics_setting" tabindex="-1" role="dialog"></div>