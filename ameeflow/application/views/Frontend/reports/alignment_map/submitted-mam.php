<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/frontend/custom.css" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo base_url();?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo base_url();?>assets/frontend/ameeflow-panel.css" rel="stylesheet" type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="<?php echo base_url();?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<style>
	*, *::before, *::after { box-sizing: border-box; }
	body {
		font-family: 'Inter', 'Poppins', sans-serif;
		background: #f0f2f5;
		color: #1e293b;
		min-height: 100vh;
		margin: 0;
	}

	/* ── Top Bar ── */
	.share-topbar {
		background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
		color: #fff;
		padding: 0;
		position: sticky;
		top: 0;
		z-index: 1050;
		box-shadow: 0 4px 24px rgba(0,0,0,.18);
	}
	.share-topbar-inner {
		padding: 14px 28px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 12px;
	}
	.share-topbar-left {
		display: flex;
		align-items: center;
		gap: 14px;
		min-width: 0;
	}
	.share-topbar-avatar {
		width: 42px; height: 42px;
		border-radius: 50%;
		background: rgba(255,255,255,.15);
		display: flex; align-items: center; justify-content: center;
		font-size: 18px; font-weight: 700; color: #fff;
		flex-shrink: 0;
		border: 2px solid rgba(255,255,255,.25);
	}
	.share-topbar-greeting {
		font-size: 15px; font-weight: 500; color: rgba(255,255,255,.85);
	}
	.share-topbar-greeting strong {
		color: #fff; font-weight: 700; font-size: 17px;
	}
	.share-topbar-right {
		display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
	}

	/* ── Action Buttons ── */
	.share-btn {
		display: inline-flex; align-items: center; gap: 7px;
		border: none; cursor: pointer;
		font-size: 13px; font-weight: 600;
		padding: 9px 22px;
		border-radius: 10px;
		transition: all .2s ease;
		text-decoration: none;
		letter-spacing: .2px;
	}
	.share-btn i { font-size: 13px; }
	.share-btn-feedback {
		background: rgba(255,255,255,.12);
		color: #fff;
		border: 1px solid rgba(255,255,255,.2);
	}
	.share-btn-feedback:hover {
		background: rgba(255,255,255,.22);
		color: #fff;
		transform: translateY(-1px);
	}
	.share-btn-approve {
		background: linear-gradient(135deg, #22c55e, #16a34a);
		color: #fff;
		box-shadow: 0 2px 8px rgba(34,197,94,.3);
	}
	.share-btn-approve:hover {
		background: linear-gradient(135deg, #16a34a, #15803d);
		color: #fff;
		transform: translateY(-1px);
		box-shadow: 0 4px 14px rgba(34,197,94,.4);
	}
	.share-btn-changes {
		background: linear-gradient(135deg, #f59e0b, #d97706);
		color: #fff;
		box-shadow: 0 2px 8px rgba(245,158,11,.3);
	}
	.share-btn-changes:hover {
		background: linear-gradient(135deg, #d97706, #b45309);
		color: #fff;
		transform: translateY(-1px);
		box-shadow: 0 4px 14px rgba(245,158,11,.4);
	}
	.share-btn-reject {
		background: linear-gradient(135deg, #ef4444, #dc2626);
		color: #fff;
		box-shadow: 0 2px 8px rgba(239,68,68,.3);
	}
	.share-btn-reject:hover {
		background: linear-gradient(135deg, #dc2626, #b91c1c);
		color: #fff;
		transform: translateY(-1px);
		box-shadow: 0 4px 14px rgba(239,68,68,.4);
	}

	/* ── Status Badge (already acted on) ── */
	.share-status-badge {
		display: inline-flex; align-items: center; gap: 8px;
		padding: 9px 24px;
		border-radius: 10px;
		font-size: 13px; font-weight: 700;
		letter-spacing: .3px;
		cursor: default;
	}
	.share-status-badge i { font-size: 14px; }
	.share-status-approved {
		background: rgba(34,197,94,.15); color: #16a34a; border: 1px solid rgba(34,197,94,.25);
	}
	.share-status-changes {
		background: rgba(245,158,11,.15); color: #d97706; border: 1px solid rgba(245,158,11,.25);
	}
	.share-status-rejected {
		background: rgba(239,68,68,.15); color: #dc2626; border: 1px solid rgba(239,68,68,.25);
	}

	/* ── Feedback submitted banner ── */
	.share-feedback-banner {
		margin: 20px 0 0;
		padding: 0 28px;
	}
	.share-feedback-banner-inner {
		background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
		border: 1px solid #bbf7d0;
		border-radius: 14px;
		padding: 18px 24px;
		display: flex;
		align-items: flex-start;
		gap: 14px;
	}
	.share-feedback-banner-icon {
		width: 36px; height: 36px;
		border-radius: 10px;
		background: #22c55e;
		display: flex; align-items: center; justify-content: center;
		color: #fff; font-size: 16px;
		flex-shrink: 0;
		margin-top: 2px;
	}
	.share-feedback-banner-text h6 {
		margin: 0 0 6px;
		font-size: 14px; font-weight: 700; color: #166534;
	}
	.share-feedback-banner-text p,
	.share-feedback-banner-text div {
		margin: 0;
		font-size: 13px; color: #15803d; line-height: 1.6;
	}

	/* ── Main Content Area ── */
	.share-main {
		padding: 24px 28px 60px;
	}

	/* ── Document Card ── */
	.share-doc-card {
		background: #fff;
		border-radius: 18px;
		box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 24px rgba(0,0,0,.04);
		overflow: hidden;
	}
	.share-doc-header {
		background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
		border-bottom: 1px solid #e2e8f0;
		padding: 20px 28px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 12px;
	}
	.share-doc-header-left {
		display: flex; align-items: center; gap: 12px;
	}
	.share-doc-icon {
		width: 40px; height: 40px;
		border-radius: 12px;
		background: linear-gradient(135deg, #3b82f6, #2563eb);
		display: flex; align-items: center; justify-content: center;
		color: #fff; font-size: 16px;
	}
	.share-doc-title {
		font-size: 16px; font-weight: 700; color: #1e293b;
		margin: 0;
	}
	.share-doc-subtitle {
		font-size: 12px; color: #64748b; font-weight: 400;
		margin: 2px 0 0;
	}
	.share-doc-body {
		padding: 0;
	}

	/* ── Override alignment map view inside this page ── */
	.share-doc-body .content {
		padding: 0 !important;
		margin: 0 !important;
	}
	.share-doc-body .box {
		border: none !important;
		box-shadow: none !important;
		border-radius: 0 !important;
		margin: 0 !important;
	}
	.share-doc-body .box-header {
		padding: 20px 28px 10px !important;
	}
	.share-doc-body .af-roles-toolbar {
		padding: 0 28px !important;
	}
	.share-doc-body .mam-color-legend {
		margin-left: 28px !important;
		margin-right: 28px !important;
	}
	.share-doc-body .mam-note-info {
		margin-left: 28px !important;
		margin-right: 28px !important;
	}
	.share-doc-body .box-body {
		padding: 16px 20px !important;
	}
	.share-doc-body .af-sticky-header {
		padding: 0 !important;
	}

	/* ── Modal Overrides ── */
	.share-modal .modal-content {
		border: none;
		border-radius: 18px;
		overflow: hidden;
		box-shadow: 0 20px 60px rgba(0,0,0,.2);
	}
	.share-modal .modal-header {
		padding: 18px 24px;
		border-bottom: 1px solid #e2e8f0;
	}
	.share-modal .modal-header.modal-header-feedback {
		background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
		color: #fff;
	}
	.share-modal .modal-header.modal-header-approve {
		background: linear-gradient(135deg, #22c55e, #16a34a);
		color: #fff;
	}
	.share-modal .modal-header.modal-header-changes {
		background: linear-gradient(135deg, #f59e0b, #d97706);
		color: #fff;
	}
	.share-modal .modal-header.modal-header-reject {
		background: linear-gradient(135deg, #ef4444, #dc2626);
		color: #fff;
	}
	.share-modal .modal-title {
		font-size: 16px; font-weight: 700;
		display: flex; align-items: center; gap: 8px;
	}
	.share-modal .modal-body {
		padding: 24px;
	}
	.share-modal .btn-close {
		filter: brightness(0) invert(1);
		opacity: .7;
	}
	.share-modal .btn-close:hover { opacity: 1; }

	.share-modal-submit-btn {
		display: inline-flex; align-items: center; gap: 7px;
		font-size: 14px; font-weight: 600;
		padding: 11px 36px;
		border-radius: 12px;
		border: none;
		cursor: pointer;
		transition: all .2s ease;
		color: #fff;
	}
	.share-modal-submit-btn.btn-primary {
		background: linear-gradient(135deg, #3b82f6, #2563eb);
		box-shadow: 0 2px 10px rgba(59,130,246,.3);
	}
	.share-modal-submit-btn.btn-warning {
		background: linear-gradient(135deg, #f59e0b, #d97706);
		box-shadow: 0 2px 10px rgba(245,158,11,.3);
		color: #fff;
	}
	.share-modal-submit-btn.btn-danger {
		background: linear-gradient(135deg, #ef4444, #dc2626);
		box-shadow: 0 2px 10px rgba(239,68,68,.3);
	}
	.share-modal-submit-btn:hover {
		transform: translateY(-1px);
	}

	/* ── Responsive ── */
	@media (max-width: 768px) {
		.share-topbar-inner { padding: 12px 16px; }
		.share-main { padding: 16px 12px 40px; }
		.share-doc-header { padding: 16px 18px; }
		.share-doc-body .box-header { padding: 16px 16px 8px !important; }
		.share-doc-body .af-roles-toolbar { padding: 0 16px !important; }
		.share-doc-body .mam-color-legend { margin-left: 16px !important; margin-right: 16px !important; }
		.share-doc-body .mam-note-info { margin-left: 16px !important; margin-right: 16px !important; }
		.share-doc-body .box-body { padding: 12px 10px !important; }
		.share-feedback-banner { padding: 0 12px; }
	}
	</style>
	<script>
	$(function(){ 
		$('[data-bs-toggle="tooltip"]').tooltip({ html: true });
	});
	</script>
</head>
<body>

<!-- ── Top Bar ── -->
<div class="share-topbar">
	<div class="share-topbar-inner">
		<div class="share-topbar-left">
			<div class="share-topbar-avatar">
				<?php echo strtoupper(substr($sharedWith['swName'], 0, 1)); ?>
			</div>
			<div class="share-topbar-greeting">
				Welcome, <strong><?php echo htmlspecialchars($sharedWith['swName']);?></strong>
			</div>
		</div>
		<div class="share-topbar-right">
			<?php if($sharedWith['submitFor']==1){ ?>
				<?php if($sharedWith['actionTakenSts']==0){ ?>
					<button class="share-btn share-btn-feedback" id="popOpenBtn" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','1');">
						<i class="fa fa-comment-o"></i> Leave Feedback
					</button>
				<?php } else { ?>
					<span class="share-status-badge share-status-approved" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo htmlspecialchars($sharedWith['reason']);?>">
						<i class="fa fa-check-circle"></i> Feedback Submitted
					</span>
				<?php } ?>
			<?php } else { ?>
				<?php if($sharedWith['actionTakenSts']==0){ ?>
					<button class="share-btn share-btn-approve" id="approveBtn" <?php if($sharedWith['liveSts']==1){?> onclick="return approveReport('<?php echo $sharedWith['enwithShareId'];?>');" <?php } ?>>
						<i class="fa fa-check"></i> Approve
					</button>
					<button class="share-btn share-btn-changes" id="popOpenBtn" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','2');">
						<i class="fa fa-pencil"></i> Approve w/Changes
					</button>
					<button class="share-btn share-btn-reject" onclick="return shareReport('<?php echo $sharedWith['submitFor'];?>','3');">
						<i class="fa fa-times"></i> Reject
					</button>
				<?php } else { 
					if($sharedWith['actionTakenSts']==1){
						$stsText = 'Approved';
						$stsClass = 'share-status-approved';
						$stsIcon = 'fa-check-circle';
					} else if($sharedWith['actionTakenSts']==2){
						$stsText = 'Approved w/Changes';
						$stsClass = 'share-status-changes';
						$stsIcon = 'fa-pencil-square-o';
					} else if($sharedWith['actionTakenSts']==3){
						$stsText = 'Rejected';
						$stsClass = 'share-status-rejected';
						$stsIcon = 'fa-times-circle';
					}
				?>
					<span class="share-status-badge <?php echo $stsClass;?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo htmlspecialchars($sharedWith['reason']);?>">
						<i class="fa <?php echo $stsIcon;?>"></i> <?php echo $stsText;?>
					</span>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<!-- ── Feedback Submitted Banner ── -->
<?php if($sharedWith['submitFor']==1 && $sharedWith['actionTakenSts']==1){ ?>
<div class="share-feedback-banner">
	<div class="share-feedback-banner-inner">
		<div class="share-feedback-banner-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="share-feedback-banner-text">
			<h6>Your feedback has been successfully submitted</h6>
			<div><?php echo $sharedWith['reason'];?></div>
		</div>
	</div>
</div>
<?php } ?>

<!-- ── Main Content ── -->
<div class="share-main">
	<div class="share-doc-card">
		<div class="share-doc-header">
			<div class="share-doc-header-left">
				<div class="share-doc-icon">
					<i class="fa fa-th"></i>
				</div>
				<div>
					<h2 class="share-doc-title">Master Alignment Map</h2>
					<p class="share-doc-subtitle">Shared alignment map document for review</p>
				</div>
			</div>
		</div>
		<div class="share-doc-body">
			<?php include(APPPATH.'views/Frontend/reports/alignment_map/view.php'); ?>
		</div>
	</div>
</div>

<!-- ── Feedback / Action Modal ── -->
<div class="modal fade share-modal" id="popShareModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popShareModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header modal-header-feedback" id="popShareHeadModel">
				<h5 class="modal-title" id="popShareModelLabel">
					<i class="fa fa-comment-o" id="modalTitleIcon"></i>
					<span id="modalTitleText"></span>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="popShareFrm" action="home/submitSharedAMEntry" method="post">
					<div id="popShareRes" class="ajaxFrmRes"></div>
					<input type="hidden" id="h_enwithShareId" name="h_enwithShareId" value="<?php echo $sharedWith['enwithShareId'];?>" />
					<input type="hidden" id="h_mamId" name="h_mamId" value="<?php echo $mamDetailsArr['mamId'];?>" />
					<input type="hidden" id="h_oversigntId" name="h_oversigntId" value="<?php echo $seloversigntId;?>" />
					<input type="hidden" id="h_submitFor" name="h_submitFor" value="1" />
					<input type="hidden" id="h_clickedBtn" name="h_clickedBtn" value="0" />
					<div id="popShareFieldSec">
						<div class="mb-3">
							<label class="form-label" style="font-size:13px;font-weight:600;color:#475569;">
								<?php if($sharedWith['submitFor']==1){ ?>
									Leave your feedback for the reviewed document
								<?php } else { ?>
									Add your comments
								<?php } ?>
							</label>
							<textarea id="editor" name="responseMsg"></textarea>
						</div>
					</div>
					<?php if($sharedWith['liveSts']==1){ ?>
					<div class="mt-3 pt-3" style="border-top:1px solid #e2e8f0;">
						<button type="submit" id="popShareSaveBtn" class="share-modal-submit-btn btn-primary">
							<i class="fa fa-paper-plane"></i> Submit
						</button>
					</div>
					<?php } ?>
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
			$('#approveBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
		},
		success: function(result, status, xhr){
			var result_arr = result.split('||')
			if(result_arr[0]=='success'){ 
				window.location = result_arr[1];
			}else{
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

	var $header = $('#popShareHeadModel');
	var $btn = $('#popShareSaveBtn');
	var $icon = $('#modalTitleIcon');
	var $text = $('#modalTitleText');

	// Reset classes
	$header.removeClass('modal-header-feedback modal-header-approve modal-header-changes modal-header-reject');
	$btn.removeClass('btn-primary btn-warning btn-danger');

	if(btnForChk==3){
		$header.addClass('modal-header-reject');
		$btn.addClass('btn-danger');
		$icon.attr('class','fa fa-times-circle');
		$text.text('Reject');
	} else if(btnForChk==2){
		$header.addClass('modal-header-changes');
		$btn.addClass('btn-warning');
		$icon.attr('class','fa fa-pencil');
		$text.text('Approve w/Changes');
	} else {
		$header.addClass('modal-header-feedback');
		$btn.addClass('btn-primary');
		$icon.attr('class','fa fa-comment-o');
		$text.text('Leave Feedback');
	}
	$('#popShareModel').modal('show');
}
$(document).ready(function () {
	if($('#editor').length > 0){
		CKEDITOR.replace('editor', { height: '180px' }); 
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
				data: form.serialize(),
				beforeSend: function(){
					$('#popShareSaveBtn').prop("disabled", true);
					$('#popShareSaveBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#popShareRes').html('<div class="alert alert-danger" style="border-radius:10px;font-size:13px;">'+result_arr[1]+'</div>');
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