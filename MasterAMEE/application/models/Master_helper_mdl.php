<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_helper_mdl extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */ 
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}
	
	function get_name_master_indirect_measures_by_id($id){
		$this->db->where('id', $id);
		$this->db->where('status', '0');
		$query = $this->db->get('master_indirect_assessment');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->name;
		}
	}
	
	function get_name_master_direct_measures_by_id($id){
		$this->db->where('id', $id);
		$this->db->where('status', '0');
		$query = $this->db->get('master_direct_assessment');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->name;
		}
	}
	
	function get_name_master_strategic_priorities_by_id($id){
		$this->db->where('id', $id);
		$this->db->where('status', '0');
		$query = $this->db->get('master_strategic_priorities');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->name;
		}
	}
	
	function survey_listing($dept_id){
		$where = ' status=0';
		
		if(isset($_GET['fd']) && $_GET['fd']!='' && isset($_GET['td']) && $_GET['td']!=''){
			$from_date = strtotime($_GET['fd']);
			$to_date = strtotime($_GET['td']);
			
			$where.=" and creation_date_time BETWEEN $from_date and $to_date";
		}	
			
		$this->db->where($where);
 		$this->db->where('department_id', $dept_id);
		$this->db->where('is_deleted', '0');		
		$this->db->order_by('survey_id', 'desc');
		$query = $this->db->get('surveys');
		return $query->result();
	}	
	
	function test_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$this->db->order_by('test_id', 'desc');
		$query = $this->db->get('tests');
		return $query->result();
	}	
	
	function assignment_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('assignments');
		return $query->result();
	}
	
	public function get_all_choics_count_survey_of_matrix_question($question_id,$row_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('row_id',$row_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
	}
	
	public function get_choics_count_survey_of_matrix_question($question_id,$row_id,$column_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('row_id',$row_id);
		$this->db->where('answer',$column_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
	}
	
	public function get_all_choice_survey_result_count_by_question_id($question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();	
	}
	
	public function get_choice_survey_result_count_by_choice_id($answer_id,$question_id){
		$this->db->where('question_id',$question_id);
		//$this->db->where('answer',$answer_id);
		$this->db->where("FIND_IN_SET('".$answer_id."',`answer`) !=", 0);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();	
	}
	
	public function get_5scale_rating_list(){
		$this->db->where('status', '1');
 		$this->db->order_by('name', 'asc');
		$query = $this->db->get('5pt_rating_scale');
		return $query->result();
	}
	
	public function get_star_skip_logics($question_id){
		$this->db->where('question_id',$question_id);
		$query = $this->db->get('survey_answers_skip_logics');
		return $query->num_rows();	
	}
	
	public function get_answer_name_by_answer_id($answer_id,$question_type){
 		if($question_type==1 || $question_type==7){
			$this->db->where('answer_id',$answer_id); 
			$query = $this->db->get('survey_question_answers');	
			$row = $query->row();	
			return $row->answer_choice;	
		}
 		if($question_type==2){
			$this->db->where('answer_id',$answer_id); 
			$query = $this->db->get('survey_question_choices_conditions');
			$row = $query->row();
			if(isset($row->choices_scale) && $row->choices_scale!=''){	
				return $row->answer_choice.' - '.$row->choices_scale;
			}else{
				return $row->answer_choice;
			}
		}
		
	}
	
	public function get_department_course_matrix_options(){
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('master_matrix_options_colorcode');
		return $query->result();	
		
	}
	
	public function get_department_checklist_data_count($checklist_id){
		$department_id = $this->session->userdata('dept_id');
		if(isset($department_id) && $department_id!=''){
			$this->db->where('department_id',$department_id);
		}
		$this->db->where('checklist_id',$checklist_id);
		$this->db->where('status','0');
		$query = $this->db->get('department_checklist_data');
		return $query->num_rows();	
	}
	
	public function get_web_readness_list(){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->select('id, purpose, title, description');
		$amee_web->where('page_name', 'readiness');
		$amee_web->where('status', '0');
		$this->db->order_by('id', 'asc');
		$query = $amee_web->get('popup_messages');
		return $query->result();
	}
	
	public function get_department_checklist(){
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('master_department_checklist');
		return $query->result();	
		
	}
	
	public function get_university_details($university_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $university_id);
		$query = $amee_web->get('university');
		return $query->row();
	}
	
	public function master_departments_type_detail(){
		$query = $this->db->get('master_department_type');
		return $query->result();
	}		
	
	public function master_organization_type(){
		$query = $this->db->get('master_organization_type');
		return $query->result();
	}	
	
	
	function get_member_names_result_by_id($team_id){
 		$dept_id = $this->session->userdata('dept_id');
 		//$this->db->select('name');
		if(isset($dept_id) && $dept_id!=''){
 			$this->db->where('department_id', $dept_id);
		}
 		$this->db->where('team_id', $team_id);
		$this->db->where('status', '0');
		$query = $this->db->get('department_team_members');		
		return $query->result();	
		/*$arr = $query->result();	
		$num_rows = $query->num_rows();	
		if($num_rows>0){
			foreach($arr as $data){
				$narr[] = $data->name;
			}
			return implode(', ', $narr);
		}	*/
	}
	
	
	// =====---------- Helper ----------====== //
	 
	
	public function get_master_department_type_by_id($dept_id){
 		$this->db->where('id', $dept_id);
		$query = $this->db->get('master_department_type');
		return $query->row();
	}
	
		
	public function get_master_organization_type_by_id($orgid){
 		$this->db->where('id', $orgid);
		$query = $this->db->get('master_organization_type');
		return $query->row();
	}
	
	
	public function get_assign_core_competency_detail_by_pslos_id($pslos_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id', $dept_id);
		}
		$this->db->where('department_pslos_id', $pslos_id);
		$query = $this->db->get('department_assign_core_competency');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $ids = $row->core_competency_id;
		}	
	}
	
		
	
 //==-- Survey --==//
	public function get_choics_of_multiple_type_question($question_id){
		//$dept_id = $this->session->userdata('dept_id');
		//$this->db->where('department_id', $dept_id);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('survey_question_answers');
		return $query->result();	
	}		
	
	public function get_choics_of_multiple_rows($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '0');
		$query = $this->db->get('survey_question_choices');
		return $query->result();	
	}	
	
	public function get_choics_of_multiple_column($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '1');
		$query = $this->db->get('survey_question_choices');
		return $query->result();	
	}	
	
	public function get_survey_answers_detail($survey_id, $auth_code){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->group_by('question_id');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
		//return $query->row();
	}	
	
	public function get_survey_answers_detail_by_question_id($survey_id, $auth_code, $question_id){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('survey_answers');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->answer;
		}
	}	
	
	public function get_matrix_choics_name_by_choice_id($row_id){
		$this->db->where('row_id', $row_id);
		$query = $this->db->get('survey_question_choices');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->choices;
		}
	}
	
	public function get_survey_matrix_answers_detail($survey_id, $auth_code, $question_id, $row_id){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('row_id', $row_id);
		$this->db->where('is_matrix_question', '1');
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('survey_answers');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->answer;
		}
	}	
	
	public function get_survey_result_answers_detail($question_id,$question_type,$survey_id,$auth_code){
		$this->db->where('question_id', $question_id);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);		
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('survey_answers');
		$num = $query->num_rows();
		return $query->result();
	}
	
	public function get_survey_questions_details_for_demography($question_id,$survey_id,$dept_id){
		$this->db->where('question_id != ', $question_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('survey_id', $survey_id);
		//$this->db->where('is_demography', '1');
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$where = ' question_type in (1,2)';
		$this->db->where($where);
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('surveys_questions');
 		return $query->result();
	}	
	
	public function get_surveys_questions_detail_by_question_id($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('surveys_questions');
 		return $query->row();
	}	
	
/*	function get_survey_answers_count($survey_id,$dept_id){
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
	}*/
	
	function get_survey_email_count($survey_id,$dept_id){
		$this->db->where('is_deleted', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('survey_email');
		return $query->num_rows();
	}
	
	function get_survey_responses_count($survey_id,$dept_id){
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
	}
	
	function get_master_survey_types_name_by_id($types_id){
		$this->db->where('id', $types_id);
		$query = $this->db->get('master_survey_types');
		$row = $query->row();
		return $row->name;
	}
	
 //==-- Tests --==//
	public function get_choics_of_multiple_type_question_tests($question_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id', $dept_id);
		}
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('test_question_answers');
		return $query->result();	
	}	
	
	public function get_choics_of_multiple_column_tests($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '1');
		$query = $this->db->get('test_question_choices');
		return $query->result();	
	}
		
	public function get_choics_of_multiple_rows_tests($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '0');
		$query = $this->db->get('test_question_choices');
		return $query->result();	
	}		
	
	public function get_point_value_by_test_id($test_id){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->select_sum('point_value');
		$this->db->where('test_id', $test_id);
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id', $dept_id);
		}
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_questions');
		return $query->row();
	}
	
	public function get_test_current_answers_detail_by_question_id($test_id, $current_test_type, $auth_code, $question_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $current_test_type);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('test_answers');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->answer;
		}
	}	
	
	public function get_test_demo_answers_detail_by_question_id($test_id, $auth_code, $question_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('test_answers');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->answer;
		}
	}
	
	public function get_test_answers_detail_by_question_id($test_id,$current_test_type, $auth_code, $question_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $current_test_type);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('test_answers');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->answer;
		}
	}
	
	function get_tests_reponses_count($test_id,$dept_id){
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('test_answers');
		return $query->num_rows();
	}
	
	function get_tests_email_count($test_id,$dept_id){
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->num_rows();
	}
		
	public function get_test_question_answers_name_by_answer_id($test_answers_id,$question_type){
		$this->db->where('answer_id',$test_answers_id); 
		if($question_type==1){
			$query = $this->db->get('test_question_answers');	
			$row = $query->row();	
			return $row->answer_choice;	
		}		
	}
	
//=====----- Survey Template -----=====//
	public function get_choics_of_multiple_type_question_survey_templates($question_id){
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('default_survey_question_answers');
		return $query->result();	
	}
	
	public function get_choics_of_multiple_column_survey_templates($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '1');
		$query = $this->db->get('default_survey_question_choices');
		return $query->result();	
	}	
	
	public function get_choics_of_multiple_rows_survey_templates($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '0');
		$query = $this->db->get('default_survey_question_choices');
		return $query->result();	
	}		
	
	public function get_count_of_default_surveys_questions($survey_templates_id){
		$this->db->where('survey_id', $survey_templates_id);
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('default_surveys_questions');
		return $query->num_rows();
	}		
		
//==-- Assignments Rubrics  --==//	
	public function check_assignments_rubrics_builder_status($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignments_rubrics_builder');
		return $query->num_rows();
	}	
	
	public function get_assignments_rubrics_builder($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignments_rubrics_builder');
		return $query->result();
	}
	
	public function get_assignments_rubrics_builder_highest_rating($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('oprf_column', 'desc');
		$query = $this->db->get('assignments_rubrics_builder_heading');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->oprf_column;
		}else{
			return $num_rows;
		}
	}
		
	public function get_assignments_rubrics_builder_heading($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('oprf_column', 'desc');
		$query = $this->db->get('assignments_rubrics_builder_heading');
		return $query->result();
	}		
	
	public function get_assignments_rubrics_builder_option_details($column_no, $rubric_id){
		$this->db->where('rubric_id', $rubric_id);
		$this->db->where('column_no', $column_no);
		$query = $this->db->get('assignments_rubrics_builder_option');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->option_name;
		}
	}
	
	public function get_assignments_rubrics_criterion_heading($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('column_no', 'asc');
		$query = $this->db->get('assignments_rubrics_criterion');
		return $query->result();
	}	
		
	public function get_choics_of_multiple_type_question_rubrics($question_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id', $dept_id);
		}
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assignment_question_choices');
		return $query->result();	
	}	
	
	public function get_assignment_choics_of_multiple_type_question($question_id){
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assignment_question_choices');
		return $query->result();	
	}
	
	function get_assingment_responses_count($assignment_id,$dept_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');		
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_question_answer');
		return $query->num_rows();
	}
		
	function get_assingment_email_count($assignments_id,$dept_id){
 		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->where('assingment_id', $assignments_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('first_name!=', '');		
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_email');
		return $query->num_rows();
	}
	
	public function get_assingment_answers_detail_by_question_id($assignment_id, $auth_code, $question_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('assingment_question_answer');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			return $row->given_answer;
		}
	}
	
	public function get_assignments_rubrics_question_answers_name_by_answer_id($assingment_ans,$question_type){
		$this->db->where('answer_id',$assingment_ans); 
		if($question_type==1){
			$query = $this->db->get('assignment_question_choices');	
			$row = $query->row();	
			return $row->answer_choice;	
		}		
	}
	
//=====----- Analyze: "360" - Closing the Loop  -----=====// 	
	
	public function get_master_closing_loops_detail_by_status($lable_status){
		$this->db->where('status',$lable_status); 
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('master_closing_loops');		
		return $query->result();	
	}	
	
	public function get_analyze_loop_description_by_loopid($loop_id,$lable_status){
		$dept_id=$this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id',$dept_id); 
		}
		$this->db->where('loop_id',$loop_id); 
		$this->db->where('loop_status',$lable_status); 
		$query = $this->db->get('analyze_loop_description');		
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			return $row->content;
		}		
	}
	
	
//=====----- Tutorials  -----=====// 		

	public function get_content_tutorials_sub_heading_details_by_heading_id($heading_id){
		$amee_web = $this->load->database('amee_web', TRUE); 			
		$amee_web->where('status', '0');
		$amee_web->where('heading_id', $heading_id);
		$query = $amee_web->get('content_tutorials_sub_heading');
		return $query->result(); 
	}	
		
}