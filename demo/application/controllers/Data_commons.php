<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_commons extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='data_commons_menu';
		$this->data['data_commons_page_enable']='1';
		$this->data['title']='Data Commons'; 
		$this->data['page_title']='Data Commons'; 
		$this->data['page_description']='The decision to share assessment data with others across your campus is a great way to compare outcome achievement in your program and is as easy as 1-2-3. To start, download a graps or table jpg/png in your results tab. Click the Add New Data Common button and follow the prompt. Your assessment data results will be available to others across your campus in a matter of minutes.';
		$this->data['activity_name']='Data Commons';
		
 	} 	
 	
 	public function index(){ 			
 		$this->data['data_commons_details']=$this->Data_commons_mdl->data_commons_details();
 		$this->data['data_commons_details_not_dept_id']=$this->Data_commons_mdl->data_commons_details_not_dept_id();		
		$this->data['master_survey_types']=$this->Data_commons_mdl->master_survey_types();		
		$this->data['core_competency_details']=$this->Core_competency_mdl->core_competency_details();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/data_commons/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	 			
	public function add(){ 	
		$dept_id = $this->session->userdata('dept_id');
		$this->Data_commons_mdl->add_data_commons($dept_id); 	
		redirect(base_url().'data_commons');				
	}		
	
	public function details(){ 	
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
 		$this->data['data_commons_details']=$this->Data_commons_mdl->data_commons_details_row($id);
		$department_id = $this->data['data_commons_details']->department_id;
		$data_comm_department_details = $this->Auth_mdl->departlogin_details($department_id);
		 
		$data_type = $this->data['data_commons_details']->data_type; 
		if($data_type==1){ $data_type_heading = ' : : Survey'; }else if($data_type==2){ $data_type_heading = ' : : Assignment';} else if($data_type==3){ $data_type_heading = ' : : Test';}else{ $data_type_heading='';}
		$this->data['page_title']='Data Commons : : '.$data_comm_department_details->department_name.$data_type_heading; 
		$this->data['page_description']='';
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/data_commons/details',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 						
	}	
	
		
	public function edit(){	 
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);	
		
		$this->form_validation->set_rules('txt_title','Title','required'); 
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['data_commons_details']=$this->Data_commons_mdl->data_commons_details_row($id);
			$this->data['master_survey_types']=$this->Data_commons_mdl->master_survey_types();	
			$this->data['core_competency_details']=$this->Core_competency_mdl->core_competency_details();
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/data_commons/edit',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 	
			
		}else{
			$this->Data_commons_mdl->edit_data_commons($id); 	
			redirect(base_url().'data_commons');	
		}
	}
		
		
	public function get_type_ajax(){
		if(isset($_GET['typ'])&& $_GET['typ']!=''){$id = $_GET['typ'];
		 		
			$this->ajax_data['data_type'] = $_GET['typ']; 		
			$this->ajax_data['data_commons_details']=$this->Data_commons_mdl->data_commons_details_row($id);
			$this->ajax_data['master_survey_types']=$this->Data_commons_mdl->master_survey_types();	
			$this->ajax_data['core_competency_details']=$this->Core_competency_mdl->core_competency_details();
			
			return $this->load->view('Frontend/data_commons/open_type_ajax',$this->ajax_data);		
		}		 
		
	}
	
		
	public function delete(){ 	
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->Data_commons_mdl->delete($id); 	
		redirect(base_url().'data_commons');				
	}	
			
	
}