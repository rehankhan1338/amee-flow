<?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$res = get_survey_complete_sts($survey_details->survey_id);
?>

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
                url: '<?php echo base_url();?>survey/set_order_questions',
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
#open_model_survey_setting .modal-dialog {
    max-width: 800px;
    width: 800px;
}
#open_model_survey_setting .modal-body {
   padding:15px;
}
#open_model_survey_setting .modal-body  h4{line-height:25px;}
#open_model_survey_setting option{padding:5px;}
.que_hover:hover{ text-decoration:underline;}

#open_model_survey_setting .modal-footer h4{line-height:35px; font-size:16px;}
#open_model_survey_setting .modal-footer h4 span{ border:1px dashed #485b79; padding:2px 5px; color:#485b79; font-weight:600;}
#new_skip_conditions{margin-top:10px;}
#open_model_survey_setting  .contenttitle2 { margin: 5px 0; border-bottom: 2px dotted #FB9337;}
</style>

<div id="survey_questions" class="subcontent margin20">
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Survey Questions</h3>
	</div>
	
<?php //$status_of_survey = check_status_of_survey_started_h($survey_details->survey_id);
if($res==0){	
?>
	<div class="pull-right">
 		<a class="btn btn-default" href="<?php echo base_url();?>department/create/survey/question/add/<?php echo $survey_details->survey_id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>	
 		<a class="btn btn-warning" style="padding:3px 7px; font-size:15px; margin-left:5px;" href="<?php echo base_url();?>department/create/survey/templates/<?php echo $survey_details->survey_id;?>"><i class="fa fa-university" aria-hidden="true"></i> Survey Templates </a>		
	</div>
<?php } ?>

	<div class="clearfix"></div>
	<div class="instructions" style="font-size:16px;"><strong>INSTRUCTIONS: </strong> To add skip logic, click directly on the survey question,. You can only use skip logic when you configure one question per page. </div>
	<div class="clearfix"></div>
	<ul id="sortable" class="sortable_drag">
	<?php if(count($survey_questions_details)>0){
		$k=1; foreach($survey_questions_details as $questions_details){?>		
		
		<li id="<?php echo $questions_details->question_id;?>">
			<?php $question_skip_logic_count = check_question_skip_logic_count_h($survey_details->survey_id);?>
			<?php if($question_skip_logic_count==0){?><span></span><?php } ?>
			<h4>
				<a class="que_hover" onclick="return open_model_survey_setting('<?php echo $survey_details->survey_id;?>','<?php echo $questions_details->question_id;?>');"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){
				
				$star_skip_logics = get_star_skip_logics_h($questions_details->question_id);
				
				if(isset($star_skip_logics) && $star_skip_logics>0){ ?>
				
				<i class="fa fa-star" aria-hidden="true" style="color:#485b79;"></i>
				
				<?php } echo 'Q'.$k.'. '.ucfirst($questions_details->question_title);}?>
					<b>
						<?php if($questions_details->question_type==1){ echo ' (Multiple Choice)';}?>
						<?php if($questions_details->question_type==2){ echo ' (Matrix Table)';}?>
						<?php if($questions_details->question_type==3){ echo ' (Text Area)';}?>
						<?php if($questions_details->question_type==4){ echo ' (Net Promoter Score)';}?>
					</b>
				</a>
			</h4>
			
			<div class="action_btns">
				<a style="font-size:16px;color:#f0ad4e;" onclick="return open_model_survey_setting('<?php echo $survey_details->survey_id;?>','<?php echo $questions_details->question_id;?>');" id="skip_logic_btn<?php echo $questions_details->question_id;?>"><i class="fa fa-cog"></i></a>
				<?php  if($res==0){?><a href="<?php echo base_url();?>department/create/survey/question/edit/<?php echo $questions_details->question_id;?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>
				<a  href="<?php echo base_url();?>survey/delete_survey_question?question_id=<?php echo $questions_details->question_id;?>&survey_id=<?php echo $survey_details->survey_id;?>" onclick="return confirm('Are you sure you want to delete this question?');" style="font-size:16px;color:#a94442;"><i class="fa fa-trash"></i></a><?php } ?>
			</div>
			
		</li>
	<?php $k++;} } ?>
	</ul>
</div>
</div>
<script type="text/javascript">
function open_model_survey_setting(survey_id,question_id){

	$.ajax({url: "<?php echo base_url();?>survey/skip_logic_apply_survey_content?survey_id="+survey_id+"&question_id="+question_id, 
		beforeSend: function(){ 
			$('#skip_logic_btn'+question_id).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
		},
		success: function(result){ //alert(result);
			if(result!=''){
				$('#open_model_survey_setting').html(result);
				$('#skip_logic_btn'+question_id).html('<i class="fa fa-cog"></i>');
				jQuery("#open_model_survey_setting").modal('show');
			}
		}
	});
	
}

function add_skip_logic(survey_id,question_id,question_type,question_priority){

	$.ajax({url: "<?php echo base_url();?>survey/add_skip_logic?survey_id="+survey_id+"&question_id="+question_id+"&question_type="+question_type+"&question_priority="+question_priority, 
		beforeSend: function(){ 
			$('#new_skip_conditions').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
		},
		success: function(result){ //alert(result);
			if(result!=''){
				$('#new_skip_conditions').html(result);
			}
		}
	});
}

function edit_skip_logic_condition(survey_id,skip_id,question_id,question_type,question_priority){

	$.ajax({url: "<?php echo base_url();?>survey/edit_skip_logic_condition?survey_id="+survey_id+"&skip_id="+skip_id+"&question_id="+question_id+"&question_type="+question_type+"&question_priority="+question_priority, 
		beforeSend: function(){ 
			$('#h_edit_skip_logic'+skip_id).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
		},
		success: function(result){// alert(result);
			if(result!=''){
				$('#h_edit_skip_logic'+skip_id).html(result);
			}
		}
	});
}
</script>
<div class="modal fade" id="open_model_survey_setting" tabindex="-1" role="dialog">

</div>