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
					<h4>Hi, <?php echo $ntDetails['recpName'];?></h4>
				</div>				
			</div>
		</div>
	</div>
	<div class="container my-5">	
        <?php if($ntDetails['resDate']>0){?>
			<div class="row my-3">
				<div class="col-12" style="background:#f4f4f4; border-radius:10px; padding:10px 20px 0px 20px;">
					<h5><?php if($ntDetails['followupDateSts']==1){echo 'You have already responded to this notification.'; }else{echo 'Your response below has been successfully submitted';}?></h5>
                    <?php if($ntDetails['resOptionId']==4){?>
					<p class="fw600"><?php echo $ntDetails['resTxt'];?></p>
                    <?php }else{
                        $resOptions = filter_array($resOptionsChoiceArr,$ntDetails['resOptChoiceId'],'resOptChoiceId');
                        if(count($resOptions)>0){
                            echo '<p class="fw600">'.$resOptions[0]['choiceName'].'</p>';
                        }
                    }
                    ?>
				</div>
			</div>
		<?php } ?>	 
		<div class="row ">
			<div class="col-md-12" style=" font-size:16px; line-height:28px;">
				<?php 
					echo $ntDetails['sendMsg'];
				?>
			</div>
			<div class="col-md-12 mt-3"> 
                    <?php 
                    $btnTxt = 'Response';
                    if($ntDetails['resOptionId']>0 && $ntDetails['resDate']==0){?>
                        <button class="btn btn-primary" style="font-size:15px; font-weight:500; padding:5px 20px;" id="popOpenBtn" onclick="return giveFeedback();"><?php echo $btnTxt;?></button>
                    <?php } ?>					
				</div>


		</div>
		 
	</div>

<?php if($ntDetails['resOptionId']>0 && $ntDetails['resDate']==0){?>
<div class="modal fade" id="popShareModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popShareModelLabel" aria-hidden="true">
  <div class="modal-dialog">
     
    <div class="modal-content">	
      <div class="modal-header" id="popShareHeadModel">
        <h5 class="modal-title fs18" id="popShareModelLabel">Response</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popShareFrm" action="home/submitNotiResEntry" method="post">
			<div id="popShareRes" class="ajaxFrmRes"></div>
             
            <input type="hidden" id="h_enrecpId" name="h_enrecpId" value="<?php echo $ntDetails['enrecpId'];?>" />
			 <div class="row">	
				<div id="popShareFieldSec">
                    <div class="row">
                        <div class="col-12">
							<div class="form-fields">
                                 
                                <label class="form-label">Instructions: Leave response for the notification.</label>
                                <?php if($ntDetails['resOptionId']==4){?>
                                
                                   <textarea rows="5" id="h_resTxt" name="h_resTxt" class="form-control required"></textarea>    
                                    <input type="hidden" id="h_resOptChoiceId" name="h_resOptChoiceId" value="0" />
                                <?php }else{?>
                                    <input type="hidden" id="h_resTxt" name="h_resTxt" value="" />
								<select id="h_resOptChoiceId" name="h_resOptChoiceId" class="form-control required">
                                    <option value="">Select...</option>
                                    <?php $resOptions = filter_array($resOptionsChoiceArr,$ntDetails['resOptionId'],'resOptionId');
                                    if(count($resOptions)>0){
                                        foreach($resOptions as $op){?>
                                        <option value="<?php echo $op['resOptChoiceId'];?>"><?php echo $op['choiceName'];?></option>
                                    <?php } } ?>
                                </select>         
                                <?php } ?>                        
                            </div> 
                        </div>                         
                    </div>                   
                </div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popShareSaveBtn" class="btn btn-primary" style="padding:5px 50px; font-weight:600;">Submit</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function giveFeedback(){
	$('#popShareModel').modal('show');	    
}
$(document).ready(function () {
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
            // for (instance in CKEDITOR.instances) {
			// 	CKEDITOR.instances[instance].updateElement();
			// }
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#popShareSaveBtn').prop("disabled", true);
					$('#popShareSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
                        window.location = result_arr[1];
					}else{
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
<?php } ?>

</body>
</html>