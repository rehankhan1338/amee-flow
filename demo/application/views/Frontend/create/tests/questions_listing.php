<?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

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
                url: '<?php echo base_url();?>tests/set_order_questions',
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
#open_model_test_setting .modal-dialog {max-width: 800px;width: 800px;}
#open_model_test_setting .modal-body {padding:15px;}
#open_model_test_setting .modal-body  h4{line-height:25px;}
#open_model_test_setting option{padding:5px;}
.que_hover:hover{ text-decoration:underline;}

#open_model_test_setting .modal-footer h4{line-height:35px; font-size:16px;}
#open_model_test_setting .modal-footer h4 span{ border:1px dashed #485b79; padding:2px 5px; color:#485b79; font-weight:600;}
#new_skip_conditions{margin-top:10px;}
#open_model_test_setting  .contenttitle2 { margin: 5px 0; border-bottom: 2px dotted #FB9337;}
</style>

<div id="test_questions" class="subcontent margin20">
	<div class="col-md-123">
		<div class="contenttitle2 nomargintop">
			<h3> Test Questions</h3>			
		</div>	 
		<?php if(count($student_test_complete_detail)>0){?>
		
		<div class="instructions"><strong>Note: </strong> This assessment has participant responses.  You cannot add questions after an assessment has been completed by participants.</div>
		<?php }else{?>
		<div class="pull-right">
	 		<a class="btn btn-default" href="<?php echo base_url();?>department/create/tests/question/add/<?php echo $test_details->test_id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>
		</div>
		<?php } ?>
		<div class="clearfix"></div>
		<ul id="sortable" class="sortable_drag">
		<?php if(count($tests_questions_detail)>0){
			$k=1; foreach($tests_questions_detail as $questions_details){?>		
			<li id="<?php echo $questions_details->question_id;?>">
				<span></span>
				<h4>
				<a class="que_hover" onclick="return open_model_tests_question_description('<?php echo $test_details->test_id;?>','<?php echo $questions_details->question_id;?>');"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){ echo 'Q'.$k.'. '.ucfirst($questions_details->question_title);}?>
				<b>
					<?php echo ' ('.$questions_details->point_value.' Marks)';?>
					<?php //if($questions_details->question_type==1){ echo ' (Multiple Choice)';}?>
					<?php //if($questions_details->question_type==2){ echo ' (Matrix Table)';}?>
					<?php //if($questions_details->question_type==3){ echo ' (Text Area)';}?>
					<?php //if($questions_details->question_type==4){ echo ' (Net Promoter Score)';}?>
				</b>
				</a>
				</h4>
				<?php if(count($student_test_complete_detail)>0){}else{?>
				<div class="action_btns">
					<a href="<?php echo base_url();?>department/create/tests/question/edit/<?php echo $questions_details->question_id;?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>				

					<a href="<?php echo base_url();?>tests/delete_test_question?question_id=<?php echo $questions_details->question_id;?>&test_id=<?php echo $test_details->test_id;?>&tab_id=<?php if(isset($_GET['tab_id'])&& $_GET['tab_id']!=''){echo $_GET['tab_id'];} ?>" onclick="return confirm('Are you sure you want to delete this question?');" style="font-size:16px;color:#a94442;"><i class="fa fa-trash"></i></a>
				</div>
				<?php } ?>
			</li>
		<?php $k++;} } ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
function open_model_tests_question_description(test_id,question_id){
	$.ajax({url: "<?php echo base_url();?>tests/question_description?test_id="+test_id+"&question_id="+question_id, 
		beforeSend: function(){ 
			$('#skip_logic_btn'+question_id).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
		},
		success: function(result){ //alert(result);
			if(result!=''){
				$('#open_model_test_setting').html(result);
				$('#skip_logic_btn'+question_id).html('<i class="fa fa-cog"></i>');
				jQuery("#open_model_test_setting").modal('show');
			}
		}
	});
}
</script>

<div class="modal fade" id="open_model_test_setting" tabindex="-1" role="dialog"></div>