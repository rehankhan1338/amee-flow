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
	
	public function get_5scale_rating_list(){
		$this->db->where('status', '1');
 		$this->db->order_by('name', 'asc');
		$query = $this->db->get('5pt_rating_scale');
		return $query->result();
	}
	
	public function get_choics_of_multiple_type_question($question_id){
		//$dept_id = $this->session->userdata('dept_id');
		//$this->db->where('department_id', $dept_id);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('default_survey_question_answers');
		return $query->result();	
	}		
			
	public function get_choics_of_multiple_column($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '1');
		$query = $this->db->get('default_survey_question_choices');
		return $query->result();	
	}	
	
	public function get_choics_of_multiple_rows($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->where('choices_status', '0');
		$query = $this->db->get('default_survey_question_choices');
		return $query->result();	
	}		
	
	public function get_default_surveys_questions_count_by_survey_template_id($survey_templates_id){
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->where('survey_id', $survey_templates_id);
		$query = $this->db->get('default_surveys_questions');
		return $query->num_rows();	
	}	
		
/*	public function get_content_tutorials_sub_heading_detail_by_heading_id($heading_id){
		$this->db->where('heading_id', $heading_id);
		$this->db->where('status', '0');
		$query = $this->db->get('content_tutorials_sub_heading');
		return $query->result();	
	}*/	
		
	public function get_content_tutorials_heading_name_by_heading_id($heading_id){
		$this->db->where('id', $heading_id);
		$this->db->where('status', '0');
		$query = $this->db->get('content_tutorials_heading');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();	
			return $row->heading;
		}
	}	
	
}