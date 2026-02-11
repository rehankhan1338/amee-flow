<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recognition_flow extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title'] = $this->config->item('product_name'); 
		$this->load->model('Course_enrollment_mdl');  		 
 	}

    public function assessment_participants(){
        $this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));
        $universityId = $this->data['sessionDetailsArr']['universityId'];
        $uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
        $userId = $this->data['sessionDetailsArr']['userId'];
        $this->data['pageCallFrom'] = 0;
        $this->data['active_class']='reports-menu';
        $this->data['pageTitle'] = 'Assessment Participants';
        $this->data['pageSubTitle'] = '';
        $this->load->view('Frontend/includes/header',$this->data);		
        $this->data['courseEnrollmentDataArr'] = $this->Course_enrollment_mdl->courseEnrollmentWithTempDataArr($universityId,$uniAdminId);
        if(count($this->data['courseEnrollmentDataArr'])>0){
            if(isset($_GET['ced']) && $_GET['ced']!='' && $_GET['ced']>0){
                $ceId = $_GET['ced'];
            }else{
                $ceId = $this->data['courseEnrollmentDataArr'][0]['ceId'];            
            }
            $this->data['selceId'] = $ceId;
            $this->data['recognitionFlowDataArr'] = $this->Course_enrollment_mdl->recognitionFlowDataArr($universityId,$uniAdminId,$ceId);            
            $this->load->view('system-admin/planning-documents/course-enrollment/recognition-flow',$this->data);            
        }else{

        }
        $this->load->view('Frontend/includes/footer',$this->data);
    }

    public function universityDetails($universityId){
        $this->db->where('universityId', $universityId);
        $qry = $this->db->get('university');
        return $qry->row_array();
    }

    public function universityAdminDetails($uniAdminId){
        $this->db->where('uniAdminId', $uniAdminId);
        $qry = $this->db->get('university_admins');
        return $qry->row_array();
    }

    public function ceDetails($ceId){
        $this->db->where('ceId', $ceId);
        $qry = $this->db->get('course_enrollment');
        return $qry->row_array();
    }

    public function pdf(){

        $encryptId = $this->uri->segment(3);
        if(isset($encryptId) && $encryptId!=''){
             
            $regDetails = $this->Course_enrollment_mdl->regDetails($encryptId);
            if(isset($regDetails['facultyName']) && $regDetails['facultyName']!=''){
                $universityId = $regDetails['universityId'];
                 
                $uniDetails = $this->universityDetails($universityId);
                $universityName = $uniDetails['universityName'];
                $logo = $uniDetails['logo'];

                $uniAdminDetails = $this->universityAdminDetails($regDetails['uniAdminId']);
                $unitName = $uniAdminDetails['unitName'];

                $CEDetails = $this->ceDetails($regDetails['ceId']);
                $semester = $this->config->item('terms_assessment_array_config')[$CEDetails['termId']]['name'].' - '.$CEDetails['year'];                      

                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'A4',
                    'margin_top' => 5,
                    'margin_bottom' => 5,
                    'margin_left' => 5,
                    'margin_right' => 5
                ]);

                $nomineeName = $regDetails['facultyName'];
                $date = date("F j, Y",$regDetails['lastUpdatedOn']);

                $html = '
                <style>
                    .w20{width:20%; float:left;}
                    .w40{width:40%; float:left;padding:0 20px;}
                    .certificate-border {
                        width: 100%;
                        height: 100%;
                        text-align: left;
                        font-size: 15px;
                        line-height:30px;
                        padding: 50px 50px;
                        background-color: #fffef6;       
                    }
                    .tiled-text {
                        color:#40516C;
                        font-size: 40px;
                        font-weight:bold;
                        margin-bottom:50px;
                        text-align: center;
                    } 
                    .certificate-border p{ margin-bottom:15px;font-size: 16px; font-weight:500;}
                    .topHeadTxt{ font-size: 18px;}
                    .bottom-sec{font-size: 16px;font-weight:500;}
                </style>
                <div class="certificate-border">
                    <h1 class="tiled-text">Letter of Recognition</h1>
                    <p>Date: '.$date.'</p>
                    <p>Dear '.$nomineeName.'</p>
                    <p>On behalf of the Office of Academic Assessment and Program Review, we would like to extend our sincere appreciation for your contribution to the <strong>'.$semester.'</strong> iROCA Student Artifact Assessment, which is part of the process of demonstrating teaching effectiveness. Your thoughtful engagement in evaluating student work provides critical insight into how well our students are not only achieving course-level outcomes, but also institutional and program learning outcomes. Your participation strengthens our collective commitment to continuous improvement in teaching and learning.</p>        
                    <p>Faculty participation is crucial to maintaining a culture of evidence-based practice and reflection. The time and expertise you contribute helps ensure that our programs remain responsive, equitable, and aligned with the highest standards of academic quality.</p>        
                    <p>Thank you for your commitment to student success and for supporting our university’s mission through your active role in assessment. Your efforts make a meaningful difference.</p>
                    <p>With appreciation,<br />'.$uniAdminDetails['fullName'].'<br />'.$unitName.'<br />'.$universityName.'</p>
                </div>';           
            
                // $mpdf->SetWatermarkText('Letter of Recognition', 0.1); 
                // $mpdf->showWatermarkText = true;
                $mpdf->SetWatermarkImage('./assets/upload/logo/'.$logo, 0.1, [100, 100]); 
                // parameters: (image_path, alpha_opacity, [width, height])
                $mpdf->showWatermarkImage = true;

                $mpdf->WriteHTML($html);
                $mpdf->Output('Letter_of_Recognition.pdf', 'I');     

            }else{
                $this->data['errMsg'] = 'Not a valid URL';            
                $this->load->view('Frontend/pages/errorMsg',$this->data);
            }
        
        }else{
            $this->data['errMsg'] = 'Not a valid URL';            
            $this->load->view('Frontend/pages/errorMsg',$this->data);
        }

    }

    public function certificate(){

        $encryptId = $this->uri->segment(3);
        if(isset($encryptId) && $encryptId!=''){
             
            $regDetails = $this->Course_enrollment_mdl->regDetails($encryptId);
            if(isset($regDetails['facultyName']) && $regDetails['facultyName']!=''){
                $universityId = $regDetails['universityId'];

                $uniDetails = $this->universityDetails($universityId);
                $universityName = $uniDetails['universityName'];
                $logo = $uniDetails['logo'];

                $uniAdminDetails = $this->universityAdminDetails($regDetails['uniAdminId']);
                $unitName = $uniAdminDetails['unitName'];

                $CEDetails = $this->ceDetails($regDetails['ceId']);
                $semester = $this->config->item('terms_assessment_array_config')[$CEDetails['termId']]['name'].' - '.$CEDetails['year'];                                           

                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'A4-L',
                    'margin_top' => 5,
                    'margin_bottom' => 5,
                    'margin_left' => 5,
                    'margin_right' => 5
                ]);

                $nomineeName = $regDetails['facultyName'];
                // $date = date("F j, Y"); // Gets the current date
                $date = date("F j, Y",$regDetails['lastUpdatedOn']);

    $html = '
    <style>
        .w20{width:20%; float:left;}
        .w40{width:40%; float:left;padding:0 20px;}
        .certificate-border {
            width: 100%;
            height: 100%;
            text-align: center;
            font-size: 15px;
            line-height:30px;
            border: 12px double #40516C; /* outer */
            outline: 4px solid #e18125; /* gold middle */
            padding: 20px 160px;
            background-color: #fffef6;       
        }
        .tiled-text {
            color:#e18125;
            font-size: 40px;
            font-weight:bold;
        } 
        .sealImg{ width:300px; height:auto}
        .nominee{ text-transform:uppercase; font-size:36px;margin:35px 0;color:#40516C;}
        .certificate-border p{ margin-bottom:15px;font-size: 16px; font-weight:500;}
        .topHeadTxt{ font-size: 18px;}
        .bottom-sec{font-size: 16px;font-weight:500;}
    </style>
    <div class="certificate-border">
        <h1 class="tiled-text">CERTIFICATE OF COMPLETION</h1>
        <h4 class="topHeadTxt">This certifies that</h>
        <h2 class="nominee"><em>'.$nomineeName.'</em></h2>
        <p>has completed all required components of CSUNs <strong>Assessment Participation</strong> as a part of their contributions to teaching effectiveness and continuous improvement at <strong>'.$universityName.'</strong> <br>'.$semester.'</p>        
        <p>This includes applying the iROCA rubric and scoring process to an existing assignment, submitting scores for student artifacts on institutional and/or program-related learning outcomes, and participating in onboarding and norming sessions facilitated by the College Assessment Lead(s).</p>        
    </div>
    <div class="bottom-sec">
        <div class="w20">
            <img class="sealImg img-fluid" src="'.base_url().'assets/upload/logo/'.$logo.'" alt="" />
        </div>
        <div class="w40">
             '.$date.'<br><br> <hr /> Date
        </div>
        <div class="w430">
            '.$unitName.' <hr /> Signature 
        </div>
    </div>';            

            $mpdf->WriteHTML($html); // certificate-seal.jpg
            $mpdf->Output('Certificate_of_Completion.pdf', 'I');     

            }else{
                $this->data['errMsg'] = 'Not a valid URL';            
                $this->load->view('Frontend/pages/errorMsg',$this->data);
            }
        
        }else{
            $this->data['errMsg'] = 'Not a valid URL';            
            $this->load->view('Frontend/pages/errorMsg',$this->data);
        }

    }

}