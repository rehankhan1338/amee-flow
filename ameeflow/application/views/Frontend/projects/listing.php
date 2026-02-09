<section class="content">
<style>
.uproPage .card{ height:100%;border-radius: 10px; border:8px solid rgba(0,0,0,.125);}
.uproPage .card-title {line-height: 40px; font-size:32px; font-weight:bold; letter-spacing:0.5px; text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}
.uproPage p.card-text {font-size: 16px;font-weight: 500;margin: 6px 0px;line-height: 25px;}
.uproPage .btn-pro{ font-size:16px; text-align:left;font-weight: 600;}
.uproPage .btn-pro:hover{opacity:0.8;}
.uproPage .btn-check:focus+.btn, .uproPage .btn:focus{box-shadow: none;}
.uproPage .icon-pro {width: 32px;height: 32px;stroke-width: 2;}
</style>
	
    <?php if(count($assignProjectsDataArr)>0){
         foreach($assignProjectsDataArr as $pro){?>
         <div class="box1 uproPage">
<div class="box-body1 row mx-1">
    <div class="col-6 my-1 px-2 py-2">
        <div class="card" style="background-color:<?php echo $pro['bgColor'];?>;">
            <div class="card-body">
                <div> <i style="color:<?php echo $pro['fontColor'];?>;" class="icon-pro" data-feather="check-square"></i> </div>
                <h5 class="card-title my-1" style="color:<?php echo $pro['fontColor'];?>;"><?php echo $pro['projectName'];?></h5>
                <div class="row">
                    <div class="col-7">
                        <p class="card-text" style="color:<?php echo $pro['fontColor'];?>;"><?php echo $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'];?> <br/ > <?php 
                        
                        echo '('.getUserAssignProTaskCnt($pro['projectId'],$sessionDetailsArr['userId']).')';
                       // echo '('.$pro['taskCnt'].')'; ?> Main Tasks</p>
                    </div>
                    <div class="col-5" style=" display: flex; align-items: end;">
                        <a href="<?php echo base_url().'projects/tasks/'.$pro['proencryptId'];?>" class="btn btn-pro" style="border-color:<?php echo $pro['btnColor'];?>;background-color:<?php echo $pro['btnColor'];?>;color:<?php echo $pro['fontColor'];?>" >Go to Tasks <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                
                
                <?php //?>
            </div>
        </div>
    </div>
    </div>
</div>
    <?php } }else{ ?>
    <style>
        .dashboard-empty {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-direction: column;
            text-align: center;
            color: #333;
            margin:5% auto;
        }
        .dashboard-icon {
            font-size: 4rem;
            color: #40516C;
            margin-bottom: 20px;
        }
    </style>        
    <div class="box uproPage">
        <div class="dashboard-empty">
            <div class="dashboard-icon">
                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            </div>
            <h3>No Tasks Assigned</h3>
            <p class="lead">
                Your projects will appear here when you have been assigned tasks.
                <br>
                Please check back later or contact your project lead.
            </p>
        </div>
    </div> 

    <?php } ?>

</section>