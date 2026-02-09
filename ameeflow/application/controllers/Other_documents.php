<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Other_documents extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 
        $this->data['sessionDetailsArr'] = chkAFUserLoggedIn($this->session->userdata('AFSESS_USERACCESSID'));		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
        $this->load->model('Other_documents_mdl'); 	
		$this->load->model('Projects_mdl'); 	  
        $this->data['active_class'] = 'documents-menu';
        $this->data['title'] = 'Other Documents - '.$this->config->item('product_name');
 	}

    public function index(){         
        $this->data['pageTitle'] = 'Other Documents';
		$universityId = $this->data['sessionDetailsArr']['universityId'];
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
		$userId = $this->data['sessionDetailsArr']['userId'];

		$this->data['projectDataArr'] = $this->Projects_mdl->projectDataArr($uniAdminId);

		$this->data['documentsDataArr'] = array();
		$assignProjectsDataArr = $this->Projects_mdl->userAssignProjectsDataArr($userId); 
		//echo '<pre>';print_r($assignProjectsDataArr);die;
		if(count($assignProjectsDataArr)>0){
			$proIdArr = array();
			foreach($assignProjectsDataArr as $asp){
				$proIdArr[] = $asp['projectId'];
			}
			$projectIds = implode(',',$proIdArr);
			$this->data['documentsDataArr'] = $this->Other_documents_mdl->usersDocumentsDataArr($uniAdminId,$projectIds);
		}
		// echo '<pre>';print_r($this->data['documentsDataArr']);die;
		$this->load->view('Frontend/includes/header',$this->data);		 
		$this->load->view('Frontend/reports/other-doc',$this->data);
		$this->load->view('Backend/includes/footer',$this->data);         
	}

}