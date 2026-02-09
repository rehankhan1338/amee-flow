<style>
*{margin:0;padding:0;box-sizing:border-box}
.logic_modal_wrap{width:100%;margin:0 auto;color:#000;height:100%;padding:15px;display:flex;flex-wrap:wrap}
.lm_left{display:flex;width:350px;height:100%;justify-content:center;align-items:center}
.situ_prio{display:flex;width:100%;justify-content:flex-start;align-items:stretch;max-height:600px;height:100%}
.situ_prio h2{margin-bottom:15px}
.situ_prio p{margin-bottom:10px;line-height:22px}
.situ{background-color:#4e81bc;padding:20px;width:58%;padding-right:60px; color:#fff; min-height:500px;}
.prio{background-color:#93ccdd;padding:20px;width:40%;height:70%;transform:translate(-30px,80px)}
.prio1::before{content:'';position:absolute;width:0;height:0;border-top:80px solid transparent;border-left:50px solid #93ccdd;border-bottom:80px solid transparent;right:-50px;top:calc(50% - 80px)}

.prio .h1{
        margin-left: 115px;
    margin-top: -49px;}
.prio .h1 i{font-size: 60px;
    color: #93ccdd;
}
.lm_right{display:flex;width:calc(100% - 350px)}
.clum{text-align:center;margin:0 15px}
.clum_head{margin-bottom:10px;padding:10px;border-width:2px;border-style:solid}
.clum_body .col_clum{padding:10px;border-width:2px;border-style:solid; width:100%;}
.clum_body h3{margin-bottom:15px}
.clum_body p{margin-bottom:20px}
.input_col .clum_head::before{content:'';position:absolute;width:0;height:0;border-top:20px solid transparent;border-left:25px solid #ffe92b;border-bottom:20px solid transparent;right:-25px;top:15px;z-index:3}
.input_col .clum_head::after{content:'';position:absolute;width:0;height:0;border-top:23px solid transparent;border-left:28px solid #ddb01f;border-bottom:23px solid transparent;right:-28px;top:12px;z-index:2}

.output_col .clum_head::before{content:'';position:absolute;width:0;height:0;border-top:20px solid transparent;border-left:25px solid #9bbb57;border-bottom:20px solid transparent;right:-25px;top:15px;z-index:3}
.output_col .clum_head::after{content:'';position:absolute;width:0;height:0;border-top:23px solid transparent;border-left:28px solid #84867f;border-bottom:23px solid transparent;right:-28px;top:12px;z-index:2}

.input_col .clum_head{background-color:#ffe92b;border-color:#ddb01f; position: relative;}
.output_col .clum_head{background-color:#9bbb57;border-color:#84867f;position: relative;}
.outputcom_col .clum_head{background-color:#da9695;border-color:#c1898b}
.clum_body{height:calc(100% - 100px)}
.input_col .clum_body .col_clum{background-color:#fff;border-color:#ddb01f}
.output_col .clum_body .col_clum{background-color:#fff;border-color:#899f56}
.outputcom_col .clum_body .col_clum{background-color:#fff;border-color:#c1898b}
.clum_body_cols .col_clum:nth-child(2){border-right:0;border-left:0}
.clum_body_cols{display:flex;height:100%}
.clum_body_cols ul{list-style-position: outside;
    list-style-type: disclosure-closed;}
.clum_body_cols ul li{margin: 0px 0px 10px 6px;    padding: 0;    line-height: 18px;}


.clum_body .col_clum{ text-align:left;}
.sub_col_title{margin-top:10px;display:flex;justify-content:space-around;font-weight:700}
.sub_col_title span{ width:100px;}
.clum_head h2{text-transform:uppercase}
</style>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
function makeScreenshot(){
	$('#downloadBtn').html('Downloading <i class="fa fa-spinner fa-spin"></i>');
	var data = document.getElementById('knob-chart-div');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "<?php echo create_slug_ch($logic_model_details->programName.' '.$logic_model_details->programYear);?>.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
		$('#downloadBtn').html('Download');
	});
	
}

function makeScreenshotBk(){
	$('#captureImage').show();
	var data = document.getElementById('knob-chart-div');
	html2canvas(data).then(function(canvas){
		document.getElementById('captureImage').appendChild(canvas);
	});
	$(document).scrollTop($(document).height());
}
</script>

<section class="content">
<div class="pull-right">
	<button class="btn btn-primary" onclick="return makeScreenshot();" style="font-weight:600; padding:5px 20px;" id="downloadBtn">Download</button>
	<a class="btn btn-default" href="<?php echo base_url().'admin/logic_models';?>" style="padding:5px 20px; margin-left:5px; font-weight:600; font-size:15px;"><i class="fa fa-long-arrow-left"></i> Back to List</a>
</div>
<div id="knob-chart-div" style="padding-top:10px;">
<h3 style="text-align:center; margin: 15px 0;"><?php echo $page_title;?></h3>
<div class="logic_modal_wrap" >
	
	<div class="clearfix"></div>
	<div class="lm_left">
		<div class="situ_prio">
			<div class="situ">
				<h2>Situation</h2>
				<p><?php echo $logic_model_details->situation;?></p>
			</div>
			<div class="prio">
				<h2>Priorities</h2>
				<h1 class="h1"><i class="fa fa-angle-double-right"></i></h1>
				<div style="margin-top:-10px;"><?php echo $logic_model_details->priority;?></div>
				<h1 class="h1"><i class="fa fa-angle-double-right"></i></h1>				
			</div>
		</div>
	</div>
	<div class="lm_right">
		<div class="clum input_col">
			<div class="clum_head">
				<h2>Input</h2>
				<div class="sub_col_title"><span style="visibility: hidden;">Input</span></div>
			</div>
			<div class="clum_body">
				<div class="clum_body_cols">
					<div class="col_clum"><?php echo $logic_model_details->inputs;?></div>
				</div>
				
			</div>
		</div>
		<div class="clum output_col">
			<div class="clum_head">
				<h2>Outputs</h2>
				<div class="sub_col_title"><span>Participants</span><span>Activities</span><span>Direct-Products</span></div>
			</div>
			<div class="clum_body">
				<div class="clum_body_cols">
					<div class="col_clum"><?php echo $logic_model_details->participants;?></div>
					<div class="col_clum"><?php echo $logic_model_details->activities;?></div>
					<div class="col_clum"><?php echo $logic_model_details->directProducts;?></div>
				</div>
			</div>
		</div>
		<div class="clum outputcom_col">
			<div class="clum_head">
				<h2>Outcomes - Impact</h2>
				<div class="sub_col_title"><span>Short Term</span><span>Intermediate</span><span>Long Term</span></div>
			</div>
			<div class="clum_body">
				<div class="clum_body_cols">
					<div class="col_clum"><?php echo $logic_model_details->shortOutCome;?></div>
					<div class="col_clum"><?php echo $logic_model_details->intermediateOutCome;?></div>
					<div class="col_clum"><?php echo $logic_model_details->longOutCome;?></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
	<div id="captureImage" style="display:none;">
		<h3 style="margin-bottom:10px;">Capture Screen Shot - </h3>
	</div>   
</div>
</div>
</section>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>