<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller { 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
 	}	
	
	function updateNotificationCookie(){
		if(isset($_GET['notiIds']) && $_GET['notiIds']!=''){
			$this->Auth_mdl->insertNotiDismissEntry($_GET['notiIds']);
		}
		notificationsCookieUpdatech($_GET['deptId'],'dismiss_btn');
	}
	
	public function index(){ 
		$this->data['title']='Department Login - '.$this->config->item('project_name_page_first'); 
		$this->load->view('Frontend/login/view',$this->data);   			
	}
	
	public function check_login(){ 
		echo $this->Auth_mdl->department_check_login();
	}	
	
	public function logout(){
		//-For use header(setInterval)
		$department_id = $this->session->userdata('dept_id');
		$session_start_date_time = $this->session->userdata('session_start_date_time');
		$arr = array('session_end_date_time'=>time());		
		$this->db->where('department_id', $department_id);
		$this->db->where('session_start_date_time', $session_start_date_time);
		$this->db->update('department_time_tracker', $arr);				
			
		$this->session->sess_destroy();
		redirect(base_url());
	}
 	
	public function forgot_password(){
		$this->data['title'] = 'Reset your password - '.$this->config->item('project_name_page_first'); 
		$this->data['page_title'] = 'Reset your password'; 
		$this->data['captcha_text'] = $this->generateRandomString();
		$this->load->view('Frontend/forgot_password/view',$this->data);
	}
	
	public function forgot_password_send_mail(){
		echo $this->Forgot_password_mdl->forgot_password();
	}
	
	public function generateRandomString($length = 5) {
		$characters = '123456789abdefghnqrstuABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
		
	public function recover_password(){		 
		$current_date = time();
		$encrpted_id = $this->uri->segment(3);
		$sha_forgot = $this->uri->segment(4);		
		$this->db->where('id', $encrpted_id);
		$this->db->where('temp_forget', $sha_forgot);
		$query = $this->db->get('departments');
		$num = $query->num_rows();
		if($num==0){	
			$this->session->set_flashdata('error', str_msg21);
			redirect(base_url()."forgot_password");
		}else{
		
			$row = $query->row();
			if($current_date>$row->expire_temp_forget_link){				
				$this->session->set_flashdata('error', str_msg22);
				redirect(base_url()."forgot_password");			
			}else{				 
				$this->form_validation->set_rules('new_password', 'Password', 'required'); 
				$this->form_validation->set_rules('confirm_password','Confirm Password','required'); 		
				if($this->form_validation->run() === FALSE){		
					$this->data['title'] = 'Change password - '.$this->config->item('project_name_page_first'); 
					$this->data['page_title'] = 'Change password';
					$this->load->view('Frontend/forgot_password/change_password',$this->data);				
				}else{	
					$this->Forgot_password_mdl->recover_password($encrpted_id,$sha_forgot);
				} 			
			}			
		}
	}
	
	
	 public function dashboard(){ 
	 	$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id'));
		
		$this->data['title']='Department Panel - '.$this->config->item('project_name_page_first');  
		$this->data['page_title']='Dashboard'; 
		$this->data['page_sub_title']='This is a sample description of a page'; 
		//$this->data['job_postings'] = $this->Teaching_pool_mdl->job_postings_list(); 
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/dashboard/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
		 
 	}
 	
 	
 	public function profile(){
	 	$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id'));
		$this->data['title']='Profile - '.$this->config->item('project_name_page_first');  
		$this->data['active_class']='profile';
		
		$this->form_validation->set_rules('first_name','First Name','required'); 
		$this->form_validation->set_rules('last_name','Last Name','required'); 
		$this->form_validation->set_rules('email','Email','required'); 
		
		if ($this->form_validation->run() == FALSE){
			$this->data['page_title']='Profile';  
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/profile/edit_profile',$this->data);
			$this->load->view('Frontend/includes/footer');
		}else{
			$this->Auth_mdl->update_profile();
			redirect(base_url()."home/profile");
		}	
 	}
 		
 	
 	public function account(){
	 	$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id'));
		$this->data['title']='Account - '.$this->config->item('project_name_page_first');  
		$this->data['active_class']='Profile';
		
		$this->form_validation->set_rules('user_name','User Name','required'); 
		
		if ($this->form_validation->run() == FALSE){
			$this->data['page_title']='Account Setting';
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/profile/account',$this->data);
			$this->load->view('Frontend/includes/footer');
		}else{
			$this->Auth_mdl->account_setting();
		}	
 	}
 	
	
	/*public function truncate_setup_new(){   
	
		$this->db->truncate('analyze_closing_loop_program_year'); // 23
		$this->db->truncate('analyze_closing_loop_year_value'); 
		
		$this->db->truncate('assignments'); // 14
		$this->db->truncate('assignments_rubrics_builder'); 
		$this->db->truncate('assignments_rubrics_builder_heading'); 
		$this->db->truncate('assignments_rubrics_builder_option'); 
		$this->db->truncate('assignments_upload_instruction'); 	 
		$this->db->truncate('assignments_user_upload_instruction');
		$this->db->truncate('assignment_courses');  
		$this->db->truncate('assignment_questions');  
		$this->db->truncate('assignment_question_choices');  
		$this->db->truncate('assingment_email'); 
  		$this->db->truncate('assingment_question_answer');  
		$this->db->truncate('assingment_raters_email');  
		$this->db->truncate('assingment_raters_feedback');	
		$this->db->truncate('assingment_raters_ratings');
		
		$this->db->truncate('census_data');
		$this->db->truncate('census_options_data');		
		
		$this->db->truncate('data_commons'); 
		$this->db->truncate('departments'); 
		$this->db->truncate('department_allignment_matrix'); 	 
		$this->db->truncate('department_assign_core_competency');  
		$this->db->truncate('department_automatic_rotation_plan');  
		$this->db->truncate('department_automatic_rotation_plan_academic_courses');  
		$this->db->truncate('department_checklist_data'); 
  		$this->db->truncate('department_checklist_detail');  
		$this->db->truncate('department_courses');  
		$this->db->truncate('department_feedbacks');	
		$this->db->truncate('department_manual_rotation_plan');
 		$this->db->truncate('department_manual_rotation_plan_academic_courses'); 
		
		$this->db->truncate('department_measurement_benchmark_tabular'); 
		$this->db->truncate('department_pslos');   
		$this->db->truncate('department_team_members'); 
		$this->db->truncate('department_time_tracker');  
		$this->db->truncate('department_time_tracker_reset'); 
 		$this->db->truncate('email_ameeid');
		 
		$this->db->truncate('import_error_log');  // 2
  		$this->db->truncate('temp_import_table'); 
  				
		$this->db->truncate('surveys'); // 10
		$this->db->truncate('surveys_questions');  
		$this->db->truncate('survey_answers');
		$this->db->truncate('survey_answers_skip_logics');
		$this->db->truncate('survey_email'); 
		$this->db->truncate('survey_question_answers');
		$this->db->truncate('survey_question_choices');  
		$this->db->truncate('survey_question_choices_conditions'); 
		$this->db->truncate('survey_sweepstakes'); 	
		
		$this->db->truncate('tests'); // 7
		$this->db->truncate('tests_course'); 
		$this->db->truncate('tests_email'); 
		$this->db->truncate('tests_questions'); 
		$this->db->truncate('test_answers'); 	
		$this->db->truncate('test_criterion_option');
		$this->db->truncate('test_question_answers');
		
		$this->db->truncate('unit_analysis');  // 5
		$this->db->truncate('unit_analysis_core_functions'); 
		$this->db->truncate('unit_effectiveness_data');  
		$this->db->truncate('unit_effectiveness_data_program_year'); 
		$this->db->truncate('unit_effectiveness_data_value'); 
		
		
		$this->db->truncate('department_analysis');
		$this->db->truncate('department_analysis_reporting');
		$this->db->truncate('department_logic_models');
		$this->db->truncate('notifications_accepted');
			
	}*/



 	
} 