<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reflect extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='Reflect_menu';
		$this->data['title']='Reflect Step 4 : Assessment Schedule Planning'; 
		$activity_name = 'reflect';
		time_tracking_management_ch($activity_name); 
 	}
	
	
	public function index(){
	
		$this->data['activity_name']='Overview';
		if(isset($_POST['reflect_save'])&& $_POST['reflect_save']!=''){
			$this->Reflect_mdl->reflect_save_action1();
			redirect('department/reflect/action1');
		}
		if(isset($_POST['reflect_next'])&& $_POST['reflect_next']!=''){
			$this->Reflect_mdl->reflect_save_action1();
			redirect('department/reflect/action2');
		}		
		if(isset($_POST['reflect_next_action3'])&& $_POST['reflect_next_action3']!=''){
			$this->Reflect_mdl->reflect_save_action1();
			redirect('department/reflect/action3');
		}
		
		$this->data['page_title']='Reflect Step 4 : Assessment Schedule Planning'; 
		$this->data['action_menu']='1'; 
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reflect/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	
	public function action2(){
		$this->data['activity_name']='Measurement Tools_Benchmarks/Targets';
		$this->data['page_title']='Reflect Step 4 : Assessment Schedule Planning'; 
		$this->data['action_menu']='2'; 
		
		$this->data['rotation_plan_start_year'] = $this->Design_mdl->get_rotation_plan_year($this->session->userdata('dept_id')); 
		$this->data['rotation_plan_count'] = $this->config->item('rotation_year_plans');
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reflect/action2',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 					
	}
	
	public function update_assesment_measure_columns(){
		
		$DAM = $_GET['dam'];
		$INDAM = $_GET['indam'];
		$underg_grad_status = $_GET['underg_grad_status'];
		$dept_id = $this->session->userdata('dept_id');
		
		$this->Reflect_mdl->update_assesment_measure_columns($dept_id,$DAM,$INDAM,$underg_grad_status);
	
	}
	
	public function save_undergraduate_measurement_benchmark_tabular(){
		$dept_id = $this->session->userdata('dept_id');
		$underg_grad_status=$this->config->item('con_undergraduate_status_value');
		$underg_grad_field_name_status='undergraduate_';
		$this->Reflect_mdl->save_undergraduate_tabuler($dept_id,$underg_grad_status,$underg_grad_field_name_status);
	}
	
	public function save_graduate_measurement_benchmark_tabular(){
		$dept_id = $this->session->userdata('dept_id');
		$underg_grad_status=$this->config->item('con_graduate_status_value');
		$underg_grad_field_name_status='graduate_';
		$this->Reflect_mdl->save_undergraduate_tabuler($dept_id,$underg_grad_status,$underg_grad_field_name_status);
	}
	
	public function save_program_measurement_benchmark_tabular(){
		$dept_id = $this->session->userdata('dept_id');
		$underg_grad_status=$this->config->item('con_program_status_value');
		$underg_grad_field_name_status='program_';
		$this->Reflect_mdl->save_undergraduate_tabuler($dept_id,$underg_grad_status,$underg_grad_field_name_status);
	}
	
	public function action3(){
	
		$this->data['activity_name']='Assessment Schedule Planning';
		$this->data['page_title']='Reflect Step 4 : Assessment Schedule Planning'; 
		$this->data['action_menu']='3';		
		
		$this->data['rotation_plan_start_year'] = $this->Design_mdl->get_rotation_plan_year($this->session->userdata('dept_id')); 
		$this->data['rotation_plan_count'] = $this->config->item('rotation_year_plans');
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/reflect/action3',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}
 	
	
}