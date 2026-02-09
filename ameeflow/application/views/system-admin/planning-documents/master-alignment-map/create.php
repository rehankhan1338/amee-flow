<section class="content"> 
    <div class="box">

<style>
.fm{ font-family:"Poppins", sans-serif !important;}
.mamPage { font-size:17px;}
</style>
        <div class="box-body row">
            <div class="col-12">
                <div class="">					 
                    <h4 class="fm">Let's add your master alignment map</h4>
                    <p class="fm mamPage">Follow the template to add your ISLOs, PSLOs, GISLOs.</p>
                    <div class="alert alert-secondary px-3 py-2 fm" style="font-size:16px;"> 
                        <strong>Instructions:</strong> The template is designed to read and process only Institutional Student Learning Outcomes (ISLOs), Program Student Learning Outcomes (PSLOs), and Graduate Institutional Learning Outcomes (GISLOs). Please ensure your input aligns with one of these categories. 
                        <p class="mx-0 my-2 px-0 py-0"><strong>DO NOT CHANGE THE LABELS</strong></p>
                    </div>
                </div>
                <a href="<?php echo base_url().'sample-master-course-alignment-map.xlsx';?>" class="btn btn-warning" style="padding:5px 30px;">Get Template</a>
                <button type="button" class="btn btn-primary" id="addMamBtn" onclick="return manageMam('0');" style="padding:5px 30px; margin-left:10px;"><?php echo $addBtnTxt;?></button>
            </div>
        </div>
    </div>
 

<?php include(APPPATH.'views/system-admin/planning-documents/master-alignment-map/mam-model.php');?>
</section>