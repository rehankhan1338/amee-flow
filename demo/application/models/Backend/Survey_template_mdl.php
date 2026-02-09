<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_template_mdl extends CI_Model {	
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
	
	public function survey_templates_details(){	
 		$amee_web = $this->load->database('amee_web', TRUE);
		$table_prefix = $this->config->item('superadmin_table_prefix');
		$amee_web->where('status', '0');
		$amee_web->order_by('name', 'asc');
 		$where=' id in(select survey_id from '.$table_prefix.'default_surveys_questions where status=0 and is_deleted=0)';
		$amee_web->where($where);
 		$query = $amee_web->get('default_survey_templates');
		return $query->result();		
	}
	
	public function survey_templates_fulldetails($id){	
 		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $id);
		$query = $amee_web->get('default_survey_templates');
		return $query->row();		
	}
	
	public function import_default_questions($ques_id, $survey_id, $survey_template_id){
	 
		$dept_id = $this->session->userdata('dept_id');
		$arr =array('survey_template_id'=>$survey_template_id, 'last_modification'=>time());
		$this->db->where('survey_id', $survey_id);
		$this->db->update('surveys',$arr);
		
		$amee_web = $this->load->database('amee_web', TRUE);
	
		$explode_ques_id = explode(',', $ques_id);
		for($i=0; $i<count($explode_ques_id); $i++){			
			$question_id = $explode_ques_id[$i];
			
			$amee_web->where('question_id', $question_id);
			$amee_web->where('survey_id', $survey_template_id); //survey_id <-is $survey_template_id;
			$query = $amee_web->get('default_surveys_questions');
			$question_detail = $query->row();
			
			$d_question_id = $question_detail->question_id;
			$d_question_title = $question_detail->question_title;
			$d_question_type = $question_detail->question_type;
			$d_is_required = $question_detail->is_required;
			$d_required_message = $question_detail->required_message;
			$d_nps_first_field = $question_detail->nps_first_field;
			$d_nps_middle_field = $question_detail->nps_middle_field;
			$d_nps_last_field = $question_detail->nps_last_field;
			$d_is_demography = $question_detail->is_demography;
			
				$this->db->where('survey_id', $survey_id);
				$this->db->where('is_deleted', '0');
				$this->db->where('status', '0');
				$this->db->order_by('question_id', 'desc');
				$query_get_priority = $this->db->get('surveys_questions');
				$priority_count = $query_get_priority->num_rows();
				if($priority_count==0){
					$priority_set = 1;
				}else{
					$priority_set = $priority_count+1;
				}
			
			$question_arr =array('survey_id'=>$survey_id, 'department_id'=>$dept_id,
				'question_title'=>$d_question_title, 'question_type'=>$d_question_type, 
				'is_required'=>$d_is_required, 'required_message'=>$d_required_message, 
				'nps_first_field'=>$d_nps_first_field, 'nps_middle_field'=>$d_nps_last_field, 
				'nps_last_field'=>$d_nps_last_field, 'is_demography'=>$d_is_demography, 
				'creation_date'=>time(),'default_questions_id'=>$d_question_id, 'priority'=>$priority_set);
			$this->db->insert('surveys_questions', $question_arr);
			$sq_inserted_id=$this->db->insert_id();
			
			if($d_question_type==1){
				$amee_web->where('question_id', $d_question_id);
				$amee_web->where('survey_id', $survey_template_id); //survey_id <-is $survey_template_id;
				$query1 = $amee_web->get('default_survey_question_answers');
				$d_question_answers_detail = $query1->result();
				
					foreach($d_question_answers_detail as $answers_detail){
						$d_answer_choice = $answers_detail->answer_choice;
						
						$answers_arr = array('survey_id'=>$survey_id, 'department_id'=>$dept_id, 
							'question_id'=>$sq_inserted_id, 'answer_choice'=>$d_answer_choice); 
						$this->db->insert('survey_question_answers', $answers_arr);			
					}	
								
			}else if($d_question_type==2){
				$amee_web->where('question_id', $d_question_id);
				$query1 = $amee_web->get('default_survey_question_choices');
				$d_question_choices_detail = $query1->result();
				
					foreach($d_question_choices_detail as $question_choices){
						$d_choices = $question_choices->choices;
						$d_choices_status = $question_choices->choices_status;
						
						$choices_arr = array('question_id'=>$sq_inserted_id, 
							'choices'=>$d_choices, 'choices_status'=>$d_choices_status); 
						$this->db->insert('survey_question_choices', $choices_arr);	
 								
					}
					
				$amee_web->where('question_id', $d_question_id);
				$amee_web->order_by('answer_id', 'asc');
				$query12 = $amee_web->get('default_survey_question_choices_conditions');
				$d_question_choices_conditions_detail = $query12->result();
				foreach($d_question_choices_conditions_detail as $question_choices_conditions){
					$d_answer_choice = $question_choices_conditions->answer_choice;
					$d_choices_scale = $question_choices_conditions->choices_scale;
					
					$choices_condition_arr = array('question_id'=>$sq_inserted_id, 
						'answer_choice'=>$d_answer_choice, 'choices_scale'=>$d_choices_scale); 
					$this->db->insert('survey_question_choices_conditions', $choices_condition_arr);	
							
				}
			}		
		}
		
		$this->session->set_flashdata('success', 'Survey question imported successfully!');
		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
	}
	 

	public function default_surveys_questions_detail($survey_id,$survey_template_id){
	
		$this->db->where('survey_id', $survey_id);
		$this->db->where('default_questions_id !=', '');
		$this->db->where('default_questions_id !=', '0');
		$query = $this->db->get('surveys_questions');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$result = $query->result();	
			foreach($result as $result_details){
				$dques_id[]=$result_details->default_questions_id;
			}
			$fetched_question=implode(',',$dques_id);
		}else{
			$fetched_question='';
		}
		
 		$amee_web = $this->load->database('amee_web', TRUE);
		if(isset($fetched_question) && $fetched_question!=''){
			$where=' question_id not in('.$fetched_question.')';
			$amee_web->where($where);
		}
		$amee_web->where('survey_id', $survey_template_id);
		$amee_web->where('is_deleted', '0');
		$amee_web->where('status', '0');
		$amee_web->order_by('priority', 'asc');
		$query = $amee_web->get('default_surveys_questions');
 		return $query->result();	
	}	
	  
	public function default_surveys_questions_row($question_id){	
 		$this->db->where('question_id', $question_id);
		$query = $this->db->get('default_surveys_questions');
		return $query->row();		
	}	
	
	public function default_survey_question_answers_detail($question_id){	
 		$this->db->where('question_id', $question_id);
		$query = $this->db->get('default_survey_question_answers');
		return $query->result();		
	}
	
			
			
}