<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Survey extends CI_Controller {
 	 
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
		$this->data['action_menu']='1';
		$this->data['activity_name']='Survey';
		$activity_name = 'survey';
		time_tracking_management_ch($activity_name); 
 	}
	
	public function custom_report(){
		$this->data['survey_listing'] = $this->Survey_mdl->department_survey_listing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/custom_report',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}
	
	public function copying(){
		echo $this->Survey_mdl->surveyCopying($this->session->userdata('dept_id'));
	}
	
	public function delete_question_opt(){
		if(isset($_GET['rowId']) && $_GET['rowId']!=''){
			$this->Survey_mdl->delete_question_opt($_GET['rowId']);
		}
 		redirect(base_url().'department/create/survey/question/edit/'.$_GET['quesId']);
	}
	
	/*public function truncate_survey(){   
		$this->db->truncate('surveys'); 
		$this->db->truncate('surveys_configuration');
		$this->db->truncate('surveys_questions');  
		$this->db->truncate('survey_answers');
		$this->db->truncate('survey_answers_skip_logics');
		$this->db->truncate('survey_email'); 
		$this->db->truncate('survey_question_answers');
		$this->db->truncate('survey_question_choices');  
		$this->db->truncate('survey_question_choices_conditions'); 
		$this->db->truncate('survey_sweepstakes'); 		
	}	*/
	
	public function index(){
		$this->data['survey_listing'] = $this->Survey_mdl->department_survey_listing($this->session->userdata('dept_id'));
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/list',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function update_survey_status(){
		if(isset($_GET['surveyId']) && $_GET['surveyId']!=''){
			 $surveyId=$_GET['surveyId'];
			 $column_name=$_GET['column_name'];
			 $status=$_GET['status'];
			 echo $this->Survey_mdl->update_survey_status($surveyId,$column_name,$status);
		}
	}
	
	public function fetch_winners(){
 		$survey_winners_calculate_count = $_GET['survey_winners'];
		$survey_id = $_GET['survey_id'];
		$survey_code = $_GET['survey_code'];
 		$this->Survey_mdl->update_random_sweepstakes_winners($survey_winners_calculate_count,$survey_id,$survey_code);	
	}
	
	public function update_survey_status_btn(){
		$status = $_GET['status'];
		$id = $_GET['id'];
 		$this->Survey_mdl->update_survey_status_btn($status,$id);	
	}
	
	
	public function get_matrix_scale_point_rating_ajax(){
		if(isset($_GET['scale_id']) && $_GET['scale_id']!=''){
			$this->data['multiple_choice_rating_list'] = $this->Survey_mdl->get_multiple_choice_rating_ajax($_GET['scale_id']);
			$this->load->view('Frontend/create/survey/get_matrix_scale_point_rating_ajax',$this->data);
		}
	}
	
	public function get_multiple_choice_rating_ajax(){
		if(isset($_GET['scale_id']) && $_GET['scale_id']!=''){
			$this->data['multiple_choice_rating_list'] = $this->Survey_mdl->get_multiple_choice_rating_ajax($_GET['scale_id']);
			$this->load->view('Frontend/create/survey/get_multiple_choice_rating_ajax',$this->data);
		}
	}
	
	public function skip_logic_apply_survey_content(){
		if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->data['survey_id'] = $_GET['survey_id'];
			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($_GET['survey_id']);
			$this->data['survey_question_details'] = $this->Survey_mdl->get_survey_question_details($_GET['survey_id'],$_GET['question_id']);
			$question_type = $this->data['survey_question_details']->question_type;
			
			if(isset($question_type) && ($question_type==1 || $question_type==7 || $question_type==8)){
				$this->data['survey_question_ansers_details'] = $this->Master_helper_mdl->get_choics_of_multiple_type_question($_GET['question_id']);
			}
			
 			$this->data['skip_logic_conditions_details'] = $this->Survey_mdl->get_skip_logic_conditions_details($_GET['question_id']);
 			$this->load->view('Frontend/create/survey/skip_logic_apply_survey_content',$this->data);
		}
	}
	
	public function edit_skip_logic_condition(){
		if(isset($_GET['skip_id']) && $_GET['skip_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
		
			$this->data['survey_id'] = $_GET['survey_id'];
			$this->data['question_type'] = $_GET['question_type'];
			$this->data['question_id'] = $_GET['question_id'];
			$this->data['skip_id'] = $_GET['skip_id'];
			$this->data['question_priority'] = $_GET['question_priority'];
			
			$this->data['survey_question_ansers_details'] = $this->Survey_mdl->get_edit_skip_logic_answer_details_ajax($_GET['skip_id'],$_GET['question_id'],$_GET['question_type']);
			$this->data['skip_logic_condition_fulldetails'] = $this->Survey_mdl->get_skip_logic_condition_fulldetails($_GET['skip_id']);
			
			$this->load->view('Frontend/create/survey/edit_skip_logic_condition',$this->data);
		}
	}
	
	public function delete_skip_logic_condition(){
		if(isset($_GET['id']) && $_GET['id']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$this->Survey_mdl->delete_skip_logic_condition($_GET['id'],$_GET['survey_id']);
		}
 	}
	
	public function edit_skip_logic_condition_entry(){
		$this->Survey_mdl->edit_skip_logic_condition_entry();
 	}
	
	public function add_skip_logic(){
		if(isset($_GET['question_id']) && $_GET['question_id']!=''){
		
			$this->data['question_id'] = $_GET['question_id'];
			$this->data['survey_id'] = $_GET['survey_id'];
			$this->data['question_type'] = $_GET['question_type'];
			$this->data['question_priority'] = $_GET['question_priority'];
			
			$this->data['survey_question_ansers_details'] = $this->Survey_mdl->get_skip_logic_answer_details($_GET['question_id'],$_GET['question_type']);
 			$this->load->view('Frontend/create/survey/add_new_skip_logic',$this->data);
		}
	}
	
	public function add_skip_logic_entry(){
		$this->Survey_mdl->add_skip_logic_entry();
 	}
	
	public function add(){
		$this->Survey_mdl->add_survey($this->session->userdata('dept_id'));
	}	
	
	public function edit(){
		$this->Survey_mdl->edit_survey($this->session->userdata('dept_id'));
	}	
	
	public function delete(){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$this->Survey_mdl->delete_survey($_GET['id']);
		}
	}
	
	public function get_default_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/survey/default_choices',$this->ajax_data);
		}
	}
	
	public function get_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Frontend/create/survey/anser_actions',$this->ajax_data);
		}
	}
	public function management(){
		//$last = $this->uri->total_segments();
		//$survey_id = $this->uri->segment($last);
		if(isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$survey_id = $_GET['survey_id'];
			$dept_id = $this->session->userdata('dept_id');
			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
			if(isset($this->data['survey_details']->survey_id) && $this->data['survey_details']->survey_id!=''){
			
				$this->data['survey_questions_details'] = $this->Survey_mdl->get_survey_questions_details($dept_id,$survey_id);
				$this->data['survey_id'] = $survey_id;
				$this->data['drap_drop_js'] = 1;
				
				if(isset($_GET['tab_id']) && $_GET['tab_id']==6){
					$this->data['survey_responses_data'] = $this->Survey_mdl->get_survey_responses_data($dept_id,$survey_id);
				}
				$this->load->view('Frontend/includes/header',$this->data);
				$this->load->view('Frontend/create/survey/management',$this->data);
				$this->load->view('Frontend/includes/footer',$this->data); 	
			
			}else{
 				redirect(base_url().'department/create/surveys');
			}
			
		}else{
 			redirect(base_url().'department/create/surveys');
		}		
	}
	
	public function remove_reponses(){
		if(isset($_GET['ids']) && $_GET['ids']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$this->Survey_mdl->remove_reponses($_GET['ids'],$_GET['survey_id']);
		}
		redirect(base_url().'department/create/survey/management?tab_id=6&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id']);	
 	}		
	
	public function set_order_questions(){
		$this->Survey_mdl->set_order_questions();
	}	
	
	
	public function add_survey_configuration(){
		$this->Survey_mdl->add_survey_configuration();
	}
	
	public function add_question(){ 
		$last = $this->uri->total_segments();
		$survey_id = $this->uri->segment($last);
		$status_of_survey = check_status_of_survey_started_h($survey_id);
		if($status_of_survey==0){

			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/create/survey/add_question',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 
		
		}else{
			$dept_id=$this->session->userdata('dept_id');
			$this->session->set_flashdata('success', "Sorry, you can not add question, because survey has been started!");
  			redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);	
		}			
	}
	
	/*public function edit_question(){ 
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);
		$this->data['survey_question_fulldetails'] = $this->Survey_mdl->get_survey_question_fulldetails($question_id);
		$survey_id = $this->data['survey_question_fulldetails']->survey_id;
		
		
		$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/edit_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	
	
	public function update_question_entry(){
		$this->Survey_mdl->update_question_entry();
	}	*/
	
	
 	public function delete_question_choice(){
		if(isset($_GET['answer_id']) && $_GET['answer_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){
			$this->Survey_mdl->delete_question_choice($_GET['answer_id'],$_GET['question_id'],$_GET['question_type']);
		}
 	}
	
	public function delete_survey_question(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$this->Survey_mdl->delete_survey_question($_GET['question_id'],$_GET['survey_id']);
		}
 	}
	
	public function question_save(){
		$survey_id = $this->input->post('hidden_survey_id');
		$dept_id = $this->session->userdata('dept_id');
		if(isset($survey_id) && $survey_id!=''){
			$this->Survey_mdl->question_save($survey_id,$dept_id);
		}
		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
	}	
	
	public function compose_email(){
		if(isset($_GET['survey_id']) && $_GET['survey_id']!=''){
			$survey_id = $_GET['survey_id'];
			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id); 
					
 			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/create/survey/management',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 	
		
		}else{
			redirect(base_url().'department/create/surveys');	
		}
	}
	
	public function save_email(){
		if(isset($_POST['h_survey_id']) && $_POST['h_survey_id']!=''){
			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($_POST['h_survey_id']);
			$survey_code = $this->data['survey_details']->survey_code;
			$this->Survey_mdl->save_email($survey_code);
		}
	}		
	
	
//===== ----- survey_templates ----- =====//
		
	public function survey_templates(){	
		$last = $this->uri->total_segments();
		$survey_id = $this->uri->segment($last);	
		
		if(isset($_GET['stid'])&& $_GET['stid']!=''){
			$survey_template_id = $_GET['stid'];
			$this->data['default_surveys_questions_detail'] = $this->Survey_template_mdl->default_surveys_questions_detail($survey_id,$survey_template_id);
 		}
 			
		$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
		$this->data['survey_templates_details']=$this->Survey_template_mdl->survey_templates_details();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/template_listing',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 
	}	
	
	public function import_default_questions(){	
		if(isset($_GET['ques_id']) && $_GET['ques_id']!='' && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['survey_template_id']) && $_GET['survey_template_id']!=''){ 
			$ques_id = $_GET['ques_id'];
			$survey_id = $_GET['survey_id'];
			$survey_template_id = $_GET['survey_template_id'];
 			$this->Survey_template_mdl->import_default_questions($ques_id, $survey_id, $survey_template_id);
			
		}else{
			redirect(base_url().'department/create/survey/templates/'.$survey_id.'?stid='.$survey_template_id);
		}
	}	
	
	
//===== ----- survey_results ----- =====//	

	public function results(){	
		$dept_id=$this->session->userdata('dept_id');
		$last = $this->uri->total_segments();
		$survey_id = $this->uri->segment($last);
		$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);	
		$this->data['survey_email_detail'] = $this->Survey_mdl->survey_email_detail($survey_id,$dept_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/results_list',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}		
	
	public function results_answer(){	
		$survey_id = $this->uri->segment('5');
		$auth_code = $this->uri->segment('6');
		$dept_id=$this->session->userdata('dept_id');
		
		$this->data['auth_code'] = $auth_code;
		$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
		$this->data['surveys_questions_detail'] = $this->Survey_mdl->surveys_questions_detail($survey_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/results_answer',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}
	
	
//===== ----- edit_question survey ----- =====//	
	
	public function edit_question(){ 
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);
		$this->data['question_id'] = $question_id;
		$this->data['survey_question_fulldetails'] = $this->Survey_mdl->get_survey_question_fulldetails($question_id);
		$survey_id = $this->data['survey_question_fulldetails']->survey_id;
 		$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
		$this->data['survey_question_reponses_check'] = $this->Survey_mdl->survey_question_reponses_check($survey_id,$question_id);
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/create/survey/edit_survey_questions/edit_question',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	public function get_edit_default_question_choice(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			$this->ajax_data['question_id']=$_GET['question_id'];
			$this->ajax_data['edit_question_fulldetails'] = $this->Survey_mdl->get_survey_question_fulldetails($_GET['question_id']);
			$survey_id = $this->ajax_data['edit_question_fulldetails']->survey_id;		
			$this->ajax_data['survey_question_reponses_check'] = $this->Survey_mdl->survey_question_reponses_check($survey_id,$_GET['question_id']);
			$this->ajax_data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
			return $this->load->view('Frontend/create/survey/edit_survey_questions/default_choices',$this->ajax_data);
		}
	}
	
	public function get_edit_action_html_of_answer(){
		if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			$this->ajax_data['question_id']=$_GET['question_id'];
			$this->ajax_data['edit_question_fulldetails'] = $this->Survey_mdl->get_survey_question_fulldetails($_GET['question_id']);
			$survey_id = $this->ajax_data['edit_question_fulldetails']->survey_id;		
			$this->ajax_data['survey_question_reponses_check'] = $this->Survey_mdl->survey_question_reponses_check($survey_id,$_GET['question_id']);
			$this->ajax_data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
			return $this->load->view('Frontend/create/survey/edit_survey_questions/anser_actions',$this->ajax_data);
		}
	}
	
	public function update_question_entry(){
		$this->Survey_mdl->update_question_entry();
	}	
	
	public function edit_modal_ajax(){
		if(isset($_GET['qt'])&& $_GET['qt']!='' && isset($_GET['qid'])&&$_GET['qid']!=''){
			$question_type = $_GET['qt'];
			$question_id = $_GET['qid'];
			
			$this->data['survey_question_fulldetails'] = $this->Survey_mdl->get_survey_question_fulldetails($question_id);
			$survey_id = $this->data['survey_question_fulldetails']->survey_id;		
			$this->data['survey_details'] = $this->Survey_mdl->survey_fulldetails($survey_id);
			
			return $this->load->view('Frontend/create/survey/edit_modal_ajax',$this->data); 
		}		
	} 
	
	
}