<section class="content"> 
    <div class="box">
<style>
.fm{ font-family:"Poppins", sans-serif !important;}
.mamPage { font-size:17px;}
</style>
        <div class="box-body row">
            <div class="col-12">
                <div class="">					 
                    <h4 class="fm">Let's set up your schedule of courses</h4>
                    <p class="fm mamPage">Follow the template to add your Schedule of Courses (SOC) data</p>
                    <div class="alert alert-secondary px-3 py-2 fm" style="color: #000 !important;font-size:15px;"> 
                        <strong>Instructions:</strong> This template is designed to read and process only certain data related to course enrollment. Please ensure your input aligns with category labels. 
                        <p class="mx-0 my-2 px-0 py-0"><strong>DO NOT CHANGE THE LABELS</strong></p>
                    </div>
                    <div class="alert alert-warning" style="color: #000 !important;font-size: 15px;">
                        <strong>Important Note:</strong> <br />
Do not modify the Schedule of Courses (SOC) after users have begun selecting courses. Changing the SOC at this stage may result in system errors and data loss. Always finalize the SOC before course selection begins.
                    </div>
                </div>
                <a href="<?php echo base_url().'sample-course-enrollment.xlsx';?>" class="btn btn-info" style="padding:5px 30px;">Get Template</a>
                <button type="button" class="btn btn-primary" id="addCeBtn" onclick="return manageMam('0');" style="padding:5px 30px; margin-left:10px;"><?php echo $addBtnTxt;?></button>
            </div>
        </div>
    </div>
 
<?php include(APPPATH.'views/system-admin/planning-documents/course-enrollment/ce-model.php');?>
</section>