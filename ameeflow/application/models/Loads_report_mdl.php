<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loads_report_mdl extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}

    public function reportDetailsByeIdArr($erId){
        $this->db->where('erId', $erId);
		$qry = $this->db->get('loads_report');
		return $qry->row_array();
    }

    public function reportDetailsArr($rId){
        $this->db->where('rId', $rId);
		$qry = $this->db->get('loads_report');
		return $qry->row_array();
    }

    public function pmLoadsReportDataArr($uniAdminId){
		$this->db->where('isDeleted', 0);
		$this->db->where('uniAdminId', $uniAdminId);
		$qry = $this->db->get('loads_report');
		return $qry->result_array();
	} 

    public function userLoadsReportDataArr($userId){
		$this->db->where('isDeleted', 0);
		$this->db->where('userId', $userId);
		$qry = $this->db->get('loads_report');
		return $qry->result_array();
	} 

    public function saveReport(){
		$userId = $_POST['rauserId'];
        $uniAdminId = $_POST['rauniAdminId'];
        $universityId = $_POST['rauniversityId'];

		$termId = $_POST['txt_termId'];
		$year = $_POST['txt_year'];
        $courseProgram = $_POST['courseProgram'];
        $strengths = $_POST['strengths'];
        $areaImprovement = $_POST['areaImprovement'];
        $imdtNextStep = $_POST['imdtNextStep'];
        $recdProgram = $_POST['recdProgram'];
        $planFollowup = $_POST['planFollowup'];
        $time = time();
        
        if(isset($rIdChk) && $rIdChk!='' && $rIdChk>0){
            $rId = $rIdChk;
            $erId = $_POST['erIdChk'];
            $this->db->where('rId',$rIdChk); 
            $this->db->update('loads_report', array('termId'=>$termId,'year'=>$year,'courseProgram'=>$courseProgram,'strengths'=>$strengths,'areaImprovement'=>$areaImprovement,'imdtNextStep'=>$imdtNextStep,'recdProgram'=>$recdProgram,'planFollowup'=>$planFollowup, 'lastUpdatedOn'=>$time));
            $this->session->set_flashdata('success', 'Report Updated.');
        }else{
            $this->db->insert('loads_report', array('userId'=>$userId,'uniAdminId'=>$uniAdminId,'termId'=>$termId,'year'=>$year,'courseProgram'=>$courseProgram,'strengths'=>$strengths,'areaImprovement'=>$areaImprovement,'imdtNextStep'=>$imdtNextStep,'recdProgram'=>$recdProgram,'planFollowup'=>$planFollowup, 'createOn'=>$time, 'lastUpdatedOn'=>$time));
            $rId = $this->db->insert_id();
			$erId = generateRandomNumStringCh(4).'ldr'.$rId.generateRandomNumStringCh(4);
			$this->db->where('rId',$rId); 
			$this->db->update('loads_report', array("erId"=>$erId));
            $this->generateReport($rId);            
            $this->session->set_flashdata('success', 'Report Created.');             
        }        
		return 'success||'.base_url().'loads_report/view/'.$erId;
	}

    public function generateReport($rId){
        $this->db->where('rId', $rId);
		$qry = $this->db->get('loads_report');
		$rData = $qry->row_array();
        $time = time();
        $this->db->where('promptId', 6);
        $qryPrompt = $this->db->get('prompting');
        $secContent = $qryPrompt->row_array();
        $inputText = str_replace('{courseAssessed}',$rData['courseProgram'],$secContent['msgUserRole']);
        $inputText = str_replace('{strengths}',$rData['strengths'],$inputText);
        $inputText = str_replace('{areaForImprovement}',$rData['areaImprovement'],$inputText);
        $inputText = str_replace('{immediateNextSteps}',$rData['imdtNextStep'],$inputText);
        $inputText = str_replace('{recommendationsForFaculty}',$rData['recdProgram'],$inputText);
        $inputText = str_replace('{PlannedFollowup}',$rData['planFollowup'],$inputText);			
        $sysInput = $secContent['msgSystemRole'];
        $maxTokens = $secContent['maxTokenCnt'];
        if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
            $resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
            if($resArr[0]=='success'){
                if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
                    $aiReport = convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']);
                    $this->db->where('rId',$rId); 
                    $this->db->update('loads_report', array("aiReport"=>$aiReport, 'lastUpdatedOn'=>$time));
                }
            }
        }
    }

    public function saveAIreport(){
        $rId = $_POST['ai_rId'];
		$erId = $_POST['ai_erId'];
		$aisummary = $_POST['txt_aisummary'];
        $time = time();
        $this->db->where('rId',$rId); 
        $this->db->update('loads_report', array("aiReport"=>$aisummary, 'lastUpdatedOn'=>$time));
        return 'success||'.base_url().'loads_report/view/'.$erId;
    }

    public function deleteReport($rIds){
		$where = ' rId in ('.$rIds.')';
		$this->db->where($where);
		$this->db->update('loads_report', array("isDeleted"=>1));
		$this->session->set_flashdata('success', 'Deleted successfully.');	
	}

}