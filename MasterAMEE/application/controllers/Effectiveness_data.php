<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Effectiveness_data extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
		$this->data['activity_name']='Unit Effectiveness';
		$activity_name = 'effectiveness_data';
		time_tracking_management_ch($activity_name); 
 	}
	
	public function index(){
			
		$this->data['page_title']='Create Step 5 : Measurement Tools'; 
		$this->data['action_menu']='3'; 
		$this->data['effectiveness_data_listing'] = $this->Effectiveness_data_mdl->effectiveness_data_listing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/effectiveness_data/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function manage(){
			
		$this->data['page_title']='Create Step 5 : Measurement Tools'; 
		$this->data['action_menu']='3'; 
		if(isset($_GET['data_id']) && $_GET['data_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			$this->data['effectiveness_data'] = $this->Effectiveness_data_mdl->get_effectiveness_data_fulldetails($_GET['data_id'],$_GET['dept_id']);
			$this->data['program_year_listing'] = $this->Effectiveness_data_mdl->get_program_year_listing($_GET['dept_id'],$_GET['data_id']);
		
		}
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/effectiveness_data/manage',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function manage_unit_effectiveness_data(){
		
		if(isset($_GET['data_id']) && $_GET['data_id']!=''){
			$data_id=$_GET['data_id'];
		}else{
			$data_id=0;
		}
		$dept_id = $this->session->userdata('dept_id');
		$this->Effectiveness_data_mdl->manage_unit_effectiveness_data($dept_id,$data_id);
	} 
	
	public function add_program_year_entry(){
		
		if(isset($_GET['data_id']) && $_GET['data_id']!=''){
			$data_id=$_GET['data_id'];
			$dept_id = $this->session->userdata('dept_id');
			$tab = $_GET['tab'];
			$this->Effectiveness_data_mdl->add_program_year_entry($dept_id,$data_id);
		}
		
		redirect(base_url().'department/create/effectiveness_data/manage?tab='.$tab.'&data_id='.$data_id.'&dept_id='.$dept_id);
		
	}
	
	public function save_indicators(){
		if(isset($_GET['data_id']) && $_GET['data_id']!=''){
			$data_id=$_GET['data_id'];
			$dept_id = $this->session->userdata('dept_id');
 			$this->Effectiveness_data_mdl->save_indicators($dept_id,$data_id);
		}
		redirect(base_url().'department/create/effectiveness_data/manage?tab=2&data_id='.$data_id.'&dept_id='.$dept_id);
	} 


	public function archive_delete_effectiveness(){
		$this->Effectiveness_data_mdl->archive_delete_effectiveness();
		redirect(base_url().'department/create/effectiveness_data');
	}
	
	
}