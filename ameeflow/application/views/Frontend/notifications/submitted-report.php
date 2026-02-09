<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/frontend/custom.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo base_url();?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" /> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="<?php echo base_url();?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<style>
	.header {
	background-color: #eee;
	-webkit-box-shadow: 0 4px 4px -2px #dedede;
	-moz-box-shadow: 0 4px 4px -2px #dedede;
	box-shadow: 0 4px 4px -2px #dedede; 
	}
	</style>
	<script>
	$(function(){ 
		$('[data-bs-toggle="tooltip"]').tooltip({ html: true });
	});
	</script>
</head>
<body class="">
	<div class="header">
		<div class="container">
			<div class="row ">
				<div class="col-md-6 my-3 pt-1">
					<h4>Hi, <?php echo $sharedWith['swName'];?></h4>
				</div>
				<div class="col-md-6 my-3">
<?php 
if($sharedWith['submitFor']==1){
$btnTxt = 'Leave Feedback';
if($sharedWith['actionTakenSts']==0){?>
	<button class="btn btn-primary pull-right" style="font-size:15px; font-weight:500; padding:5px 20px;" id="popOpenBtn" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','1');"><?php echo $btnTxt;?></button>
	<?php } }else{
$btnTxt = 'Reject';
if($sharedWith['actionTakenSts']==0){
?>
<div class="pull-right">
	<button class="btn btn-success " style="font-size:15px; font-weight:500; padding:5px 20px;" id="approveBtn" <?php if($sharedWith['liveSts']==1){?> onclick="return approveReport('<?php echo $sharedWith['enwithShareId'];?>');" <?php } ?>>Approve</button>
	<button class="btn btn-warning " style="font-size:15px; font-weight:500; padding:5px 20px; margin:0 5px;" id="popOpenBtn" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','2');">Approve w/Changes</button>
	<button class="btn btn-danger " style="font-size:15px; font-weight:500; padding:5px 20px;" id="popOpenBtn" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','3');">Reject</button>					
</div>
<?php }else{ 
	if($sharedWith['actionTakenSts']==1){
		$stsText = 'Approved';
		$stsClass = 'btn-success';
	}else if($sharedWith['actionTakenSts']==2){
		$stsText = 'Approved w/Changes';
		$stsClass = 'btn-warning';
	}else if($sharedWith['actionTakenSts']==3){
		$stsText = 'Rejected';
		$stsClass = 'btn-danger';
	}
	?>
	<div class="pull-right">
		<button data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $sharedWith['reason'];?>" type="button" class="btn <?php echo $stsClass;?>" style="font-size:15px; font-weight:500; padding:5px 20px;"><?php echo $stsText;?></button>					
	</div>
<?php } } ?>
					
					
					
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<?php if($sharedWith['submitFor']==1 && $sharedWith['actionTakenSts']==1){?>
			<div class="row mb-0 mt-3">
				<div class="col-12" style="background:#f4f4f4; border-radius:10px; padding:10px 20px 0px 20px;">
					<h5>Your feedback below has been successfully submitted</h5>
					<?php echo $sharedWith['reason'];?>
				</div>
			</div>
		<?php } ?>
		<div class="row mb-5">
			<?php 
			if($sharedWith['reportFor']==1){
				include(APPPATH.'views/Frontend/reports/sampling_plan/result-sec.php'); 
			}else if($sharedWith['reportFor']==2){
				include(APPPATH.'views/Frontend/reports/loads_report/result-sec.php'); 
			}else if($sharedWith['reportFor']==3){
				include(APPPATH.'views/Frontend/reports/general_reports/result-sec.php'); 
			}
			?>
		</div>
	</div>
<div class="modal fade" id="popShareModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popShareModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     
    <div class="modal-content">	
      <div class="modal-header" id="popShareHeadModel" style="background:#40516C;color:#fff;padding: 10px 20px;">
        <h5 class="modal-title fs18" id="popShareModelLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popShareFrm" action="home/submitSharedEntry" method="post">
			<div id="popShareRes" class="ajaxFrmRes"></div>
             
            <input type="hidden" id="h_enwithShareId" name="h_enwithShareId" value="<?php echo $sharedWith['enwithShareId'];?>" />
			<input type="hidden" id="h_submitFor" name="h_submitFor" value="<?php echo $sharedWith['submitFor'];?>" />
			<input type="hidden" id="h_reportFor" name="h_reportFor" value="<?php echo $sharedWith['reportFor'];?>" />
			<input type="hidden" id="h_chkId" name="h_chkId" value="<?php echo $sharedWith['chkId'];?>" />
            <input type="hidden" id="h_chkenId" name="h_chkenId" value="<?php echo $sharedWith['chkenId'];?>" />
            <input type="hidden" id="h_clickedBtn" name="h_clickedBtn" value="0" />
			 <div class="row">	
				<div id="popShareFieldSec">
                    <div class="row">
                        <div class="col-12">
							<?php if($sharedWith['submitFor']==1){?>
                            <div class="form-fields">
                                <label class="form-label">Instructions: Leave feedback for the reviewed document</label>
								<textarea id="editor" name="responseMsg"></textarea>                                 
                            </div>                            
							<?php }else{ ?>
							<div class="form-fields">
                                <!-- <label class="form-label">Instructions: Leave feedback for the reviewed document</label> -->
								<textarea id="editor" name="responseMsg"></textarea>                                 
                            </div>  
							<?php } ?>
                        </div>                         
                    </div>                   
                </div>				 
				<div class="col-12 mt-2 firstHide">
					<?php if($sharedWith['liveSts']==1){?>
					<button type="submit" id="popShareSaveBtn" class="btn btn-primary" style="padding:5px 50px; font-weight:600;">Submit</button>
					<?php }else{ }?>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script src="<?php echo base_url();?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<script>
function approveReport(enwithShareId){
	var btnText = $('#approveBtn').html();
	var url = '<?php echo base_url().'home/approveSharedsp?enwithShareId=';?>'+enwithShareId;            
	$.ajax({
		type: "POST",
		url: url,
		beforeSend: function(){
			$('#approveBtn').prop("disabled", true);
			$('#approveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){//alert(result);
			var result_arr = result.split('||')
			if(result_arr[0]=='success'){ 
				window.location = result_arr[1];
			}else{
				// displayToaster(result_arr[0], result_arr[1]);
				$('#approveBtn').prop("disabled", false);
				$('#approveBtn').html(btnText);
			}
		}
	});	
}
function shareReport(submitFor,btnFor){
	var subForChk = parseInt(submitFor);
	var btnForChk = parseInt(btnFor);
	$('#h_clickedBtn').val(btnForChk);
	if(btnForChk==3){
		$('#popShareModelLabel').html('Reject');
		$('#popShareSaveBtn').removeClass('btn-primary');
		$('#popShareSaveBtn').removeClass('btn-warning');
		$('#popShareSaveBtn').addClass('btn-danger');
		$('#popShareHeadModel').css('background','#dc3545');
		$('#popShareHeadModel').css('color','#ffffff');
	}else if(btnForChk==2){
		$('#popShareModelLabel').html('Approve w/Changes');
		$('#popShareSaveBtn').removeClass('btn-primary');
		$('#popShareSaveBtn').removeClass('btn-danger');
		$('#popShareSaveBtn').addClass('btn-warning');
		$('#popShareHeadModel').css('background','#ffc107');
		$('#popShareHeadModel').css('color','#333333');
	}else{
		var btnText = $('#popOpenBtn').html();
		$('#popShareModelLabel').html(btnText);
		$('#popShareSaveBtn').removeClass('btn-danger');
		$('#popShareSaveBtn').removeClass('btn-warning');
		$('#popShareSaveBtn').addClass('btn-primary');
		$('#popShareHeadModel').css('background','#40516C');
		$('#popShareHeadModel').css('color','#ffffff');
	}	
    $('#popShareModel').modal('show');	    
}
$(document).ready(function () {
	if($('#editor').length > 0){
    	CKEDITOR.replace( 'editor',{height: '150px',}); 
	}
	$('#popShareFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popShareSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popShareFrm');
			var url = site_base_url+form.attr('action');
            for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#popShareSaveBtn').prop("disabled", true);
					$('#popShareSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
                        // $('#popShareSaveBtn').prop("disabled", false);
						// $('#popShareSaveBtn').html(btnText);
						// $('#popShareModel').modal('hide'); 
                        window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#popShareRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popShareSaveBtn').prop("disabled", false);
						$('#popShareSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>
</body>
</html>