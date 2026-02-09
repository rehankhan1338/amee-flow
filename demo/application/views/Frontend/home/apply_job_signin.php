   
<section class="inner_wrap">
<div class="container">
<div class="col-lg-4 ">
		 
		   
                    <div class="job_list"> 
 					 				 
                    	<div class="job_block"    >
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
                             
                            <span class="date_posted"><?php echo date('M d, Y',$row->start_date); ?></span>
                        </div>
                        
                      			 
                         
                         
                         
                          
                        <div class="clearfix"></div>
                    </div>
					
					
					
                    
               
</div>

<div class="col-lg-8">
            	<form class="register_form" id="register_form" method="post">
				
				 
					 
				 
   
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control email required" id="email" name="email" placeholder="Email">
	<?php echo form_error('email');?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control required" id="pass" name="pass" placeholder="Password">
	<?php echo form_error('pass');?>
  </div>
    
    
  <button type="submit" class="register_btn"  style="width:auto; max-width:100%;">Login Now!</button>
   <div class="alrdy_mem">Not a member? <a class="alrdy_mem_a" href="<?php echo base_url();?>apply/<?php echo $row->id; ?>">Sign up</a></div> 
</form>
            </div>

</div> 
</section>
   
   
   
   
   
      
  
  