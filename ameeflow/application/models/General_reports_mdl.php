<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_reports_mdl extends CI_Model {
	
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
		$qry = $this->db->get('general_reports');
		return $qry->row_array();
    }

    public function reportDetailsArr($rId){
        $this->db->where('rId', $rId);
		$qry = $this->db->get('general_reports');
		return $qry->row_array();
    }

    public function pmGeneralReportDataArr($uniAdminId){
		$this->db->where('isDeleted', 0);
		$this->db->where('uniAdminId', $uniAdminId);
		$qry = $this->db->get('general_reports');
		return $qry->result_array();
	}

    public function userGeneralReportDataArr($userId){
		$this->db->where('isDeleted', 0);
		$this->db->where('userId', $userId);
		$qry = $this->db->get('general_reports');
		return $qry->result_array();
	}

    public function genAIGeneralReport(){
		if(isset($_POST['topicName']) && $_POST['topicName']!='' && isset($_POST['topicContent']) && $_POST['topicContent']!=''){             
            $this->db->where('promptId', 7);
            $qryPrompt = $this->db->get('prompting');
            $secContent = $qryPrompt->row_array();
            $inputText = str_replace('{topicName}',$_POST['topicName'],$secContent['msgUserRole']);
            $inputText = str_replace('{topicContent}',$_POST['topicContent'],$inputText);			
            $sysInput = $secContent['msgSystemRole'];
            $maxTokens = $secContent['maxTokenCnt'];
            if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
                $resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
                if($resArr[0]=='success'){
                    if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
                        return convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']);
                    }
                }
            }
        }
        return '';
	}

    public function saveReport(){
		$userId = $_POST['rauserId'];
        $uniAdminId = $_POST['rauniAdminId'];
        $universityId = $_POST['rauniversityId'];
		$topicName = $_POST['ntTopicName'];
        $topicContent = $_POST['ntTopicContent'];
		$reportSummary = $_POST['reportSummary'];
        $rIdChk = $_POST['rIdChk'];
        $time = time();
        
        if(isset($rIdChk) && $rIdChk!='' && $rIdChk>0){
            $rId = $rIdChk;
            $erId = $_POST['erIdChk'];
            $this->db->where('rId',$rIdChk); 
            $this->db->update('general_reports', array('topicName'=>$topicName,'topicContent'=>$topicContent,'reportSummary'=>$reportSummary, 'lastUpdatedOn'=>$time));
            $this->session->set_flashdata('success', 'Report Created.');
        }else{
            $this->db->insert('general_reports', array('userId'=>$userId,'uniAdminId'=>$uniAdminId,'topicName'=>$topicName,'topicContent'=>$topicContent,'reportSummary'=>$reportSummary, 'createOn'=>$time, 'lastUpdatedOn'=>$time));
            $rId = $this->db->insert_id();
			$erId = generateRandomNumStringCh(4).'gr'.$rId.generateRandomNumStringCh(4);
			$this->db->where('rId',$rId); 
			$this->db->update('general_reports', array("erId"=>$erId));
            $this->session->set_flashdata('success', 'Report Updated.');
        }			
		return 'success||'.base_url().'general_reports/view/'.$erId;
	}

    public function updateAIreport(){
        $topicName = $_POST['txt_topicName'];
		$reportSummary = $_POST['txt_aisummary'];
        $rId = $_POST['ai_rId'];
        $erId = $_POST['ai_erId'];
        $time = time();
        $this->db->where('rId',$rId); 
        $this->db->update('general_reports', array('topicName'=>$topicName,'reportSummary'=>$reportSummary, 'lastUpdatedOn'=>$time));
        $this->session->set_flashdata('success', 'Report Updated.');
        return 'success||'.base_url().'general_reports/view/'.$erId;
    }

    public function deleteReport($rIds){
		$where = ' rId in ('.$rIds.')';
		$this->db->where($where);
		$this->db->update('general_reports', array("isDeleted"=>1));
		$this->session->set_flashdata('success', 'Deleted successfully.');	
	}

}