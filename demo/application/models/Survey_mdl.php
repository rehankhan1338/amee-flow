<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Survey_mdl extends CI_Model {
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
	
	public function update_survey_status($surveyId,$column_name,$status){
		$data = array("$column_name"=>$status);
		$this->db->where('survey_id', $surveyId);
		$this->db->update('surveys',$data);
		return 'success';
	}
	
	function get_survey_question_fulldetails($question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('surveys_questions');
		return $query->row();
	}
	
	function surveyCopying($dept_id){
		$creation_date_time = time();
		$creation_date = strtotime(date('Y-m-d'));
		$creation_time = strtotime(date('H:i s'));
		
		$copySurveyId = $this->input->post('copySurveyId');
		
		$this->db->where('survey_id', $copySurveyId);
		$query = $this->db->get('surveys');
		$num_rows = $query->num_rows();
		if($num_rows>0){
 			
			$row = $query->row();
 			$survey_name = $this->input->post('newSurveyName');
			
			$arr = array('department_id'=>$dept_id, 'survey_name'=>$survey_name, 'anonymousSurvey'=>$row->anonymousSurvey, 'reponses'=>'0', 'survey_sponsor_name'=>$row->survey_sponsor_name, 'survey_sponsor_logo'=>$row->survey_sponsor_logo, 'is_introduction_msg'=>$row->is_introduction_msg, 'survey_introduction'=>$row->survey_introduction, 'survey_message'=>$row->survey_message, 'question_per_page'=>$row->question_per_page, 'survey_start_date'=>$row->survey_start_date, 'survey_end_date'=>$row->survey_end_date, 'survey_sweepstakes'=>$row->survey_sweepstakes, 'survey_add_date'=>$row->creation_date, 'result_sweepstakes_status'=>$row->result_sweepstakes_status, 'survey_winners'=>$row->survey_winners, 'creation_date'=>$creation_date, 'creation_time'=>$creation_time, 'creation_date_time'=>$creation_date_time);
			$this->db->insert('surveys', $arr);
			$survey_id = $this->db->insert_id();
			
			$randomletter1 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$randomletter2 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$survey_code = $randomletter1.$survey_id.$randomletter2;
			
			$arr = array('survey_code'=>$survey_code);
			$this->db->where('survey_id', $survey_id);
			$this->db->update('surveys', $arr);
			
 			$this->db->where('is_deleted', '0');
			$this->db->where('department_id', $dept_id);
			$this->db->where('survey_id', $copySurveyId);
			$qry_ques = $this->db->get('surveys_questions');
			$ques_num_rows = $qry_ques->num_rows();
			if($ques_num_rows>0){
				$quesResult = $qry_ques->result();
				foreach($quesResult as $resQues){
				
					$this->db->insert('surveys_questions', array('survey_id'=>$survey_id, 'department_id'=>$dept_id, 'question_title'=>$resQues->question_title, 'question_type'=>$resQues->question_type, 'is_required'=>$resQues->is_required, 'required_message'=>$resQues->required_message, 'creation_date'=>$creation_date, 'nps_first_field'=>$resQues->nps_first_field, 'nps_middle_field'=>$resQues->nps_middle_field, 'nps_last_field'=>$resQues->nps_last_field, 'is_demography'=>$resQues->is_demography, 'status'=>$resQues->status, 'default_questions_id'=>$resQues->default_questions_id, 'priority'=>$resQues->priority));
					$insertedQuesId = $this->db->insert_id();
					
					$this->db->where('department_id', $dept_id);
					$this->db->where('survey_id', $copySurveyId);
					$this->db->where('question_id', $resQues->question_id);
					$qry_1 = $this->db->get('survey_question_answers');
					$cnt_1 = $qry_1->num_rows();
					if($cnt_1>0){
						$res_1 = $qry_1->result();
						foreach($res_1 as $quesAns){
							$this->db->insert('survey_question_answers', array('survey_id'=>$survey_id, 'department_id'=>$dept_id, 'question_id'=>$insertedQuesId, 'answer_choice'=>$quesAns->answer_choice));
							$insertedAnswerId = $this->db->insert_id();
							
							/*$this->db->where('survey_id', $survey_id);
							$this->db->where('question_id', $resQues->question_id);
							$this->db->where('answer_id', $quesAns->answer_id);
							$qry_sklo = $this->db->get('survey_answers_skip_logics');
							$cnt_sklo = $qry_sklo->num_rows();
							if($cnt_sklo>0){
								$res_sklo = $qry_sklo->result();
								foreach($res_sklo as $sklo){
									$this->db->insert('survey_answers_skip_logics', array('survey_id'=>$survey_id, 'question_id'=>$insertedQuesId, 'question_type'=>$sklo->question_type, 'answer_id'=>$insertedAnswerId, 'logic'=>$quesChoice->logic, 'skip_to'=>$quesChoice->skip_to, 'skip_status'=>$quesChoice->skip_status, 'add_date'=>$creation_date));
								}					
							}*/
							
						}					
					}
					
					$this->db->where('question_id', $resQues->question_id);
					$qry_2 = $this->db->get('survey_question_choices');
					$cnt_2 = $qry_2->num_rows();
					if($cnt_2>0){
						$res_2 = $qry_2->result();
						foreach($res_2 as $quesChoice){
							$this->db->insert('survey_question_choices', array('question_id'=>$insertedQuesId, 'choices'=>$quesChoice->choices, 'choices_status'=>$quesChoice->choices_status));
						}					
					}
					
					$this->db->where('question_id', $resQues->question_id);
					$qry_3 = $this->db->get('survey_question_choices_conditions');
					$cnt_3 = $qry_3->num_rows();
					if($cnt_3>0){
						$res_3 = $qry_3->result();
						foreach($res_3 as $quesChoiceCond){
							$this->db->insert('survey_question_choices_conditions', array('question_id'=>$insertedQuesId, 'answer_choice'=>$quesChoiceCond->answer_choice, 'choices_scale'=>$quesChoiceCond->choices_scale));
						}					
					}
					
				}				
			}
			$this->session->set_flashdata('success', 'Survey has been copied successfully!');	
			return 'success';	
			
		}
	}
	
	function delete_question_opt($row_id){
		$this->db->where('row_id', $row_id);
		$query = $this->db->get('survey_question_choices');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$row = $query->row();
			$choices = $row->choices;
			$this->db->delete('survey_question_choices', array('row_id' => $row_id));
			$this->db->delete('survey_question_choices_conditions', array('answer_choice' => $choices));
			$this->session->set_flashdata('success', 'Deleted successfully!');
		}
	}
	
	function remove_reponses($ids, $survey_id){
		if(isset($ids) && $ids!=''){
			$idsArr = explode(',',$ids);
			foreach($idsArr as $idAuth){
				$idAuthArr = explode('|',$idAuth);
				$id = $idAuthArr[0]; 
				$authCode = $idAuthArr[1];				
				$this->db->delete('survey_email', array('id' => $id, 'survey_id' => $survey_id));
				$this->db->delete('survey_answers', array('auth_code' => $authCode, 'survey_id' => $survey_id));				
			}
			$this->session->set_flashdata('success', 'Response has been deleted successfully!');	
		}
	}
	
	function get_survey_responses_data($dept_id,$survey_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('survey_email');
		return $query->result();
 	}
	
	function get_survey_complete_sts($survey_id){
 		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('finish_status', '1');
		$query = $this->db->get('survey_email');
		return $query->num_rows();
 	}
	
	function update_random_sweepstakes_winners($survey_winners_calculate_count,$survey_id,$survey_code){
		$dept_id=$this->session->userdata('dept_id');
		$subdomain_name = $this->db->dbprefix;
		
		$winner_update_arr = array('winner_status'=>'0');
		$this->db->where('survey_code', $survey_code);
		$this->db->update('survey_sweepstakes',$winner_update_arr);
		
		if($survey_winners_calculate_count>0){
 			$where = ' survey_code="'.$survey_code.'" ORDER BY RAND() LIMIT '.$survey_winners_calculate_count;
			$this->db->where($where);
			$query = $this->db->get('survey_sweepstakes');
			//echo $query->num_rows();	die;
			$result = $query->result();
			foreach($result as $result_details){
				$winner_id = $result_details->id;
				$winner_arr = array('winner_status'=>'1');
				$this->db->where('id', $winner_id);
				$this->db->update('survey_sweepstakes',$winner_arr);
			}
			
			$result_sweepstakes_status_arr = array('result_sweepstakes_status'=>'1');
			$this->db->where('survey_id', $survey_id);
			$this->db->update('surveys',$result_sweepstakes_status_arr);
 		}
		redirect(base_url().'department/create/survey/management?tab_id=5&survey_id='.$survey_id.'&dept_id='.$dept_id);		
	}
	
	function update_survey_status_btn($status,$survey_id){
		$dept_id=$this->session->userdata('dept_id');
		$arr = array('status'=>$status);
		$this->db->where('survey_id', $survey_id);
		$this->db->update('surveys',$arr);
		redirect(base_url().'department/create/survey/management?survey_id='.$survey_id.'&dept_id='.$dept_id);		
	}
	
	function get_sweepstakes_winners_listing($survey_code){
		$this->db->where('survey_code', $survey_code);
		$this->db->where('winner_status', '1');
		$query_winner = $this->db->get('survey_sweepstakes');
		return $query_winner->result();
	}
	
	function get_percentage_of_nps_status($status,$survey_id,$question_id){
		if($status=='promoters'){
			$where = ' answer in (9,10)';
			$this->db->where($where);
		}else if($status=='detractors'){
			$where = ' answer in (0,1,2,3,4,5,6)';
			$this->db->where($where);
		}else if($status=='passives'){
			$where = ' answer in (7,8)';
			$this->db->where($where);
		}	
		$this->db->where('survey_id', $survey_id);
		$this->db->where('question_id', $question_id);
 		$query = $this->db->get('survey_answers');
		return $query->num_rows();
 	}
	
	public function get_cross_all_count_from_authcodes_and_choice_answer_id($question_id,$auth_codes){
		$where = ' auth_code in ('.$auth_codes.')';
		$this->db->where($where);
		$this->db->where('question_id',$question_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();	
	}
	
	public function get_cross_count_from_authcodes_and_choice_answer_id($answer_id,$question_id,$auth_codes){
		$where = ' auth_code in ('.$auth_codes.')';
		$this->db->where($where);
		$this->db->where('question_id',$question_id);
		$this->db->where('answer',$answer_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();	
	}
	
	public function get_authcode_from_cross_tabu_choice_id($answer_id,$question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('answer',$answer_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('survey_answers');
		return $query->result();	
	}
	
	function get_all_authcode_listing($survey_id){
 		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('survey_email');
		return $query->result();
 	}
	
	function survey_question_reponses_check($survey_id,$question_id){
 		$this->db->where('question_id', $question_id);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
 	}
	
	function get_all_authcode_textbox_answer_listing($survey_id,$question_id,$auth_code){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('survey_answers');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->answer;
		}	
	}
	
	function get_multiple_choice_rating_ajax($scale_id){
 		$this->db->where('id', $scale_id);
		$query = $this->db->get('5pt_rating_scale');
		return $query->row();
	}
	
	function delete_survey_question($question_id,$survey_id){	
 		$dept_id=$this->session->userdata('dept_id');			
		
		$this->db->where('question_id', $question_id);
		$query = $this->db->delete('survey_question_choices');
		
		$this->db->where('question_id', $question_id);
		$query = $this->db->delete('survey_question_choices_conditions');
		
		$tables = array('surveys_questions', 'survey_answers', 'survey_answers_skip_logics', 'survey_question_answers');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('question_id', $question_id);
		$this->db->delete($tables);
		
		/*$arr = array('is_deleted'=>'1','priority'=>'0');
		$this->db->where('question_id', $question_id);
		$this->db->update('surveys_questions',$arr);*/
		
		
		
		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query_get_priority = $this->db->get('surveys_questions');
		$priority_count = $query_get_priority->num_rows();
		if($priority_count>0){			 
			$get_priority = $query_get_priority->result();
			$i=1;foreach($get_priority as $get_priority_details){
			
				$p_question_id = $get_priority_details->question_id;
				$priority_set = $i;
				$arr_p = array('priority'=>$i); 
				$this->db->where('question_id', $p_question_id);
				$this->db->update('surveys_questions',$arr_p);
			
			$i++;}
		}		
		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
	}
	
	function delete_question_choice($answer_id,$question_id,$question_type){
	
		$dept_id=$this->session->userdata('dept_id');	
		$tables = array('survey_answers');
		$this->db->where('answer', $answer_id);
		$this->db->where('question_id', $question_id);
		$this->db->where('department_id', $dept_id);
		$this->db->delete($tables);
  		
		$tables_another = array('survey_question_choices', 'survey_question_choices_conditions', 'survey_question_answers');
		$this->db->where('question_id', $question_id);
		$this->db->delete($tables_another);
				
		$this->db->where('answer_id', $answer_id);
		$this->db->where('question_id', $question_id);
		$this->db->where('question_type', $question_type);
		$query = $this->db->get('survey_answers_skip_logics');
		$num_rows=$query->num_rows();
		
		if($num_rows==0){
			$this->db->where('answer_id', $answer_id);
			$this->db->where('question_id', $question_id);
			$this->db->where('question_type', $question_type);
			$query = $this->db->delete('survey_answers_skip_logics');
		}		
  		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/survey/question/edit/'.$question_id);
	}
	 
	
	function update_question_entry(){
	
		$dept_id=$this->session->userdata('dept_id');
		$question_id = $this->input->post('hidden_question_id');
		$question_type_old = $this->input->post('hidden_old_question_type');
		$question_type = $this->input->post('hidden_question_type');
		$survey_id = $this->input->post('hidden_survey_id');			
		$question_title = $this->input->post('survey_question_title');		
  		$is_required = $this->input->post('validation_status');
		$required_message = $this->input->post('validation_error_message');		
		
		$questions_arr = array('question_title'=>$question_title, 'question_type'=>$question_type, 'is_required'=>$is_required, 'required_message'=>$required_message);
		$this->db->where('question_id', $question_id);
		$this->db->update('surveys_questions',$questions_arr);	
		
		/*if($question_type==1){
			
			$is_demography = $this->input->post('is_demography');
			$is_demography_arr = array('is_demography'=>$is_demography);
			$this->db->where('question_id', $question_id);
			$this->db->update('surveys_questions',$is_demography_arr);	
			
		}*/	

		if($question_type_old==$question_type){
		
			if($question_type==1 || $question_type==7 || $question_type==8){
 				
				$answer_choice_arr = $this->input->post('answer_choice_id');
				if(isset($answer_choice_arr) && $answer_choice_arr!='' && count($answer_choice_arr)>0){
 					for($i=0;$i<count($answer_choice_arr);$i++){
						$answer_id = $answer_choice_arr[$i];
						$answer_choice = $this->input->post('old_choice_'.$answer_id);
						$arr = array('answer_choice'=>$answer_choice);
						$this->db->where('answer_id', $answer_id);
						$this->db->update('survey_question_answers',$arr);
					}	
 				}
				
				$new_choice_arr = $this->input->post('new_choice_arr');
				if(isset($new_choice_arr) && $new_choice_arr!=''){
					if(count($new_choice_arr)>0){
					for($j=0;$j<count($new_choice_arr);$j++){
						$new_choice_id = $new_choice_arr[$j];
						$new_choice_value = $this->input->post('choice_'.$new_choice_id);
						if(isset($new_choice_value) && $new_choice_value!=''){				
							$surveys_questions_answer_arr = array('department_id'=>$dept_id, 'survey_id'=>$survey_id, 'question_id'=>$question_id, 'answer_choice'=>$new_choice_value);
							$this->db->insert('survey_question_answers', $surveys_questions_answer_arr);	
						}
					}
					}
				}			  
		 		
			} 
			
			if($question_type==4){
				
				$nps_first_field = $this->input->post('npsq_first_field');		
				$nps_middle_field = $this->input->post('npsq_middle_field');
				$nps_last_field = $this->input->post('npsq_last_field');	
				
				$nps_arr = array('nps_first_field'=>$nps_first_field,'nps_middle_field'=>$nps_middle_field,'nps_last_field'=>$nps_last_field);
				$this->db->where('question_id', $question_id);
				$this->db->update('surveys_questions',$nps_arr);	
				
			}
			
			if($question_type==2){
				
				$column_id_arr = $this->input->post('h_column_id');
				$h_column_name_arr = $this->input->post('h_column_name');
				if(isset($column_id_arr) && $column_id_arr!='' && count($column_id_arr)>0){
					for($i=0;$i<count($column_id_arr);$i++){
						$row_id = $column_id_arr[$i];
						$column_name = $h_column_name_arr[$i];
 						$scale_column_choice = $this->input->post('old_field_matrix_column_'.$row_id);
						$arr = array('choices'=>$scale_column_choice);
						$this->db->where('row_id', $row_id);
						$this->db->update('survey_question_choices',$arr);
						
						$first_arr = array('answer_choice'=>$scale_column_choice);
						$this->db->where('answer_choice', $column_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('survey_question_choices_conditions',$first_arr);
						
						$second_arr = array('choices_scale'=>$scale_column_choice);
						$this->db->where('choices_scale', $column_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('survey_question_choices_conditions',$second_arr);
  						 
					}
				}
				
				$row_id_arr = $this->input->post('h_statement_row_id');
				$h_row_name_arr = $this->input->post('h_statement_row_name');
				if(isset($row_id_arr) && $row_id_arr!='' && count($row_id_arr)>0){
					for($i=0;$i<count($row_id_arr);$i++){
						$row_id = $row_id_arr[$i];
						$row_name = $h_row_name_arr[$i];
 						$scale_row_choice = $this->input->post('old_field_matrix_row_'.$row_id);
						$arr = array('choices'=>$scale_row_choice);
						$this->db->where('row_id', $row_id);
						$this->db->update('survey_question_choices',$arr);
						
						$row_first_arr = array('answer_choice'=>$scale_row_choice);
						$this->db->where('answer_choice', $row_name);
						$this->db->where('question_id', $question_id);
 						$this->db->update('survey_question_choices_conditions',$row_first_arr);				
						 
					}
				}
				 
 				$h_tr_row_count = $this->input->post('h_tr_row_count');
				$h_tr_colum_count = $this->input->post('h_tr_colum_count');
				if(isset($h_tr_colum_count) && $h_tr_colum_count!=''){// && count($h_tr_colum_count)>0
					for($i=1;$i<=$h_tr_colum_count;$i++){
						$matrix_column = $this->input->post('field_matrix_column_'.$i);
						
						$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
						$this->db->insert('survey_question_choices', $matrix_row_arr);
						
						$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
						$this->db->insert('survey_question_choices_conditions', $matrix_row_arr132);
 					}
				}
				 
				if(isset($h_tr_row_count) && $h_tr_row_count!=''){// && count($h_tr_row_count)>0
					for($i=1;$i<=$h_tr_row_count;$i++){
					
						$matrix_row = $this->input->post('field_matrix_row_'.$i);
 						$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
						$this->db->insert('survey_question_choices', $matrix_row_arr);
						
						if(($h_tr_colum_count)>0){
							for($j=1;$j<=$h_tr_colum_count;$j++){
								$choices_scale = $this->input->post('field_matrix_column_'.$j);
								$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
								$this->db->insert('survey_question_choices_conditions', $matrix_row_arr12);
							}
						}
					} 
				}
				
				$this->db->where('choices_status', '0');
				$this->db->where('question_id', $question_id);
				$this->db->order_by('row_id', 'asc');
				$query = $this->db->get('survey_question_choices');
				$result_survey_question_choices =  $query->result();
				foreach($result_survey_question_choices as $statement_choice_details){
				
					$statement_choices_label = $statement_choice_details->choices;
				
					$this->db->where('choices_status', '1');
					$this->db->where('question_id', $question_id);
					$this->db->order_by('row_id', 'asc');
					$query_columns_choices = $this->db->get('survey_question_choices');
					$result_columns_choices =  $query_columns_choices->result();
					foreach($result_columns_choices as $scale_choice_details){
						
						$scale_choices_label = $scale_choice_details->choices;
						
						$this->db->where('answer_choice', $statement_choices_label);
						$this->db->where('choices_scale', $scale_choices_label);
						$this->db->where('question_id', $question_id);
						$query_conditions_choices = $this->db->get('survey_question_choices_conditions');
						$conditions_choices_num_rows =  $query_conditions_choices->num_rows();
						if($conditions_choices_num_rows==0){
							$matrix_row_arr123 =array('question_id'=>$question_id, 'answer_choice'=>$statement_choices_label, 'choices_scale'=>$scale_choices_label);
							$this->db->insert('survey_question_choices_conditions', $matrix_row_arr123);
						}
						
					}
						 
				}
				 
			}
  			 
		}else{
 			
			if($question_type_old==1 || $question_type_old==7 || $question_type==8){
 				$this->db->delete('survey_question_answers', array('department_id' => $dept_id,'survey_id' => $survey_id,'question_id' => $question_id));
 			}else if($question_type_old==2){
 				$this->db->delete('survey_question_choices', array('question_id' => $question_id));
				$this->db->delete('survey_question_choices_conditions', array('question_id' => $question_id));
 			}else if($question_type_old==4){
 				$questions_arr = array('nps_first_field'=>'', 'nps_middle_field'=>'', 'nps_last_field'=>'');
				$this->db->where('question_id', $question_id);
				$this->db->update('surveys_questions',$questions_arr);
 			}			
			 
			if($question_type==1 || $question_type==7 || $question_type==8){
			
				$new_choice_arr = $this->input->post('new_choice_arr');
				if(isset($new_choice_arr) && $new_choice_arr!='' && count($new_choice_arr)>0){
					for($j=0;$j<count($new_choice_arr);$j++){
						$new_choice_id = $new_choice_arr[$j];
						$new_choice_value = $this->input->post('choice_'.$new_choice_id);
						if(isset($new_choice_value) && $new_choice_value!=''){				
							$surveys_questions_answer_arr = array('department_id'=>$dept_id, 'survey_id'=>$survey_id, 'question_id'=>$question_id, 'answer_choice'=>$new_choice_value);
							$this->db->insert('survey_question_answers', $surveys_questions_answer_arr);	
						}
					}
				}
			}
			
			if($question_type==2){
				$h_tr_row_count = $this->input->post('h_tr_row_count');
				$h_tr_colum_count = $this->input->post('h_tr_colum_count');
				
				for($i=1;$i<=$h_tr_colum_count;$i++){
					$matrix_column = $this->input->post('field_matrix_column_'.$i);
					
					$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
					$this->db->insert('survey_question_choices', $matrix_row_arr);
					
					$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
					$this->db->insert('survey_question_choices_conditions', $matrix_row_arr132);
				}
				
				for($i=1;$i<=$h_tr_row_count;$i++){
					$matrix_row = $this->input->post('field_matrix_row_'.$i);
					
					$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
					$this->db->insert('survey_question_choices', $matrix_row_arr);
					
					for($j=1;$j<=$h_tr_colum_count;$j++){
						$choices_scale = $this->input->post('field_matrix_column_'.$j);
						$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
						$this->db->insert('survey_question_choices_conditions', $matrix_row_arr12);
					}
				}		  	
							
			}
					
			if($question_type==4){
			
				$nps_first_field = $this->input->post('npsq_first_field');
				$nps_middle_field = $this->input->post('npsq_middle_field');
				$nps_last_field = $this->input->post('npsq_last_field');
				
				$nps_arr =array('nps_first_field'=>$nps_first_field, 'nps_middle_field'=>$nps_middle_field, 'nps_last_field'=>$nps_last_field);
				$this->db->where('question_id', $question_id);
				$this->db->update('surveys_questions',$nps_arr);
			}
		}
		 
		redirect(base_url().'department/create/survey/question/edit/'.$question_id);
		//redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
	}
	
	function edit_skip_logic_condition_entry(){
		
		$dept_id=$this->session->userdata('dept_id');
		$question_id = $this->input->post('h_question_id');
		$skip_id = $this->input->post('h_skip_id');
		$survey_id = $this->input->post('h_survey_id');
		$answer_id = $this->input->post('edit_answer_id_condition');
		$logic = $this->input->post('edit_logic_operator');
		$skip_to = $this->input->post('edit_logic_skip_to');
		
		$arr = array('answer_id'=>$answer_id,'logic'=>$logic, 'skip_to'=>$skip_to);
		$this->db->where('id', $skip_id);
		$this->db->update('survey_answers_skip_logics',$arr);
		
		$this->session->set_flashdata('success', 'Skip logic save and updated successfully!');
  		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
		
	}
	
	function delete_skip_logic_condition($skip_id,$survey_id){
		$dept_id=$this->session->userdata('dept_id');
		$this->db->where('id', $skip_id);
		$query = $this->db->delete('survey_answers_skip_logics');
  		$this->session->set_flashdata('success', 'Skip logic condition deleted successfully!');
		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
	}
	
	function check_status_of_survey_started($survey_id){
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->where('survey_id', $survey_id);
		$query = $this->db->get('survey_answers');
		return $query->num_rows();
	}
	
	function check_question_skip_logic_count($survey_id){
		$this->db->where('skip_status', '1');
		$this->db->where('survey_id', $survey_id);
		$query = $this->db->get('survey_answers_skip_logics');
		return $query->num_rows();
	} 
	
	function get_skip_to_question_list($survey_id,$question_priority){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('priority>', $question_priority);
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('surveys_questions');
		return $query->result();
	}  
	
	
	function add_skip_logic_entry(){		
		$dept_id=$this->session->userdata('dept_id');
		$question_id = $this->input->post('h_question_id');
		$survey_id = $this->input->post('h_survey_id');
		$answer_id = $this->input->post('add_answer_id_condition');
		$logic = $this->input->post('add_logic_operator');
		$skip_to = $this->input->post('add_logic_skip_to');
		if($skip_to=='finish_survey'){
			$skip_status=0;
		}else{
			$skip_status=1;
		}
		$this->db->where('question_id', $question_id);
		$query_questions = $this->db->get('surveys_questions');
		$row_questions = $query_questions->row();
		$question_type = $row_questions->question_type;
		
		$this->db->where('answer_id', $answer_id);
		$this->db->where('question_id', $question_id);
		$this->db->where('question_type', $question_type);
		$query = $this->db->get('survey_answers_skip_logics');
		$num_rows=$query->num_rows();
		
		if($num_rows==0){			 	
		 	$add_date = time();
  			$arr = array('survey_id'=>$survey_id, 'question_id'=>$question_id, 'question_type'=>$question_type, 'answer_id'=>$answer_id, 'logic'=>$logic, 'skip_to'=>$skip_to, 'skip_status'=>$skip_status, 'add_date'=>$add_date);
 			$this->db->insert('survey_answers_skip_logics',$arr);		
		}else{
			$arr = array('logic'=>$logic, 'skip_to'=>$skip_to, 'skip_status'=>$skip_status);
 			$this->db->where('survey_id', $survey_id);
			$this->db->where('answer_id', $answer_id);
			$this->db->where('question_id', $question_id);
			$this->db->where('question_type', $question_type);
 			$this->db->update('survey_answers_skip_logics',$arr);			
		}
		
		$this->session->set_flashdata('success', 'Skip logic save and updated successfully!');
  		redirect(base_url().'department/create/survey/management?tab_id=2&survey_id='.$survey_id.'&dept_id='.$dept_id);
		
	}
	
	function get_survey_question_details($survey_id,$question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('surveys_questions');
		return $query->row();
	} 
	
	function get_skip_logic_condition_fulldetails($skip_id){
		$this->db->where('id', $skip_id);
		$query = $this->db->get('survey_answers_skip_logics');
		return $query->row();
 	}
	
	function get_edit_skip_logic_answer_details_ajax($skip_id,$question_id,$question_type){
		$subdomain_name = $this->db->dbprefix;
		if($question_type==1 || $question_type==7 || $question_type==8){
		
			$where = ' question_id="'.$question_id.'" and answer_id not in(select answer_id from '.$subdomain_name.'survey_answers_skip_logics where id!="'.$skip_id.'" and question_type="'.$question_type.'")';
			$this->db->where($where);
			$query = $this->db->get('survey_question_answers');
			return $query->result();
		
		}
		
		if($question_type==2){
		
			$where = ' choices_scale!="" and question_id="'.$question_id.'" and answer_id not in(select answer_id from '.$subdomain_name.'survey_answers_skip_logics where id!="'.$skip_id.'" and question_type="'.$question_type.'")';
			$this->db->where($where);
			$query = $this->db->get('survey_question_choices_conditions');
			return $query->result();
		
		}
	}
	
	function get_skip_logic_answer_details($question_id,$question_type){
		$subdomain_name = $this->db->dbprefix;
		if($question_type==1 || $question_type==7 || $question_type==8){
			$where = ' question_id="'.$question_id.'" and answer_id not in(select answer_id from '.$subdomain_name.'survey_answers_skip_logics where question_type="'.$question_type.'")';
			$this->db->where($where);
			$query = $this->db->get('survey_question_answers');
			return $query->result();
		}
		if($question_type==2){
			$where = ' choices_scale!="" and question_id="'.$question_id.'" and answer_id not in(select answer_id from '.$subdomain_name.'survey_answers_skip_logics where question_type="'.$question_type.'")';
			$this->db->where($where);
			$query = $this->db->get('survey_question_choices_conditions');
			return $query->result();
		}
	}
	
	function get_skip_logic_conditions_details($question_id){
		$this->db->where('question_id', $question_id);
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('survey_answers_skip_logics');
		return $query->result();
 	}
	
	function get_master_question_type(){
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('survey_master_question_types'); 
		return $query->result();
	}
	
	function department_survey_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('is_deleted', '0');
		$this->db->order_by('survey_id', 'desc');
		$query = $this->db->get('surveys');
		return $query->result();
	}
	
	function survey_listing($dept_id){
 		$this->db->where('department_id', $dept_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('survey_id', 'desc');
		$query = $this->db->get('surveys');
		return $query->result();
	}
	
	function survey_fulldetails($survey_id){
 		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('surveys');
		return $query->row();
	}	
	
	function get_survey_questions_details($dept_id,$survey_id){
		$this->db->where('department_id', $dept_id);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('surveys_questions');
 		return $query->result();	
	}
	
	function add_survey($dept_id){	
		$survey_name = $this->input->post('create_survey');
		$anonymousSurvey = $this->input->post('anonymousSurvey');
		$creation_date_time = time();
		$creation_date = strtotime(date('Y-m-d'));
		$creation_time = strtotime(date('H:i s'));
		$arr = array('department_id'=>$dept_id, 'survey_name'=>$survey_name, 'anonymousSurvey'=>$anonymousSurvey, 'creation_date'=>$creation_date, 'creation_time'=>$creation_time, 'creation_date_time'=>$creation_date_time, 'question_per_page'=>'1');
		$this->db->insert('surveys', $arr);
		$insert_id = $this->db->insert_id();
		
		$randomletter1 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
		$randomletter2 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
		$survey_code = $randomletter1.$insert_id.$randomletter2;
		//$survey_link =  base_url().'survey/form/'.$survey_code;
		
			$arr = array('survey_code'=>$survey_code);
			$this->db->where('survey_id', $insert_id);
			$this->db->update('surveys', $arr);
			
		$this->session->set_flashdata('success', 'Survey added successfully!');
		redirect(base_url().'department/create/surveys');
	}
	
	function edit_survey($dept_id){	
		$survey_id = $this->input->post('h_survey_id');
		$survey_name = $this->input->post('h_surveyname');
		$anonymousSurvey = $this->input->post('h_anonymousSurvey');
		$surveystatus = $this->input->post('h_surveystatus');
		$last_modification = time();
		$arr = array('survey_name'=>$survey_name,'anonymousSurvey'=>$anonymousSurvey,'status'=>$surveystatus,'last_modification'=>$last_modification);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->update('surveys', $arr);
		$this->session->set_flashdata('success', 'Survey update successfully!');
		redirect(base_url().'department/create/surveys');
	}
	
	public function delete_survey($survey_id){
 		$tables_another = array('survey_answers_skip_logics');
		$this->db->where('survey_id', $survey_id);
		$this->db->delete($tables_another);
		
		$dept_id=$this->session->userdata('dept_id');	
		$tables = array('surveys', 'surveys_questions', 'survey_answers', 'survey_email', 'survey_question_answers');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->delete($tables);
  		
		
		
		/*$arr = array('is_deleted'=>'1');
		$this->db->where('survey_id', $survey_id);
		$this->db->update('surveys', $arr);*/
		
  		$this->session->set_flashdata('success', 'Survey deleted successfully!');
  		redirect(base_url().'department/create/surveys');
	}	
	
	
//=====--survey_email--=====//	
	function save_email($survey_code){	
	
		$h_survey_id = $this->input->post('h_survey_id');
		$h_dept_id = $this->input->post('h_dept_id'); 
		$email_to_old = $this->input->post('email_to');
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');
		
		$data = array('survey_send_message'=>$email_message); 
 		$this->db->where('survey_id', $h_survey_id);
		$this->db->update('surveys', $data);
		
		$add_date = time();
		$explode_to = explode(',', $email_to_old);
			
		for($i=0; $i<count($explode_to); $i++){
			$email_to = $explode_to[$i];
			
			$this->db->where('survey_id', $h_survey_id);
			$this->db->where('department_id', $h_dept_id);
			$this->db->where('email_to', $email_to);
			$this->db->where('is_deleted', '0');
			$query = $this->db->get('survey_email');
			$num_rows = $query->num_rows();
			if($num_rows==0){
				
				$arr = array('survey_id'=>$h_survey_id, 'department_id'=>$h_dept_id, 'email_to'=>$email_to,'email_subject'=>$email_subject, 'add_date'=>$add_date);
				$this->db->insert('survey_email', $arr);
				$insert_id = $this->db->insert_id();
				$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
				$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
				$email_code =  $randomletter1.$insert_id.$randomletter2;
				
				$data = array('auth_code'=>$email_code);
				$this->db->where('id', $insert_id);
				$this->db->update('survey_email', $data);
				
			}else{
			
				$row = $query->row();
				$email_code = $row->auth_code;
				$insert_id = $row->id;
			
			}
			
			$dept_session_details = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
			$department_name = $dept_session_details->department_name;
				
			$message=str_replace('{auth_code}',$email_code,$email_message);
			$message= str_replace('{department_name}',$department_name,$message);
 			send_mail($email_to,$message,'','info',$email_subject);
			//sleep for 3 seconds
			sleep(1);
		}
		$this->session->set_flashdata('success', 'Survey link sent to '.count($explode_to).' email addresses.');
		redirect(base_url().'department/create/survey/compose_email?tab_id=3&survey_id='.$h_survey_id.'&dept_id='.$h_dept_id.'&menu=2');	
	}
		
	function question_save($survey_id,$dept_id){
	
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
		 
		$question_title = $this->input->post('survey_question_title');
		$question_type = $this->input->post('hidden_question_type');
		$creation_date = strtotime(date('Y-m-d'));		
  			
		$surveys_questions_arr = array('department_id'=>$dept_id, 'survey_id'=>$survey_id, 'question_title'=>$question_title, 'question_type'=>$question_type, 'creation_date'=>$creation_date, 'priority'=>$priority_set);
		$this->db->insert('surveys_questions', $surveys_questions_arr);
		$question_id=$this->db->insert_id();
	 
		if(isset($question_type) && ($question_type==1 || $question_type==3 || $question_type==2 || $question_type==4 || $question_type==7 || $question_type==8)){
			$is_required = $this->input->post('validation_status');
			$required_message = $this->input->post('validation_error_message');
			$validation_arr = array('is_required'=>$is_required, 'required_message'=>$required_message);
			$this->db->where('question_id', $question_id);
			$this->db->update('surveys_questions',$validation_arr);
		}
		
		if(isset($question_type) && ($question_type==1 || $question_type==7 || $question_type==8)){
			//$is_demography = $this->input->post('is_demography');
			$is_demography = 0;
			$demography_arr = array('is_demography'=>$is_demography);
			$this->db->where('question_id', $question_id);
			$this->db->update('surveys_questions',$demography_arr);
			
			$hidden_choice_count = $this->input->post('hidden_choice_count');
			for($i=1;$i<=$hidden_choice_count;$i++){
				$choices = $this->input->post('choice_'.$i);
				$surveys_questions_answer_arr = array('department_id'=>$dept_id, 'survey_id'=>$survey_id, 'question_id'=>$question_id, 'answer_choice'=>$choices);
				$this->db->insert('survey_question_answers', $surveys_questions_answer_arr);
				$answer_id=$this->db->insert_id();
		  	}
		}	
			
		if(isset($question_type) && $question_type==2){
			$h_tr_row_count = $this->input->post('h_tr_row_count');
			$h_tr_colum_count = $this->input->post('h_tr_colum_count');
			
			for($i=1;$i<=$h_tr_colum_count;$i++){
				$matrix_column = $this->input->post('field_matrix_column_'.$i);
				
				$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_column, 'choices_status'=>'1');
				$this->db->insert('survey_question_choices', $matrix_row_arr);
				
				$matrix_row_arr132 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_column);
				$this->db->insert('survey_question_choices_conditions', $matrix_row_arr132);
		  	}
			
			for($i=1;$i<=$h_tr_row_count;$i++){
				$matrix_row = $this->input->post('field_matrix_row_'.$i);
				
				$matrix_row_arr =array('question_id'=>$question_id, 'choices'=>$matrix_row, 'choices_status'=>'0');
				$this->db->insert('survey_question_choices', $matrix_row_arr);
				
				for($j=1;$j<=$h_tr_colum_count;$j++){
					$choices_scale = $this->input->post('field_matrix_column_'.$j);
					$matrix_row_arr12 =array('question_id'=>$question_id, 'answer_choice'=>$matrix_row, 'choices_scale'=>$choices_scale);
					$this->db->insert('survey_question_choices_conditions', $matrix_row_arr12);
				}
		  	}		  	
		  				
		}
				
		if(isset($question_type) && $question_type==4){
			$nps_first_field = $this->input->post('npsq_first_field');
			$nps_middle_field = $this->input->post('npsq_middle_field');
			$nps_last_field = $this->input->post('npsq_last_field');
			
			$nps_arr =array('nps_first_field'=>$nps_first_field, 'nps_middle_field'=>$nps_middle_field, 'nps_last_field'=>$nps_last_field);
			$this->db->where('question_id', $question_id);
			$this->db->update('surveys_questions',$nps_arr);
		}
	}
	
	public function set_order_questions(){	
		$list_order = $_POST['list_order']; 
		// convert the string list to an array
		$list = explode(',' , $list_order);
		$i = 1 ;
		foreach($list as $id){
			$arr =array('priority'=>$i);
			$this->db->where('question_id', $id);
			$this->db->update('surveys_questions',$arr);
			
		$i++;}
	}
	
	
	/*public function edit_team_members(){	
	 	$name = $this->input->post('name');
		$id = $this->input->post('hupdate_id');
	
		$arr = array('name'=>$name);
		$this->db->where('id', $id);
		$this->db->update('department_team_members',$arr);
		$this->session->set_flashdata('success', 'Updated Successfully!');
		redirect('department/design/action2'); 
	}
		
	public function delete_members($id){
 		$this->db->where('id',$id); 
		$query = $this->db->delete('department_team_members');
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}*/	
	
	public function add_survey_configuration(){	
		$h_survey_id = $this->input->post('h_survey_id');
		$h_dept_id = $this->input->post('h_dept_id');
		$survey_sponsor_name = ucfirst($this->input->post('survey_sponsor_name'));
		if(isset($_POST['is_introduction_msg'])&& $_POST['is_introduction_msg']=='0'){
			$is_introduction_msg = '0';
		}else{
			$is_introduction_msg = '1';
		}
		$survey_introduction = $this->input->post('survey_introduction');
		$survey_message = $this->input->post('survey_message');
		$question_per_page = $this->input->post('question_per_page');
		$survey_start_date = strtotime($this->input->post('survey_start_date'));
		$survey_end_date = strtotime($this->input->post('survey_end_date'));
		if(isset($_POST['survey_sweepstakes'])&& $_POST['survey_sweepstakes']=='0'){
			$survey_sweepstakes = '0';
		}else{
			$survey_sweepstakes = '1';
		}
		$survey_winners = $this->input->post('survey_winners');
		$survey_add_date = time();
		
		$arr = array('survey_sponsor_name'=>$survey_sponsor_name, 'is_introduction_msg'=>$is_introduction_msg, 
			'survey_introduction'=>$survey_introduction, 'survey_message'=>$survey_message,
			'survey_start_date'=>$survey_start_date, 'survey_end_date'=>$survey_end_date, 
			'survey_sweepstakes'=>$survey_sweepstakes, 'survey_winners'=>$survey_winners, 
			'survey_add_date'=>$survey_add_date, 'question_per_page'=>$question_per_page, 
			'last_modification'=>time());
		
 		$this->db->where('survey_id',$h_survey_id); 
		$query = $this->db->update('surveys', $arr);
		
		if(isset($_FILES['photo']) && $_FILES['photo']!=''){ //print_r($_FILES['photo']); die;
			/*if(isset($_FILES['photo']['size']) && $_FILES['photo']['size']>='200'){
				$this->session->set_flashdata('error', 'File size is too large(Uplode image size less than 50 kb)');
					redirect(base_url().'department/create/survey/management?survey_id='.$h_survey_id.'&dept_id='.$h_dept_id);
			}*/
			$config['upload_path'] = './assets/frontend/upload/surveys/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload');
			$files = $_FILES;
			//$count = count($_FILES['photo']['name']);
			$_FILES['photo']['name'] = $files['photo']['name'];
			$_FILES['photo']['type'] = $files['photo']['type'];
			$_FILES['photo']['tmp_name'] = $files['photo']['tmp_name'];
			$_FILES['photo']['error'] = $files['photo']['error'];
			$_FILES['photo']['size'] = $files['photo']['size'];
			$fileName = time().'_'.str_replace(' ','_',trim($_FILES['photo']['name']));
			$images[] = $fileName;
			$config['file_name'] = $fileName;
			$this->upload->initialize($config); 
			if ($this->upload->do_upload('photo')) {
				$config1 = array(
					'source_image'      => './assets/frontend/upload/surveys/'.$fileName,
					'new_image'         => './assets/frontend/upload/surveys/thumbnails/'.$fileName,
					'maintain_ratio'    => true,
					'width'             => 100,
					'height'            => 80
					);
				//here is the second thumbnail, notice the call for the initialize() function again
				$this->load->library('image_lib',$config1);
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();
				$data=''; 
					
					$imgquery = $this->db->get_where('surveys',array('survey_id'=>$h_survey_id));
					$imgrow = $imgquery->row();
					$imgname = $imgrow->survey_sponsor_logo;
					if(isset($imgname) && $imgname!=''){
						//UNLINK
						$file_upload_directory = './assets/frontend/upload/surveys/';
						$file_upload_directory1 = './assets/frontend/upload/surveys/thumbnails/';
						$unlink = unlink($file_upload_directory.$imgname);
						$unlink1 = unlink($file_upload_directory1.$imgname);
					}
				$data=array("survey_sponsor_logo"=>$fileName);
				$this->db->where('survey_id',$h_survey_id); 
				$query = $this->db->update('surveys', $data);
			} 
		}		
  		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/survey/management?survey_id='.$h_survey_id.'&dept_id='.$h_dept_id);	
	}
	 

//===== ----- survey_results ----- =====//	
	
	function surveys_questions_detail($survey_id){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('surveys_questions');
		return $query->result();
	}	

	function survey_email_detail($survey_id,$dept_id){
		$this->db->where('is_deleted', '0');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('department_id', $dept_id);
		$this->db->group_by('auth_code');
		$query = $this->db->get('survey_email');
		return $query->result();
	}
	 
}
?>