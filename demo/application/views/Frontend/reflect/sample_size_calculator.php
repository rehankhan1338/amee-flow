<script type="text/javascript">

function calculate_sample_size(){

	var txt_population = jQuery('#txt_population').val();
	var txt_confidence_level = jQuery('#txt_confidence_level').val();
	var txt_margin_error = jQuery('#txt_margin_error').val();
	
	if(txt_population!=''){
	
		var div_by_margin_error_confidence_level = txt_margin_error/txt_confidence_level;
		var div_by_margin_error_confidence_level_sq = div_by_margin_error_confidence_level*div_by_margin_error_confidence_level;
		var Sample_Size=0.25/div_by_margin_error_confidence_level_sq;
		
		var step1 = Sample_Size*txt_population;
		var step2 = Sample_Size+(txt_population-1);
		var final_result = (step1/step2).toFixed();
		jQuery('.fresult').html(final_result);
		//alert(final_result);
	}else{
	
		alert('Please enter the population size!');
	}	
		
}

</script> 
 <style>

</style> 
<div style="font-size:18px; margin-bottom:10px;"><strong>Note:</strong> You can project your sample size by anticipating the number of students enrolled in the course sections based on course caps.</div>  
    <div class="sscaalcultor">
	 
          <div class="col-md-6">
            <div class="sample-calculator">
			
				<div class="sample_size_cal nomargintop">
              		<h3>Calculate your sample size:</h3>
				</div>	
              	
				<div class="col-md-12" >
					<label class="col-md-4" for="population"><h4>Population Size: </h4><span data-tooltip="" class="has-tip calculator-tip tip-top" title="The total number of people that make up the target audience of your survey. If unsure choose 20,000."></span></label> 
					<div class="col-md-8">
						<input id="txt_population" name="txt_population" type="text" class="form-control" onkeyup="return calculate_sample_size();" value="">
					</div>
				</div>
				
				<div class="col-md-12">
					<label class="col-md-4" for="confidence_interval"><h4>Confidence Level:</h4> <span data-tooltip="" class="has-tip tip-top" title="The probability that the sample's results can be inferred on the survey's population. Survey industry standard is 95%"></span></label>
					<div class="col-md-8">
						<select id="txt_confidence_level" name="txt_confidence_level" class="form-control" onchange="return calculate_sample_size();">
							<option value="1.96">95%</option>
							<option value="2.58">99%</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-12">
					<label class="col-md-4"  for="margin_error"><h4>Margin of Error:</h4> <span data-tooltip="" class="has-tip tip-top" title="The plus/minus range that can be placed on the sample's results to indicate where the population's results would fall.  Survey industry standard is 5%."></span></label>
					<div class="col-md-8">
						<select class="form-control" name="txt_margin_error" id="txt_margin_error" onchange="return calculate_sample_size();">
							<option value="0.01">1%</option>
							<option  value="0.02">2%</option>
							<option value="0.03">3%</option>
							<option value="0.04">4%</option>
							<option value="0.05">5%</option>
						</select>
						<span></span>
					</div>
				</div>
				
					<span class="calc-error"></span>
					<input class="btn btn-primary" value="Calculate" type="button" onclick="return calculate_sample_size();">
                
              </div>

          </div>

          <div class="col-md-2 sample_calculator_right_icon" >
             <i class="fa fa-hand-o-right" aria-hidden="true"></i>

          </div>

          <div class="col-md-4">
            <div class="sample-size">
              <div class="sample_size_cal nomargintop">
              		<h3>Your suggested sample size is:</h3>
				</div>	
              <div  class="fresult">&ndash;</div>
            </div>
             
          </div>
 
        </div> 