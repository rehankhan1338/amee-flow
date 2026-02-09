<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Close_the_loop extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct(); 	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='ClosingLoop_menu';
		$this->data['title']='Closing The Loop'; 
		$activity_name = 'close_the_loop';
		time_tracking_management_ch($activity_name); 
 	} 	
	
	public function index(){
		$this->data['page_title']='';
		$this->data['closing_loop_list'] = $this->Analyze_mdl->get_closing_loop_list($this->session->userdata('dept_id'));
		//$this->data['program_year_listing'] = $this->Analyze_mdl->get_program_year_listing($this->session->userdata('dept_id'));
		//$this->data['indicatorMasters'] = $this->Analyze_mdl->indicatorMasters();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/close_the_loop/viewall',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function view(){
		$encryptLoopId = $this->uri->segment(3);
		$this->data['loop_details'] = $this->Analyze_mdl->get_loop_details($encryptLoopId); 
		$this->data['page_title']=$this->data['loop_details']->yearTitle.' '.$this->data['loop_details']->year.' - Closing Loop';			
 		$this->data['closing_loop_data_arr'] = $this->Analyze_mdl->get_closing_loop_data($this->data['loop_details']->loopId);		
		$this->data['indicatorMasters'] = $this->Analyze_mdl->indicatorMasters();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/close_the_loop/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function add(){
		$this->data['page_title']='Closing The Loop : : Add Year';
		$this->data['form_action']='close_the_loop/add_program_year_entry';
		$this->data['btnText']='Add Now!';
		//$this->data['program_year_listing'] = $this->Analyze_mdl->get_program_year_listing($this->session->userdata('dept_id'));
		$this->data['indicatorMasters'] = $this->Analyze_mdl->indicatorMasters();
		$this->data['closing_loop_data_arr'] = array();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/close_the_loop/year_manage',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function save_closing_loop(){
		$dept_id = $this->session->userdata('dept_id');
 		$this->Analyze_mdl->save_closing_loop($dept_id);
		redirect(base_url().'analyze/closed_loop');
	}
	
	public function edit(){
		$encryptLoopId = $this->uri->segment(3);
		if(isset($encryptLoopId) && $encryptLoopId!=''){
			$this->data['loop_details'] = $this->Analyze_mdl->get_loop_details($encryptLoopId);	
			$this->data['closing_loop_data_arr'] = $this->Analyze_mdl->get_closing_loop_data($this->data['loop_details']->loopId);		
			$this->data['indicatorMasters'] = $this->Analyze_mdl->indicatorMasters();	
			
			$this->data['page_title']='Closing The Loop : : Edit Year';	
			$this->data['form_action']='close_the_loop/update_program_year_entry';	
			$this->data['btnText']='Update Now!';	
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/close_the_loop/year_manage',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 			
		}else{
			redirect(base_url().'logic_model');
		}
	}
	
	public function add_program_year_entry(){
		$dept_id = $this->session->userdata('dept_id');
		echo $this->Analyze_mdl->add_program_year_entry($dept_id);
 	}
	
	public function update_program_year_entry(){
		$dept_id = $this->session->userdata('dept_id');
		echo $this->Analyze_mdl->update_program_year_entry($dept_id);
 	}
	
	public function delete(){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$this->Analyze_mdl->closed_loop_delete($_GET['id']);
		}
		redirect(base_url().'close_the_loop');
	}
	
	
}