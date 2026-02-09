<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_form_mdl extends CI_Model {
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
	
	function start_survey_entry(){
		$survey_code = $this->input->post('h_survey_code');
		$survey_id = $this->input->post('h_survey_id');
		$department_id = $this->input->post('h_department_id');
		$anonymousSurvey = $this->input->post('h_anonymousSurvey');
				
		if($anonymousSurvey==1){		
			$first_name = $this->input->post('firstName');
			$last_name = $this->input->post('lastName');
			$email = $this->input->post('email');		
		}else{
			$first_name = '';
			$last_name = '';
			$email = $_SERVER['REMOTE_ADDR'];		
		}
		$add_date = time();
		
		/*$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $department_id);
		$this->db->where('email_to', $email);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('survey_email');
		$num_rows = $query->num_rows();
		if($num_rows==0){
 				
			
 		}else{
 			return 'error||Sorry, you already taken this survey.';
 		}*/
		
		$this->db->insert('survey_email', array('survey_id'=>$survey_id, 'department_id'=>$department_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email_to'=>$email,'email_subject'=>'', 'add_date'=>$add_date));
		$insert_id = $this->db->insert_id();
		$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
		$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
		$auth_code =  $randomletter1.$insert_id.$randomletter2;
		$data = array('auth_code'=>$auth_code);
		$this->db->where('id', $insert_id);
		$this->db->update('survey_email', $data);
		
		//$this->db->insert('survey_sweepstakes', array('survey_code'=>$survey_code, 'auth_code'=>$auth_code, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'add_date'=>$add_date));
		
		return 'success||'.$auth_code;
		
	}
	
	function sweepstakes_entry(){
		$survey_code = $this->input->post('h_survey_code');
		$survey_id = $this->input->post('h_survey_id');
		$auth_code = $this->input->post('h_auth_code');
			
		$this->db->where('survey_code', $survey_code);
		$this->db->where('auth_code', $auth_code);
		$query = $this->db->get('survey_sweepstakes');
		$num = $query->num_rows();
		if($num==0 && isset($auth_code)&& $auth_code>0){
		
			$first_name = $this->input->post('sweepstakes_first_name');
			$last_name = $this->input->post('sweepstakes_last_name');
			$email = $this->input->post('sweepstakes_email');
			
			$arr = array('survey_code'=>$survey_code, 'auth_code'=>$auth_code, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'add_date'=>time());
			$this->db->insert('survey_sweepstakes', $arr);		
		
		}
		redirect(base_url().'survey/complete/'.$survey_code.'/'.$auth_code);
	} 
	
	function survey_detail_by_code($survey_code){
		$this->db->where('survey_code', $survey_code);
		$query = $this->db->get('surveys');
		$num = $query->num_rows();
		if($num==0){
			redirect(base_url().'survey/error/surveynotavailable');
		}else{
			$row = $query->row();
			$survey_status = $row->status;
			if($survey_status==0){
			
				$survey_start_date = $row->survey_start_date;
				$survey_end_date = $row->survey_end_date;
				$current_time=time();
				if($current_time>=$survey_start_date && $current_time<=$survey_end_date){
					return $row;
				}else{
					redirect(base_url().'survey/error/survey_deadline_over');
				}
				
			}else{
				redirect(base_url().'survey/error/survey_deactive');
			}			
			
		}
	}		
 
	function update_survey_finish_status($auth_code){
		$arr = array('finish_status'=>'1','finish_date'=>time());
		$this->db->where('auth_code', $auth_code);
		$this->db->update('survey_email',$arr);
	}
	
	function check_already_take_survey($survey_id,$auth_code){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('finish_status', '1');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('survey_email');
		$num = $query->num_rows();
		if($num>0){
			redirect(base_url().'survey/error/already_taken');
		}
	}
	
	function surveys_questions_detail($survey_id, $limit, $page_number ){
		$offset = ($page_number-1)*$limit;
		$this->db->where('survey_id', $survey_id);
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->order_by('priority', 'asc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('surveys_questions');
		return $query->result();
	}
	
	function surveys_questions_num_rows($survey_id){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('surveys_questions');
		return $query->num_rows();
	}	
	
	function save_survey_answers($survey_id, $auth_code){
		$department_id = $this->input->post('h_department_id');
		$arr = array('department_id'=>$department_id, 'survey_id'=>$survey_id, 'auth_code'=>$auth_code, 'question_id'=>$question_id, 'answer'=>$answer);
		$query = $this->db->get('surveys_questions');
		return $query->num_rows();
	}	
	
	function answer_save(){
		
		$survey_code = $this->input->post('h_survey_code');
		$survey_id = $this->input->post('h_survey_id');
		$department_id = $this->input->post('h_department_id');
		$auth_code = $this->input->post('h_auth_code');
		$next_page_link = $this->input->post('next_page_link');
		$add_date = time();		
		
			if(count($_POST['h_question_id'])>0){
				for($i=0;count($_POST['h_question_id'])>$i;$i++){
					
				    $h_question_id = $_POST['h_question_id'][$i];
					  
					$matrix_query = $this->db->get_where('surveys_questions', array('question_id'=>$h_question_id));
					$matrix_row = $matrix_query->row();
 					if($matrix_row->question_type==2){
				
						if(count($_POST['row_id'])>0){
							for($j=0;count($_POST['row_id'])>$j;$j++){
								
								$h_row_id = $_POST['row_id'][$j];
								$matrix_answer = $_POST['matrix_field_name'.$h_row_id];
								
								if(isset($matrix_answer) && $matrix_answer!='' && isset($auth_code) && $auth_code!=0){
									
									$query = $this->db->get_where('survey_answers', array('auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'row_id'=>$h_row_id));
									$num = $query->num_rows();
									if($num==0){
										$arr = array('survey_id'=>$survey_id, 'department_id'=>$department_id, 'auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'is_matrix_question'=>'1', 'row_id'=>$h_row_id, 'answer'=>$matrix_answer, 'add_date'=>$add_date);
										$this->db->insert('survey_answers', $arr);
									}else{
										$arr = array('answer'=>$matrix_answer);
										$this->db->where('auth_code',$auth_code);
										$this->db->where('question_id',$h_question_id);
										$this->db->where('row_id',$h_row_id);
										$this->db->update('survey_answers',$arr);
									}								
									
								}
								
								check_skip_logic($h_question_id,$matrix_row->question_type,$survey_code,$auth_code,$matrix_answer); //  function define in master helper
								
							}	
						}					

					}else{
						
						if(isset($_POST['field_name'.$h_question_id]) && $_POST['field_name'.$h_question_id]!=''){							 
							
							if($matrix_row->question_type==7){
								$answer = '';
								$answerChk = $_POST['field_name'.$h_question_id];
								if(isset($answerChk) && $answerChk!='' && count($answerChk)>0){
									$answer = implode(',',$answerChk);
								}
							}else if($matrix_row->question_type==8){
								$answer = $_POST['field_name'.$h_question_id];
							}else{							
								$answer = $_POST['field_name'.$h_question_id];
							}
							if(isset($auth_code)&& $auth_code!=0){
								$query = $this->db->get_where('survey_answers', array('auth_code'=>$auth_code, 'question_id'=>$h_question_id));
								$num = $query->num_rows();
								if($num==0){
									$arr = array('survey_id'=>$survey_id, 'department_id'=>$department_id, 'auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'answer'=>$answer, 'add_date'=>$add_date);
									$this->db->insert('survey_answers', $arr);
								}else{
									$arr = array('answer'=>$answer);
									$this->db->where('auth_code',$auth_code);
									$this->db->where('question_id',$h_question_id);
									$this->db->update('survey_answers',$arr);
								}
								
								if($matrix_row->question_type==8){
									if(isset($answer) && $answer!=''){
										$answerArr = explode(',',$answer);
										$ro=1;
										foreach($answerArr as $answer_id){
											$qryRO = $this->db->get_where('survey_answers_rank_orders', array('survey_id'=>$survey_id, 'department_id'=>$department_id, 'auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'answer_id'=>$answer_id, 'is_delete'=>'0'));
											$numRo = $qryRO->num_rows();
											if($numRo==0){
												$this->db->insert('survey_answers_rank_orders', array('survey_id'=>$survey_id, 'department_id'=>$department_id, 'auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'answer_id'=>$answer_id, 'gaveOrder'=>$ro, 'add_date'=>$add_date));
											}
											$ro++;
										}
									}
								}
								
							}
							
							check_skip_logic($h_question_id,$matrix_row->question_type,$survey_code,$auth_code,$answer); //  function define in master helper
		
						}
					}
				}
			}	
		
		redirect($next_page_link);	
	}
	
}
?>