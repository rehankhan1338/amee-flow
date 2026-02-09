<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignments_rubrics extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
		$this->data['page_title']='Create Step 5 : Measurement Tools'; 
		$this->data['action_menu']='5'; 		
		$this->data['activity_name']='Assignments Rubrics';
		$activity_name = 'assignments_rubrics';
		time_tracking_management_ch($activity_name); 
 	}
 	
 	/*public function truncate_rubrics(){   
		$this->db->truncate('assignments'); 
		$this->db->truncate('assignments_rubrics_builder'); 
		$this->db->truncate('assignments_rubrics_builder_heading'); 
		$this->db->truncate('assignments_rubrics_builder_option'); 
		$this->db->truncate('assignments_upload_instruction'); 	 
		$this->db->truncate('assignment_courses');  
		$this->db->truncate('assignment_questions');  
		$this->db->truncate('assignment_question_choices');  
		$this->db->truncate('assingment_email'); 
  		$this->db->truncate('assingment_question_answer');  
		$this->db->truncate('assingment_raters_email');  
		$this->db->truncate('assingment_raters_feedback');	
		$this->db->truncate('assingment_raters_ratings');	
	}*/		
	
	public function index(){	
		$this->data['assignments_rubrics_listing'] = $this->Assignments_rubrics_mdl->department_assignments_rubrics_listing();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/assignments_rubrics/view',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}	
	
	public function update_assignment_status_btn(){
		$status = $_GET['status'];
		$id = $_GET['id'];
 		$this->Assignments_rubrics_mdl->update_assignment_status_btn($status,$id);	
	}
	
	public function manage(){
		if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
			$ar_id = $_GET['ar_id'];
			$this->data['assignments_rubrics_row'] = $this->Assignments_rubrics_mdl->assignments_rubrics_row($ar_id, $_GET['dept_id']);
			$this->data['assignments_rubrics_course_detail'] = $this->Assignments_rubrics_mdl->assignments_rubrics_course_detail($ar_id);
  			$this->data['assignments_rubrics_questions_detail'] = $this->Assignments_rubrics_mdl->assignments_rubrics_questions_detail($ar_id);
 			$this->data['assignments_user_result'] = $this->Assignments_rubrics_mdl->get_assignments_user_result($ar_id,$_GET['dept_id']);
			
			$this->data['assignments_complete_incomplete_user_result'] = $this->Assignments_rubrics_mdl->get_assignments_complete_incomplete_user_result($ar_id,$_GET['dept_id']);
			
			$this->data['assingment_courses_detail'] = $this->Assignment_mdl->assingment_courses_detail($ar_id);
			$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
			$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
		}
		if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){
			$this->data['assingment_auth_code_detail'] = $this->Assignment_mdl->assingment_auth_code_detail($_GET['auth_code']);
		}
		$this->data['assignments_valid_user_result'] = $this->Assignments_rubrics_mdl->get_assignments_valid_user_result($ar_id,$_GET['dept_id']);
		$this->data['assignments_invalid_user_result'] = $this->Assignments_rubrics_mdl->get_assignments_invalid_user_result($ar_id,$_GET['dept_id']);
		$this->data['assingment_rubric_builder_category_list'] = $this->Assignment_mdl->assingment_rubric_builder_category_list($ar_id);
		$this->data['drap_drop_js'] = 1;
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/assignments_rubrics/manage',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
		
	public function save_email(){
		if(isset($_POST['h_assingment_id']) && $_POST['h_assingment_id']!=''){
			$this->data['assingment_details'] = $this->Assignments_rubrics_mdl->assingment_fulldetails($_POST['h_assingment_id']);
			$assignment_code = $this->data['assingment_details']->assignment_code;
			$this->Assignments_rubrics_mdl->save_email($assignment_code);
		}
	}
	
	public function delete_course(){
		if(isset($_GET['id']) && $_GET['id']!='' || isset($_GET['ar_id']) && $_GET['ar_id']!=''){
			$this->Assignments_rubrics_mdl->delete_course($_GET['id'], $_GET['ar_id']);
		}
	}	
	
	public function document_save(){
		$dept_id = $this->session->userdata('dept_id');		
		$this->Assignments_rubrics_mdl->document_save($dept_id);	
	}	
	
	public function save_instructions(){
		if(isset($_GET['ar_id']) && $_GET['ar_id']!=''){
			$ar_id = $_GET['ar_id'];$dept_id = $this->session->userdata('dept_id');		
			$this->Assignments_rubrics_mdl->save_instructions($dept_id,$ar_id);
 		} 
	
	}

	public function set_assignment(){
		if(isset($_GET['ar_id']) && $_GET['ar_id']!=''){
			$ar_id = $_GET['ar_id'];
		}else{
			$ar_id=0;
		}
		$dept_id = $this->session->userdata('dept_id');		
		$this->Assignments_rubrics_mdl->set_assignment($dept_id,$ar_id);	
	}	
	
	public function archive_delete_analysis_review(){
		$this->Assignments_rubrics_mdl->archive_delete_analysis_review();
		redirect(base_url().'department/create/assignments_rubrics');
	}
	
	public function delete_prepare_document(){
		$this->Assignments_rubrics_mdl->delete_prepare_document();
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=4&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id']);
	}	
	
	public function add_deadline(){
		$this->Assignments_rubrics_mdl->add_deadline();
	}
	
	public function add_course(){
		$this->Assignments_rubrics_mdl->add_course();
	}	

	public function manage_rubric_builder(){
		$this->Assignments_rubrics_mdl->manage_rubric_builder();
	}	
	
	public function manage_rubric_criterion(){
		$this->Assignments_rubrics_mdl->manage_rubric_criterion();
	}
	
	public function update_rubric_status(){
		if(isset($_GET['status'])&& $_GET['status']!='' && isset($_GET['ar_id'])&& $_GET['ar_id']!=''){
			$status = $_GET['status'];
			$assignment_id = $_GET['ar_id'];			
			$this->Assignments_rubrics_mdl->update_rubric_status($status, $assignment_id);
		}	
	}	
	
	public function update_rubric_builder(){		
		$this->Assignments_rubrics_mdl->update_rubric_builder();
	}	
	
	
	
//===----- Demograpic Questions -----===//
	public function add_question(){
		$last = $this->uri->total_segments();
		$ar_id = $this->uri->segment($last);
		$dept_id = $this->session->userdata('dept_id');		
		
		$this->data['assignments_rubrics_row'] = $this->Assignments_rubrics_mdl->assignments_rubrics_row($ar_id,$dept_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/assignments_rubrics/add_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function get_default_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/assignments_rubrics/default_choices',$this->ajax_data);
		}
	}
	
	public function get_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/assignments_rubrics/anser_actions',$this->ajax_data);
		}
	}
	
	public function question_save(){
		$ar_id = $this->input->post('hidden_ar_id');
		$dept_id = $this->session->userdata('dept_id');
		if(isset($ar_id) && $ar_id!=''){
			$this->Assignments_rubrics_mdl->question_save($ar_id,$dept_id);
		}
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=2&ar_id='.$ar_id.'&dept_id='.$dept_id);
	}
	
	public function set_order_questions(){
		$this->Assignments_rubrics_mdl->set_order_questions();
	}
	
		
	public function question_description(){
		if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->data['assignments_rubrics_question_details'] = $this->Assignments_rubrics_mdl->get_assignments_rubrics_question_details($_GET['ar_id'],$_GET['question_id']);
			$question_type = $this->data['assignments_rubrics_question_details']->question_type;
			
			if(isset($question_type) && $question_type==1){
				$this->data['assignments_rubrics_question_ansers_details'] = $this->Master_helper_mdl->get_choics_of_multiple_type_question_rubrics($_GET['question_id']);
			}
 			$this->load->view('Frontend/create/assignments_rubrics/assignment_question_description',$this->data);
		}
	}
	
			
	public function edit_question(){ 
		$dept_id = $this->session->userdata('dept_id');	
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);

		$this->data['assignments_rubrics_questions_fulldetails'] = $this->Assignments_rubrics_mdl->get_assignments_rubrics_questions_fulldetails($question_id);		
		$ar_id = $this->data['assignments_rubrics_questions_fulldetails']->ar_id;
		$this->data['assignments_rubrics_row'] = $this->Assignments_rubrics_mdl->assignments_rubrics_row($ar_id,$dept_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/assignments_rubrics/edit_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
		
	public function update_question_entry(){
		$this->Assignments_rubrics_mdl->update_question_entry();
	}		
	 
	public function delete_question_choice(){
		if(isset($_GET['answer_id']) && $_GET['answer_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->Assignments_rubrics_mdl->delete_question_choice($_GET['answer_id'],$_GET['question_id'],$_GET['question_type']);
		}
 	}
 	
 	public function delete_assignments_rubrics_question(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['ar_id']) && $_GET['ar_id']!=''){
			$this->Assignments_rubrics_mdl->delete_assignments_rubrics_question($_GET['question_id'],$_GET['ar_id']);
		}
 	} 	
	
	public function display_raters_page(){
		if(isset($_GET['change_to']) && $_GET['change_to']!='' && isset($_GET['id']) && $_GET['id']!=''){
		
			$change_to = $_GET['change_to'];
			$id = $_GET['id'];
			$dept_id=$this->session->userdata('dept_id');
			$this->data['id'] = $id;
			$this->data['change_to'] = $this->Assignments_rubrics_mdl->update_display_raters_page($change_to,$id);
			$this->load->view('Frontend/create/assignments_rubrics/results/ajax_display_raters_page',$this->data); 
		
		}	
	}
	
	/*public function ajax_answer_details(){
		if(isset($_GET['assingment_id']) && $_GET['assingment_id']!='' && isset($_GET['auth_code']) && $_GET['auth_code']!=''){
		
		$assingment_id = $_GET['assingment_id'];
		$auth_code = $_GET['auth_code'];
		$dept_id=$this->session->userdata('dept_id');
		
		$this->data['auth_code'] = $auth_code;
		$this->data['assignments_rubrics_row'] = $this->Assignments_rubrics_mdl->assignments_rubrics_row($assingment_id,$dept_id);	
		$this->data['assignments_rubrics_questions_detail'] = $this->Assignments_rubrics_mdl->assignments_rubrics_questions_detail($assingment_id);
		$this->load->view('Frontend/create/assignments_rubrics/results/answer_details',$this->data); 
		
		}	
	}*/
	
}