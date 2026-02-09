<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tests_mdl extends CI_Model {
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
	
	function get_count_test_rating($test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('rate_your_self !=', '');
		$query = $this->db->get('tests_email');
		return $num_rows = $query->num_rows();	
	}
	
	function update_test_status_btn($status,$id){
		$dept_id=$this->session->userdata('dept_id');
		$arr = array('status'=>$status);
		$this->db->where('test_id', $id);
		$this->db->update('tests',$arr);
		redirect(base_url().'department/create/tests/management?test_id='.$id.'&dept_id='.$dept_id);		
	}
	
	public function get_correct_answer_per_of_plso($question_assigned_ids,$test_id,$test_type){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $test_type);
		$this->db->where('correct_answer_status', '1');
		$where = ' question_id in ('.$question_assigned_ids.')';
		$this->db->where($where); 
		$query = $this->db->get('test_answers');
		return $num_rows = $query->num_rows();
 	}
	
	public function get_total_student_gave_answer($test_id,$test_type){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $test_type);
		$this->db->group_by('auth_code');
		$query = $this->db->get('test_answers');
		return $num_rows = $query->num_rows();
	}
	
	public function get_all_item_test_textbox_answer_listing($test_id,$question_id,$auth_code,$test_type){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $test_type);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('test_answers');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->answer;
		}	
	}
	
	public function get_all_test_authcode_textbox_answer_listing($test_id,$question_id,$auth_code){
		$this->db->where('test_id', $test_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('test_answers');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->answer;
		}	
	}
	
	function test_courses_fulldetails($id){
		$this->db->where('id', $id);
		$query = $this->db->get('tests_course');
		return $query->row();
 	}
	
	function get_courses_test_result_count_by_couses_id($course_id,$test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('answer', $course_id);
		//$this->db->where(' FIND_IN_SET('.$course_id.', given_answer)');
		$this->db->where('question_status', '3');
		$this->db->where('status', '0');
		$query = $this->db->get('test_answers');
		return $query->num_rows();
	}
	
	function get_all_courses_test_result_count_by_couses_id($test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('question_status', '3');
		$this->db->where('status', '0');
		$query = $this->db->get('test_answers');
		return $num_row = $query->num_rows();
		/*if($num_row>0){
			$result = $query->result();
			foreach($result as $details){
				if(isset($details->given_answer) && $details->given_answer!=''){
 					$given_answer_arr[] = $details->given_answer;
				}
			}
			$given_answer_ids = implode(',',$given_answer_arr);
			$arr = explode(',',$given_answer_ids);
			return count($arr);
		}else{
			return $num_row;
		}*/
	}
	
	function get_courses_test_listing_result($test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('status', '0');
		$query = $this->db->get('tests_course');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			foreach($result as $details){
				if(isset($details->id) && $details->id!='' && $details->id!=0){
 					$ids[] = $details->id;
				}
			}
			return $ids;
		}
 	}
	
	public function get_all_choice_test_result_count_by_pslo_question_id($question_id,$test_type){
		$this->db->where('question_id',$question_id);
		$this->db->where('test_type',$test_type);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
 		$this->db->where('question_status','1');
		$query = $this->db->get('test_answers');
		return $query->num_rows();	
	}
	
	public function get_choice_test_result_count_by_plos_answer_choice_id($answer_id,$question_id,$test_type){
		$this->db->where('question_id',$question_id);
		$this->db->where('test_type',$test_type);
		$this->db->where('answer',$answer_id);
		$this->db->where('question_status','1');
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('test_answers');
		return $query->num_rows();	
	}
	
	function get_questions_id_test_outcomes_h($test_id,$plso_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
 			$this->db->where('department_id', $dept_id);
		}
		$this->db->where('is_demography', '0');
		$this->db->where('test_id', $test_id);
		if(isset($plso_id) && $plso_id!=''){
			$where = ' FIND_IN_SET('.$plso_id.', learning_outcomes)';
			$this->db->where($where); 
		}
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('tests_questions');
 		$num_rows = $query->num_rows();	
		if($num_rows>0){
			$result = $query->result();
			foreach($result as $result_details){
				$question_ids_arr[]=$result_details->question_id;
			}
			return implode(',',$question_ids_arr);
		}
	}
	
	function test_plos_questions_listing($test_id,$plos_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
 		$this->db->where('department_id', $dept_id);
		}
		$this->db->where('is_demography', '0');
		$this->db->where('test_id', $test_id);
		$where = ' FIND_IN_SET('.$plos_id.', learning_outcomes)';
		$this->db->where($where); 
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('tests_questions');
 		return $query->result();
	}
	
	function get_test_learning_outcome_full_details($id){
		$this->db->where('id',$id);
		$query = $this->db->get('department_pslos');
		return $query->row();	
	}
	
	function learning_outcomes_listing_question_present($test_id){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
		$this->db->where('department_id', $dept_id);
		}
		$this->db->where('is_demography', '0');
		$this->db->where('test_id', $test_id);
		$this->db->where('learning_outcomes!=', '');
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('tests_questions');
		$num_rows = $query->num_rows();	
		if($num_rows>0){
 			$result = $query->result();
			foreach($result as $result_details){
				$learning_outcomes_arr[] = $result_details->learning_outcomes;
			}
			$learning_outcomes_narr = array_unique($learning_outcomes_arr);	
			return implode(',',$learning_outcomes_narr);
		}
	}
	
	public function get_test_total_score_according_to_criteria($test_id,$test_type,$highest,$lowest){
		$this->db->where('test_id',$test_id);
		$this->db->where('test_type',$test_type);
		$this->db->where('question_status','1');
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('test_answers');
		return $query->num_rows();	
	}
	
	public function get_all_choice_test_result_count_by_question_id($question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
 		$this->db->where('question_status','2');
		$query = $this->db->get('test_answers');
		return $query->num_rows();	
	}
	
	public function get_choice_test_result_count_by_choice_id($answer_id,$question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('answer',$answer_id);
		$this->db->where('question_status','2');
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('test_answers');
		return $query->num_rows();	
	}
	
	function get_test_question_fulldetails($question_id){
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('tests_questions');
		return $query->row();
	}
	
	function test_auth_code_detail($auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_email');
		return $query->row();
 	}
	
	function save_criterion_option(){
		$dept_id = $this->input->post('hidden_dept_id');
		$test_id = $this->input->post('hidden_test_id');
		$option_id = $this->input->post('option_id');
		
		$range_name_column_1 = $this->input->post('range_name_column_1');
		$oprf_column_1 = $this->input->post('oprf_column_1');
		$oprf_column_sec_1 = $this->input->post('oprf_column_sec_1');
		$range_name_column_2 = $this->input->post('range_name_column_2');
		$oprf_column_2 = $this->input->post('oprf_column_2');
		$oprf_column_sec_2 = $this->input->post('oprf_column_sec_2');		
		$range_name_column_3 = $this->input->post('range_name_column_3');
		$oprf_column_3 = $this->input->post('oprf_column_3');
		$oprf_column_sec_3 = $this->input->post('oprf_column_sec_3');	
		$range_name_column_4 = $this->input->post('range_name_column_4');
		$oprf_column_4 = $this->input->post('oprf_column_4');
		$oprf_column_sec_4 = $this->input->post('oprf_column_sec_4');	
		$range_name_column_5 = $this->input->post('range_name_column_5');
		$oprf_column_5 = $this->input->post('oprf_column_5');
		$oprf_column_sec_5 = $this->input->post('oprf_column_sec_5');		
		$arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'option_id'=>$option_id, 'range_name_column_1'=>$range_name_column_1, 'oprf_column_1'=>$oprf_column_1, 'oprf_column_sec_1'=>$oprf_column_sec_1, 'range_name_column_2'=>$range_name_column_2, 'oprf_column_2'=>$oprf_column_2, 'oprf_column_sec_2'=>$oprf_column_sec_2, 'range_name_column_3'=>$range_name_column_3, 'oprf_column_3'=>$oprf_column_3, 'oprf_column_sec_3'=>$oprf_column_sec_3, 'range_name_column_4'=>$range_name_column_4, 'oprf_column_4'=>$oprf_column_4, 'oprf_column_sec_4'=>$oprf_column_sec_4, 'range_name_column_5'=>$range_name_column_5, 'oprf_column_5'=>$oprf_column_5, 'oprf_column_sec_5'=>$oprf_column_sec_5, 'add_date'=>time());
		$this->db->insert('test_criterion_option', $arr);
		$this->session->set_flashdata('success', 'Save and updated successfully!');
		redirect(base_url().'department/create/tests/management?tab_id=5&test_id='.$test_id.'&dept_id='.$dept_id);		
	}
		
	function get_test_criteion_details($test_id){
		$this->db->where('test_id', $test_id);
		$query = $this->db->get('test_criterion_option');
		return $query->row();
	}
	
	function get_master_question_type_test_h(){
		$this->db->where('status', '0');
		$this->db->where('choice', '1');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('survey_master_question_types');
		return $query->result();
	}
	
	function department_tests_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->order_by('test_id', 'desc');
		$query = $this->db->get('tests');
		return $query->result();
	}
			
	function tests_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$this->db->order_by('test_id', 'desc');
		$query = $this->db->get('tests');
		return $query->result();
	}	
	
	function add_test($dept_id){	
		$test_title = $this->input->post('test_title');
		$test_type = $this->input->post('test_type');
		if($test_type==2){
			$anonymousTest = $this->input->post('anonymousTest');
		}else{
			$anonymousTest = 1;
		}
		$creation_date_time = time();
		$creation_date = strtotime(date('Y-m-d'));
		$creation_time = strtotime(date('H:i s'));
		
		if($test_type==2){
			$current_test_type=3;
		}else{
			$current_test_type=0;
		}
		
		$arr = array('department_id'=>$dept_id, 'test_title'=>$test_title, 'test_type'=>$test_type, 'anonymousTest'=>$anonymousTest, 'current_test_type'=>$current_test_type, 'creation_date'=>$creation_date, 'creation_time'=>$creation_time, 'creation_date_time'=>$creation_date_time);
		$this->db->insert('tests', $arr);
		$insert_id = $this->db->insert_id();	
		$randomletter1 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
		$randomletter2 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
		$test_code = $randomletter1.$insert_id.$randomletter2;
		$test_link =  base_url().'test/'.$test_code;
			$arr = array('test_code'=>$test_code);
			$this->db->where('test_id', $insert_id);
			$this->db->update('tests', $arr);			
		$this->session->set_flashdata('success', 'Survey added successfully!');
		redirect(base_url().'department/create/tests');
	}
	function test_details_by_id($test_id){
 		$this->db->where('test_id', $test_id);
		$query = $this->db->get('tests');
		return $query->row();
	}	
	
	function demography_question_save($test_id,$dept_id){
	
		$question_title = $this->input->post('tests_question_title');
		$question_type = $this->input->post('hidden_question_type');
		$point_value = 0;
		$creation_date = strtotime(date('Y-m-d'));	
 		$learning_outcomes_arr = '';
		
		$tests_questions_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'is_demography'=>'1', 
			'question_title'=>$question_title, 'question_type'=>$question_type, 'creation_date'=>$creation_date, 
			'point_value'=>$point_value,'learning_outcomes'=>$learning_outcomes_arr);
		$this->db->insert('tests_questions', $tests_questions_arr);
		$question_id=$this->db->insert_id(); 
		
		if(isset($question_type) && ($question_type==1 || $question_type==2 || $question_type==3 || $question_type==4)){
			$is_required = $this->input->post('validation_status');
			$required_message = $this->input->post('validation_error_message');
			$validation_arr = array('is_required'=>$is_required, 'required_message'=>$required_message);
			$this->db->where('question_id', $question_id);
			$this->db->update('tests_questions',$validation_arr);
		} 
		if(isset($question_type) && $question_type==1){
			$hidden_choice_count = $this->input->post('hidden_choice_count');
			for($i=1;$i<=$hidden_choice_count;$i++){
				$choices = $this->input->post('choice_'.$i);
				$test_question_answers_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'question_id'=>$question_id, 'answer_choice'=>$choices);
				$this->db->insert('test_question_answers', $test_question_answers_arr);
		  	}
		}
		
		$this->session->set_flashdata('success', 'Test demography question added successfully!');
		
	}
	 		
	function tests_questions_detail($test_id,$is_demography){
		$dept_id = $this->session->userdata('dept_id');
		if(isset($dept_id) && $dept_id!=''){
		$this->db->where('department_id', $dept_id);
		}
		$this->db->where('is_demography', $is_demography);
		$this->db->where('test_id', $test_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('tests_questions');
 		return $query->result();	
	}
	
	function tests_questions_detail_by_dept($test_id,$is_demography,$dept_id){
		$this->db->where('department_id', $dept_id);
		$this->db->where('is_demography', $is_demography);
		$this->db->where('test_id', $test_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('tests_questions');
 		return $query->result();	
	}
	
	function question_save($test_id,$dept_id){
		$question_title = $this->input->post('tests_question_title');
		$question_type = $this->input->post('hidden_question_type');
		$point_value = $this->input->post('point_value');
		$creation_date = strtotime(date('Y-m-d'));	
		$learning_outcomes_arr = '';
		
		$undergraduate_dam = $this->input->post('undergraduate_dam');
		if(isset($undergraduate_dam) && $undergraduate_dam!=''){
			if(count($undergraduate_dam)>0){			
				$learning_outcomes_arr = implode(',', $undergraduate_dam);
			}
		}
		
		$tests_questions_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'question_title'=>$question_title, 'question_type'=>$question_type, 'creation_date'=>$creation_date, 
'point_value'=>$point_value,'learning_outcomes'=>$learning_outcomes_arr);
		$this->db->insert('tests_questions', $tests_questions_arr);
		$question_id=$this->db->insert_id(); 
		if(isset($question_type) && ($question_type==1 || $question_type==2 || $question_type==3 || $question_type==4)){
			$is_required = $this->input->post('validation_status');
			$required_message = $this->input->post('validation_error_message');
			$validation_arr = array('is_required'=>$is_required, 'required_message'=>$required_message);
			$this->db->where('question_id', $question_id);
			$this->db->update('tests_questions',$validation_arr);
		} 
		if(isset($question_type) && $question_type==1){
			$hidden_choice_count = $this->input->post('hidden_choice_count');
			$answer_radio = $this->input->post('answer_radio');
			for($i=1;$i<=$hidden_choice_count;$i++){
				$choices = $this->input->post('choice_'.$i);
				$test_question_answers_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id,
					'question_id'=>$question_id, 'answer_choice'=>$choices);
				$this->db->insert('test_question_answers', $test_question_answers_arr);
				$answer_id=$this->db->insert_id();			
				if($answer_radio==$i){
					$ans_arr = array('correct_answer'=>$answer_id);
					$this->db->where('question_id', $question_id);
					$this->db->update('tests_questions',$ans_arr);
				}
		  	}
		}
		$this->session->set_flashdata('success', 'Test question added successfully!');
		redirect(base_url().'department/create/tests/management?tab_id=3&test_id='.$test_id.'&dept_id='.$dept_id);
	}
	
	public function set_order_questions(){	
		$list_order = $_POST['list_order']; 
		// convert the string list to an array
		$list = explode(',' , $list_order);
		$i = 1 ;
		foreach($list as $id){
			$arr =array('priority'=>$i);
			$this->db->where('question_id', $id);
			$this->db->update('tests_questions',$arr);
		$i++;}
	}
			
	public function get_tests_question_details($test_id,$question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('test_id', $test_id);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('tests_questions');
		return $query->row();
	}
	 
	public function get_tests_questions_fulldetails($question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('tests_questions');
		return $query->row();
	}	
	
	public function update_question_entry(){
		$hidden_tab_type = $this->input->post('hidden_tab_type');
		$dept_id=$this->session->userdata('dept_id');
		$question_id = $this->input->post('h_question_id');
		$question_type = $this->input->post('h_question_type');
		$test_id = $this->input->post('h_test_id');	
		$question_title = $this->input->post('test_question_title');
		$point_value = $this->input->post('point_value');
		$answer_radio = $this->input->post('answer_radio');	
		$is_required = $this->input->post('validation_status');				
		$required_message = $this->input->post('validation_error_message');	
		$learning_outcomes_arr = '';
		$undergraduate_dam = $this->input->post('undergraduate_dam');
		if(isset($undergraduate_dam) && $undergraduate_dam!=''){
			if(count($undergraduate_dam)>0){			
				$learning_outcomes_arr = implode(',', $undergraduate_dam);
			}
		}
		$questions_arr = array('question_title'=>$question_title, 'point_value'=>$point_value,'learning_outcomes'=>$learning_outcomes_arr, 'is_required'=>$is_required,'required_message'=>$required_message);
		$this->db->where('question_id', $question_id);
		$this->db->update('tests_questions',$questions_arr);	
			
		if($question_type==1){
			$answer_choice_arr = $this->input->post('answer_choice_id');
			//$count =  count($answer_choice_arr);
			for($i=0;$i<count($answer_choice_arr);$i++){
				$answer_id = $answer_choice_arr[$i];
				$answer_choice = $this->input->post('choice_'.$answer_id);
				$arr = array('answer_choice'=>$answer_choice);
				$this->db->where('answer_id', $answer_id);
				$this->db->update('test_question_answers',$arr);
				if($answer_radio==$answer_id){
					$ans_arr = array('correct_answer'=>$answer_id);
					$this->db->where('question_id', $question_id);
					$this->db->update('tests_questions',$ans_arr);
				}
			}				
		}					
		$newchoice_arr = $this->input->post('newchoice');
		if(isset($newchoice_arr) && $newchoice_arr!=''){
			for($j=0;$j<count($newchoice_arr);$j++){
				$newchoice = $newchoice_arr[$j];
				if(isset($newchoice) && $newchoice!=''){	
						$surveys_questions_answer_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'question_id'=>$question_id, 'answer_choice'=>$newchoice);
						$this->db->insert('test_question_answers', $surveys_questions_answer_arr);	
						$answer_id=$this->db->insert_id(); 
	
						$ans_arr = array('correct_answer'=>$answer_id);
						$this->db->where('question_id', $question_id);
						$this->db->update('tests_questions',$ans_arr);					
				}
			}
		}
		if(isset($hidden_tab_type)&& $hidden_tab_type=='test_question'){
			redirect(base_url().'department/create/tests/management?tab_id=3&test_id='.$test_id.'&dept_id='.$dept_id);
		}else{
			redirect(base_url().'department/create/tests/management?test_id='.$test_id.'&dept_id='.$dept_id);
		}

	}
	
	
	public function delete_question_choice($answer_id,$question_id,$question_type,$correct_answer){
		if($question_type==1){
			$this->db->where('answer_id', $answer_id);
			$query = $this->db->delete('test_question_answers');
			
			$this->db->where('answer', $answer_id);
			$this->db->where('question_type', $question_type);
			$this->db->where('question_id', $question_id);
			$query = $this->db->delete('test_answers');
			
			if($correct_answer==$answer_id){
				$ans_arr = array('correct_answer'=>'');
				$this->db->where('question_id', $question_id);
				$this->db->update('tests_questions',$ans_arr);
			}
		}			
  		$this->session->set_flashdata('success', 'Deleted successfully!');
  		if(isset($_GET['tab_type']) && $_GET['tab_type']=='test_question'){
			redirect(base_url().'department/create/tests/question/edit/'.$question_id);
		}else{
			redirect(base_url().'department/create/tests/demography/edit/'.$question_id);
		}
 
	}
	
	
	public function delete_test($test_id){
		$dept_id=$this->session->userdata('dept_id');	
 		$tables = array('tests', 'tests_course', 'tests_email', 'tests_questions', 'test_answers', 'test_criterion_option', 'test_question_answers');
		$this->db->where('test_id', $test_id);
		if(isset($dept_id) && $dept_id!=''){
			$this->db->where('department_id', $dept_id);
		}
		$this->db->delete($tables);
   		$this->session->set_flashdata('success', 'Test deleted successfully!');
  		redirect(base_url().'department/create/tests');
	}
		
	
	function edit_test($dept_id){	
		$test_id = $this->input->post('h_test_id');
		$test_title = $this->input->post('h_testname');
		$anonymousTest = $this->input->post('h_anonymousTest');
		$status = $this->input->post('h_teststatus');
		$last_modification = time();
		$arr = array('test_title'=>$test_title, 'anonymousTest'=>$anonymousTest,'status'=>$status,'last_modification'=>$last_modification);
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('tests', $arr);
		$this->session->set_flashdata('success', 'Test update successfully!');
		redirect(base_url().'department/create/tests');
	}	
	
	function delete_test_question($question_id,$test_id){	
 		$dept_id=$this->session->userdata('dept_id');	
		
		$tables = array('tests_questions', 'test_answers', 'test_question_answers');
		$this->db->where('test_id', $test_id);
		$this->db->where('question_id', $question_id);
		$this->db->delete($tables);
 			
		/*$arr = array('is_deleted'=>'1','priority'=>'0');
		$this->db->where('question_id', $question_id);
		$this->db->update('tests_questions',$arr);*/
			
		$this->db->where('test_id', $test_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query_get_priority = $this->db->get('tests_questions');
		$priority_count = $query_get_priority->num_rows();
		if($priority_count>0){			 
			$get_priority = $query_get_priority->result();
			$i=1;foreach($get_priority as $get_priority_details){
			
				$p_question_id = $get_priority_details->question_id;
				$priority_set = $i;
				$arr_p = array('priority'=>$i);
				//print_r($arr_p);
				$this->db->where('question_id', $p_question_id);
				$this->db->update('tests_questions',$arr_p);			
			$i++;}
		}		
		$this->session->set_flashdata('success', 'Deleted successfully!');
		
		if(isset($_GET['tab_id']) && $_GET['tab_id']!=''){
			redirect(base_url().'department/create/tests/management?tab_id='.$_GET['tab_id'].'&test_id='.$test_id.'&dept_id='.$dept_id);
		}else{
			redirect(base_url().'department/create/tests/management?test_id='.$test_id.'&dept_id='.$dept_id);
		}
	}	
	public function add_test_deadline(){	
		$test_id = $this->input->post('hidden_test_id');
		$dept_id = $this->input->post('hidden_dept_id');
		
		$current_test_type = trim($this->input->post('current_test_type'));
		
		$start_date = strtotime($this->input->post('start_date'));
		$end_date = strtotime($this->input->post('end_date'));
		
		if($current_test_type==1 || $current_test_type==2){
 			$post_start_date = strtotime($this->input->post('post_start_date'));
			$post_end_date = strtotime($this->input->post('post_end_date'));
 		}else{
			$post_start_date = '';;
			$post_end_date = '';
		}
		
		$question_per_page = $this->input->post('question_per_page');
		$time_limits = $this->input->post('time_limits');
		if(isset($_POST['self_rating'])&& $_POST['self_rating']=='0'){
			$self_rating = '0';
		}else{
			$self_rating = '1';
		}
		if(isset($_POST['minute_checkbox'])&& $_POST['minute_checkbox']=='0'){
			$time_limit_status = '0';
			$time_limits_in_second = $time_limits*60;
		}else{
			$time_limit_status = '1';
			$time_limits_in_second = '0';
		}
		$arr = array('current_test_type'=>$current_test_type,'start_date'=>$start_date, 'end_date'=>$end_date,'post_start_date'=>$post_start_date, 'post_end_date'=>$post_end_date, 
			'question_per_page'=>$question_per_page, 'self_rating'=>$self_rating,
			'time_limit_status'=>$time_limit_status, 'time_limits'=>$time_limits_in_second);
 		$this->db->where('test_id',$test_id); 
		$query = $this->db->update('tests', $arr);
  		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/tests/management?tab_id=4&test_id='.$test_id.'&dept_id='.$dept_id);	
	}
	function tests_course_detail($test_id){
		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('test_id', $test_id);
		if(isset($dept_id) && $dept_id!=''){
 		$this->db->where('department_id', $dept_id);
		}
		$this->db->where('status', '0');
		$query = $this->db->get('tests_course');
		return $query->result();
	}
		
	public function add_course(){
		$dept_id = $this->session->userdata('dept_id');
		$test_id = $this->input->post('test_id');
		$course_enrolled = $this->input->post('course_enrolled_1');
		$course_i = $this->input->post('course_i_1');
		$course_type = $this->input->post('course_type_1');
		$pslo_number = $this->input->post('pslo_number_1');
		$add_more_count = $this->input->post('add_more_count');
		$add_date = strtotime(date('Y-m-d'));
		
		$edit_core_function_count = $this->input->post('edit_course_count');
		if(isset($edit_core_function_count) && $edit_core_function_count!=''){
			if(count($edit_core_function_count)>0){
				for($i=0;$i<count($edit_core_function_count);$i++){
					$edit_core_func_id = $edit_core_function_count[$i];
					$course_enrolled_edit = $this->input->post('course_enrolled_edit_'.$edit_core_func_id);
					$course_i_edit = $this->input->post('course_i_edit_'.$edit_core_func_id);
					$course_type_edit = $this->input->post('course_type_edit_'.$edit_core_func_id);
					$pslo_number_edit = $this->input->post('pslo_number_edit_'.$edit_core_func_id);
					$arr_upate = array('course_enrolled'=>$course_enrolled_edit, 'course_i'=>$course_i_edit, 'course_type'=>$course_type_edit, 'pslo_number'=>$pslo_number_edit);
					$this->db->where('id', $edit_core_func_id);
					$this->db->update('tests_course',$arr_upate);
				}
			}
		}
		if(isset($course_enrolled) && $course_enrolled!='' && isset($course_i) && $course_i!='' && isset($course_type) && $course_type!='' && isset($pslo_number) && $pslo_number!=''){
			
			$tests_course_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'course_enrolled'=>$course_enrolled, 'course_i'=>$course_i, 'course_type'=>$course_type, 				'pslo_number'=>$pslo_number, 'add_date'=>$add_date);
			$this->db->insert('tests_course', $tests_course_arr);
		}
		
		$add_more_count = $this->input->post('add_more_count');
		if(isset($add_more_count) && $add_more_count!=''){
			if(count($add_more_count)>0){
				for($i=0;$i<count($add_more_count);$i++){
					$add_more_id = $add_more_count[$i];
					
					if(isset($_POST['course_enrolled_add_more_'.$add_more_id]) && $_POST['course_enrolled_add_more_'.$add_more_id]!=''){
						$course_enrolled_add = $this->input->post('course_enrolled_add_more_'.$add_more_id);
						$course_i_add = $this->input->post('course_i_add_more_'.$add_more_id);
						$course_type_add = $this->input->post('course_type_add_more_'.$add_more_id);
						$pslo_number_add = $this->input->post('pslo_number_add_more_'.$add_more_id);
						
						$tests_course_arr = array('department_id'=>$dept_id, 'test_id'=>$test_id, 'course_enrolled'=>$course_enrolled_add, 'course_i'=>$course_i_add, 'course_type'=>$course_type_add, 'pslo_number'=>$pslo_number_add, 'add_date'=>$add_date);
						$this->db->insert('tests_course', $tests_course_arr);
					}
				}
			}
		}		
  		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/tests/management?tab_id=2&test_id='.$test_id.'&dept_id='.$dept_id);	
	}
	public function delete_course($id, $test_id){
		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('id',$id); 
		$query = $this->db->delete('tests_course');
		
		$this->db->where('test_id', $test_id);
		$this->db->where('question_status', '3');
		$this->db->where(' FIND_IN_SET('.$id.', answer)');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('test_answers');
		$num_rows = $query->num_rows();
 		if($num_rows>0){
			$result = $query->result();
			foreach($result as $result_details){
				$main_id=$result_details->id;
				$courses_arr = explode(',',$result_details->answer);
 				if (($key = array_search($id, $courses_arr)) !== false) {
					unset($courses_arr[$key]);
				}
				if(count($courses_arr)>0){
					$course_update = implode(',',$courses_arr);
					$course_update_arr = array('answer'=>$course_update);
					$this->db->where('id',$main_id); 
					$query = $this->db->update('test_answers', $course_update_arr);					
				}else{
					$this->db->where('id',$main_id); 
					$query = $this->db->delete('test_answers');
				}								 
			}
		}
		
  		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/tests/management?tab_id=2&test_id='.$test_id.'&dept_id='.$dept_id);	
	}	
	function save_email($test_link){	
	
		$h_test_id = $this->input->post('h_test_id');
		$h_dept_id = $this->input->post('h_dept_id');
		$test_type = $this->input->post('h_test_type');
		
		$email_to_old = $this->input->post('email_to');
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');
		$add_date = time();
		$explode_to = explode(',', $email_to_old);		
		for($i=0; $i<count($explode_to); $i++){
			$email_to = $explode_to[$i];
			
			/*$this->db->where('test_id', $h_test_id);
			$this->db->where('department_id', $h_dept_id);
			$this->db->where('test_type', $test_type);
			$this->db->where('email_to', $email_to);
			$this->db->where('is_deleted', '0');
			$query = $this->db->get('tests_email');
			$num_rows = $query->num_rows();
			if($num_rows==0){
								
				$arr = array('test_type'=>$test_type,'test_id'=>$h_test_id, 'department_id'=>$h_dept_id, 'email_to'=>$email_to, 'email_subject'=>$email_subject, 'add_date'=>$add_date);
				$this->db->insert('tests_email', $arr);
				$insert_id = $this->db->insert_id();
				$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
				$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
				$email_code =  $randomletter1.$insert_id.$randomletter2;
				
				$data = array('auth_code'=>$email_code);
				$this->db->where('id', $insert_id);
				$this->db->update('tests_email', $data);
 			
			}else{
				
				$row = $query->row();
				$email_code = $row->auth_code;
				$insert_id = $row->id;
			
			}*/
			
			$this->db->where('email', $email_to);
			$query_amee_id = $this->db->get('email_ameeid');
			$num_rows_amee_id = $query_amee_id->num_rows();
			
			if($num_rows_amee_id==0){			
				
				$amee_id_arr = array('email'=>$email_to, 'added_from'=>'1', 'add_date'=>$add_date);
				$this->db->insert('email_ameeid', $amee_id_arr);	
				$amee_auto_id = $this->db->insert_id();
				
				$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
				$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
				$amee_id =  $randomletter1.$amee_auto_id.'6'.$randomletter2;
				
				$arr_amee_id1 = array('amee_id'=>$amee_id);
				$this->db->where('id', $amee_auto_id);
				$this->db->update('email_ameeid', $arr_amee_id1);	
				
			}
			
			$dept_session_details = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
			$department_name = $dept_session_details->department_name;
			
			//$message=str_replace('{auth_code}',$email_code,$email_message);
			$message= str_replace('{department_name}',$department_name,$message);
			send_mail($email_to,$message,'','info',$email_subject);
		}
		$this->session->set_flashdata('success', 'Test link sent to '.count($explode_to).' email addresses.');
		redirect(base_url().'department/create/tests/compose_email?tab_id=6&test_id='.$h_test_id.'&dept_id='.$h_dept_id.'&menu=2');	
	}
			
//===== ----- Test_results ----- =====//	
	
	function tests_email_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	function tests_student_complete_incomplete_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('start_date!=', '');
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	function student_test_complete_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('finish_status', '1');
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	function student_test_incomplete_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('start_date!=', '');
		$this->db->where('finish_status', '0');
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	function student_post_test_complete_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('post_finish_status', '1');
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	function student_post_test_incomplete_detail($test_id,$dept_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('post_start_date!=', '');
		$this->db->where('post_finish_status', '0');
		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('tests_email');
		return $query->result();
	}
	
	
}
?>