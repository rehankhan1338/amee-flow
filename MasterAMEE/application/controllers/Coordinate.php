<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinate extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='coordinate_menu';
		$this->data['title']='Coordinate Step 2 : Alignment Matrix Planning';
		$activity_name = 'co-ordinate';
		time_tracking_management_ch($activity_name);  
 	}
	

	public function index(){
		$this->data['activity_name']='Overview';
		if(isset($_POST['coordinate_save'])&& $_POST['coordinate_save']!=''){
			$this->Coordinate_mdl->coordinate_save_action1();
 			$this->session->set_flashdata('success', 'Update Successfully!');	
			redirect('department/coordinate/action1');
		}
		if(isset($_POST['coordinate_next'])&& $_POST['coordinate_next']!=''){
			$this->Coordinate_mdl->coordinate_save_action1();
			redirect('department/coordinate/action2');
		}
		
		if(isset($_POST['coordinate_next_action3'])&& $_POST['coordinate_next_action3']!=''){
			$this->Coordinate_mdl->coordinate_save_action1();
			redirect('department/coordinate/action3');
		}
		
		$this->data['page_title']='Coordinate Step 2 : Alignment Matrix Planning'; 
		$this->data['action_menu']='1'; 
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/coordinate/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	
	public function action2(){
		$this->data['activity_name']='Required Courses';
		$this->data['page_title']='Coordinate Step 2 : Alignment Matrix Planning'; 
		$this->data['action_menu']='2'; 
		$this->data['department_courses_result_undergraduate'] = $this->Coordinate_mdl->department_courses_result_undergraduate();
		$this->data['department_courses_result_graduate'] = $this->Coordinate_mdl->department_courses_result_graduate();
		$this->data['department_programs_align_matrix'] = $this->Coordinate_mdl->department_programs_align_matrix();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/coordinate/action2',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function add_courses_ugrad_grad_entry(){
		$this->Coordinate_mdl->department_courses_add();
	}	
	
	public function edit_courses_ugrad_grad_entry(){
		$this->Coordinate_mdl->edit_courses_ugrad_grad_entry();
	}	
	
	public function delete_courses_ugrad_grad_entry(){
		$this->Coordinate_mdl->delete_courses_ugrad_grad_entry($_GET['id']);
	}
	
	public function upload_courses(){
		
		$last = $this->uri->total_segments();
		$course_status = $this->uri->segment($last);
		
		if(isset($course_status) && ($course_status=='undergraduate' || $course_status=='graduate')){
		
			$this->data['page_title']='Coordinate Step 2 : Alignment Matrix Planning';
			$this->data['action_menu']='2'; 
			$this->data['course_status']=$course_status; 
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/coordinate/upload',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 	
		
		}else{
		
			redirect('department/coordinate/action2');
		}	
	}
	
	public function import_data_review_courses(){
		
  		$last = $this->uri->total_segments();
		$course_status = $this->uri->segment($last);
		
		if(isset($course_status) && ($course_status=='undergraduate' || $course_status=='graduate')){
		
			$this->data['page_title']='Coordinate Step 2 : Alignment Matrix Planning';
			$this->data['action_menu']='2';
			$this->data['course_status']=$course_status; 
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/coordinate/import',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 	
		
		}else{
		
			redirect('department/coordinate/action2');
		}
	}
	
	public function import_data_courses(){
	
		$last = $this->uri->total_segments();
		$course_status = $this->uri->segment($last);
		
		if(isset($course_status) && ($course_status=='undergraduate' || $course_status=='graduate')){
		
			if($course_status=='undergraduate'){
				$course_status_int = '0';
			}else{
				$course_status_int = '1';
			}
			$this->Coordinate_mdl->import_data_courses($course_status_int);			
			
		}else{
		
			redirect('department/coordinate/action2');
		}
	}
		
	
	public function action3(){
		$this->data['activity_name']='Course Levels';
		$this->data['page_title']='Coordinate Step 2 : Alignment Matrix Planning'; 
		$this->data['action_menu']='3'; 
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
		$this->data['program_learning_outcomes_data'] = $this->Envision_mdl->program_learning_outcomes();
		
		$this->data['department_courses_result_undergraduate'] = $this->Coordinate_mdl->department_courses_result_undergraduate();
		$this->data['department_courses_result_graduate'] = $this->Coordinate_mdl->department_courses_result_graduate();
		$this->data['department_programs_align_matrix'] = $this->Coordinate_mdl->department_programs_align_matrix();
		
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/coordinate/action3',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function save_undergraduate_allignment_matrix(){
		
		$this->Coordinate_mdl->save_undergraduate_allignment_matrix();
	}
	
	public function save_graduate_allignment_matrix(){
	
		$this->Coordinate_mdl->save_graduate_allignment_matrix();
	}
	
	public function save_program_allignment_matrix(){
	
		$this->Coordinate_mdl->save_program_allignment_matrix();
	}
	
	
}