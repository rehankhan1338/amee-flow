<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Analyze extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='Analyze_menu';
		$this->data['title']='Analysis Reporting'; 
		$activity_name = 'analyze';
		time_tracking_management_ch($activity_name); 
 	} 	
 
	public function index(){		
		$this->data['page_title']='';
		$this->data['myDeptReportListing'] = $this->Analyze_mdl->myDeptReportListing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/analyze/list',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function ajax_submit_report(){	
		echo $this->Analyze_mdl->ajax_submit_report($_GET['reportId']);
	}
	
	public function create_report(){	
		echo $this->Analyze_mdl->create_report($this->session->userdata('dept_id'));
	}
	
	public function edit_report(){	
		echo $this->Analyze_mdl->edit_report($this->session->userdata('dept_id'));
	}
	
	public function setPriority(){	
		$this->Analyze_mdl->setPriority();
	}
	
	public function deleteReportOption(){
		if(isset($_GET['id']) && $_GET['id']!=''){	
			$this->Analyze_mdl->deleteReportOption($_GET['id']);
			echo 'success';
		}		
	}
	
	public function deleteReport(){
		if(isset($_GET['id']) && $_GET['id']!=''){	
			echo $this->Analyze_mdl->deleteReport($_GET['id']);
		}
		redirect(base_url().'department/analyze');		
	}
	
	public function view(){	
		$encryptReportId = $this->uri->segment(3);	
		$this->data['deptReportDetails'] = $this->Analyze_mdl->reportDetails($encryptReportId);
		//echo '<pre>';print_r($this->data['reportDetails']);die;
		$this->data['page_title']=$this->data['deptReportDetails']->reportTitle.' - '.$this->data['deptReportDetails']->reportYear.' Analysis Reporting';
		$this->data['optionsMasterArr'] = $this->Analyze_mdl->optionsMasterFromWebDB();
		$this->data['myDeptReportingData'] = $this->Analyze_mdl->myDeptReportingData($this->session->userdata('dept_id'),$this->data['deptReportDetails']->reportId);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/analyze/deptReport',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function save_my_reporting(){	
		echo $this->Analyze_mdl->save_my_reporting($this->session->userdata('dept_id'));
	}

	public function save_loops_description(){	
		$this->Analyze_mdl->save_loops_description();
	}
	
	public function getTypeDetails(){	
		$this->data['optionDetails'] = $this->Analyze_mdl->optionsDetailsFromWebDB($_GET['id']);
		$this->load->view('Frontend/analyze/ajax_report_type_details',$this->data);
	}
	
	public function ajaxEditReportingDetails(){	
		$this->data['optionsMasterArr'] = $this->Analyze_mdl->optionsMasterFromWebDB();
		$this->data['deptReptDetails'] = $this->Analyze_mdl->ajaxDeptReptDetails($_GET['id']);
		$this->load->view('Frontend/analyze/ajax_dept_report_details',$this->data);
	}	
	
	public function upload_document(){
		$action_status = '1'; // 1=Closing Loop, 2=Run Reports		
		$this->data['page_title']='Analyze Step 6 : 360<sup><i class="fa fa-circle-o" style="font-size: 13px;" aria-hidden="true"></i></sup> - Closing the Loop';
		$this->data['department_reports_detail'] = $this->Analyze_mdl->department_reports_detail($action_status);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/analyze/upload_document',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function upload(){	
		$department_id = $this->session->userdata('dept_id');
		$action_status = '1'; // 1=Closing Loop, 2=Run Reports
		$this->Analyze_mdl->save_upload($department_id,$action_status);
		redirect('department/analyze/upload/document');		
	}	

}