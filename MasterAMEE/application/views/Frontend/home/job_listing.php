
    
   
<section class="inner_wrap">
<div class="container">
<div class="col-lg-12 ">
		 
		   
                    <div class="job_list">
					 <?php $i=1; foreach ($job_postings as $row) { ?>	
 					 				 
                    	<div class="job_block  pad_lft col-lg-6"  style="width:49%;" >
                        	<div class="job_block_d">
                            	<div class="mini_title mini_title_contact_us"><?php echo $row->job_title; ?></div>
                                <!--<div class="job_cname">Want tech solution</div>-->
                                <p><?php echo $row->location; ?></p>
                                <h4 style=" font-size: 16px;"><?php echo $row->job_function; ?></h4>
								<span ><a href="<?php echo base_url();?>assets/job_posting_doc/<?php echo $row->document_desc;?>" class="alrdy_mem_a" target="_blank">Job announcement</a></span>
                                <!--<div class="job_key">
                                	<span>KeySkills : </span>
                                	<span>SOFTWARE DEVELOPER, SOFTWARE PROGRAMMER, SOFTWARE TESTING C, C++, JAVA,... </span>
                                 </div>-->
                            </div>
                            <div class="job_block_rec">
 							<a href="<?php echo base_url();?>apply/<?php echo $row->id; ?>" class="register_btn">Apply</a>
 							</div>
                            <span class="date_posted"><?php echo date('M d, Y',$row->start_date); ?></span>
                        </div>
                        
                        <?php $i++; } ?> 			 
                         
                         
                         
                          
                        <div class="clearfix"></div>
                    </div>
                    
               
</div>

</div> 
</section>
   
   
   
   
   
      
  
  