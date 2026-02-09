<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends CI_Controller {
 	 
	function __construct(){
		parent::__construct(); 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='Design_menu';
		$this->data['title']='Design Step 3 : Rotation Schedule Planning'; 
		$activity_name = 'design';
		time_tracking_management_ch($activity_name); 
 	}
	
	
	public function index(){
		$this->data['activity_name']='Overview';
		if(isset($_POST['design_save'])&& $_POST['design_save']!=''){
			$this->Design_mdl->design_save_action1();
			redirect('department/design/action1');
		}
		if(isset($_POST['design_next'])&& $_POST['design_next']!=''){
			$this->Design_mdl->design_save_action1();
			redirect('department/design/action2');
		}		
		if(isset($_POST['design_next_action3'])&& $_POST['design_next_action3']!=''){
			$this->Design_mdl->design_save_action1();
			redirect('department/design/action3');
		}
		
		$this->data['page_title']='Design Step 3 : Rotation Schedule Planning'; 
		$this->data['action_menu']='1'; 
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/design/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function action2(){
		$this->data['activity_name']='Team Members';
		$this->data['page_title']='Design Step 3 : Rotation Schedule Planning'; 
		$this->data['action_menu']='2'; 
		$this->data['team_members_detail_group_by'] = $this->Design_mdl->team_members_detail_group_by();  
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/design/action2',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function add_team_members(){
		$this->Design_mdl->add_team_members();
	}
	
	public function edit_team_members(){
		$this->Design_mdl->edit_team_members();
	}	
	
 	public function delete(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->Design_mdl->delete_members($id);
		redirect('department/design/action2');
	}
 	

	public function action3(){
		$this->data['activity_name']='Rotation Plan';
		$this->data['page_title']='Design Step 3 : Rotation Schedule Planning'; 
		$this->data['action_menu']='3';		
		
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate(); 
		$this->data['program_learning_outcomes_data'] = $this->Envision_mdl->program_learning_outcomes();
		
		$this->data['department_courses_result_undergraduate'] = $this->Coordinate_mdl->department_courses_result_undergraduate();
		$this->data['department_courses_result_graduate'] = $this->Coordinate_mdl->department_courses_result_graduate();
		$this->data['department_programs_align_matrix'] = $this->Coordinate_mdl->department_programs_align_matrix();
		
		$this->data['rotation_plan_start_year'] = $this->Design_mdl->get_rotation_plan_year($this->session->userdata('dept_id')); 
		$this->data['rotation_plan_count'] = $this->config->item('rotation_year_plans');
		$this->data['team_members_detail_group_by'] = $this->Design_mdl->team_members_detail_group_by();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/design/action3',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}
	
	public function change_rotation_plan_year(){
		
		$year = $_GET['year'];
		$underg_grad_status = $_GET['status'];
		$this->Design_mdl->change_rotation_plan_year($year);
		if($underg_grad_status==1){
			redirect('department/design/action3?tab_id=2');
		}else if($underg_grad_status==2){
			redirect('department/design/action3?tab_id=3');
		}else{
			redirect('department/design/action3');
		}
		
	}
	
	public function manage_rotation_plan_status(){
	
		$rotation_plan_status = $_GET['rotation_plan_status'];
		$underg_grad_status = $_GET['status'];
		$this->Design_mdl->manage_rotation_plan_status($rotation_plan_status,$underg_grad_status);
 		if($underg_grad_status==1){
			redirect('department/design/action3?tab_id=2');
		}else if($underg_grad_status==2){
			redirect('department/design/action3?tab_id=3');
		}else{
			redirect('department/design/action3');
		}
		
	}
	
	public function save_manual_rotation_plan(){
		$this->Design_mdl->save_manual_rotation_plan();
	}
	
	public function save_automatic_rotation_plan(){
		$this->Design_mdl->save_automatic_rotation_plan();
	}
 	
	
}