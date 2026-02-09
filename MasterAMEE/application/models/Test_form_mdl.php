<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_form_mdl extends CI_Model {
	
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
	
	function self_rating_save(){
	
		$test_code = $this->input->post('h_test_code');
		$test_id = $this->input->post('h_test_id');
		$auth_code = $this->input->post('h_auth_code');
		$current_test_type = $this->input->post('h_current_test_type');			
		
		if(isset($auth_code) && $auth_code>0){
		
			if(isset($test_code) && $test_code!='' && isset($auth_code) && $auth_code!=''){
			
				$rate_your_self = $this->input->post('txt_rate_your_self');				
				
				if($current_test_type==2){
					$arr = array('post_rate_your_self'=>$rate_your_self);
				}else{
					$arr = array('rate_your_self'=>$rate_your_self);
				}
				$this->db->where('auth_code',$auth_code);
				$this->db->where('test_id',$test_id);
				$this->db->update('tests_email',$arr);
				
			}
			
		}
		
		redirect(base_url().'test/result/'.$test_code.'/'.$auth_code);
	}
	
	
	function update_test_start_date($test_id,$auth_code,$current_test_type){
		$this->db->where('test_id', $test_id);
		$this->db->where('auth_code', $auth_code);
		if($current_test_type==2){
			$this->db->where('post_start_date!=', '0');
		}else{
			$this->db->where('start_date!=', '0');
		}	
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_email');
		$num = $query->num_rows();
		if($num==0){
			if($current_test_type==2){
				$arr = array('post_start_date'=>time());
			}else{
				$arr = array('start_date'=>time());
			}
			$this->db->where('auth_code', $auth_code);
			$this->db->where('is_deleted', '0');
			$this->db->where('test_id', $test_id);
			$this->db->update('tests_email',$arr); 
		}
 	} 
	
	function get_courses_test_answers_detail_by_course_id($test_id,$course_id,$auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('test_id', $test_id);
		$where = ' FIND_IN_SET('.$course_id.', answer)';
		$this->db->where($where); 
		$this->db->where('question_status', '3');
		$query = $this->db->get('test_answers');
		return $num = $query->num_rows();
		/*if($num>0){
			$row = $query->row();
			return $row->given_answer;
		}*/
	}	
	
	function test_courses_detail($test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('status', '0');
		$query = $this->db->get('tests_course');
		return $query->result();
 	}
	
	function test_courses_fulldetails($id){
		$this->db->where('id', $id);
		$query = $this->db->get('tests_course');
		return $query->row();
 	} 
	
	function test_detail_by_code($test_code){
		$this->db->where('test_code', $test_code);
		$query = $this->db->get('tests');
		$num = $query->num_rows();
		if($num==0){
			redirect(base_url().'test/error/testnotavailable');
		}else{
			$row = $query->row();
			$test_status = $row->status;
			if($test_status==0){
				
				$current_test_type = $row->current_test_type;
				if($current_test_type==2){
					$test_start_date = $row->post_start_date;
					$test_end_date = $row->post_end_date;
				}else{
					$test_start_date = $row->start_date;
					$test_end_date = $row->end_date;
				}
				$current_time=time();
				if($current_time>=$test_start_date && $current_time<=$test_end_date){
					return $row;
				}else{
					redirect(base_url().'test/error/test_deadline_over');
				}
				
			}else{
				redirect(base_url().'test/error/test_deactive');
			}			
			
		}
	}	
	
	function check_already_take_test($test_id,$current_test_type,$auth_code){
		$this->db->where('test_id', $test_id);
		$this->db->where('auth_code', $auth_code);
		if($current_test_type==2){
			$this->db->where('post_finish_status', '1');
		}else{
			$this->db->where('finish_status', '1');
		}
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_email');
		$num = $query->num_rows();
		if($num>0){
			redirect(base_url().'test/error/already_taken');
		}
	}
	
	function tests_questions_num_rows($test_id){
		$this->db->where('test_id', $test_id);
		$this->db->where('is_demography', '0');
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_questions');
		return $query->num_rows();
	}	
	
	function test_questions_detail($test_id, $limit, $page_number ){
		$offset = ($page_number-1)*$limit;
		$this->db->where('test_id', $test_id);
		$this->db->where('is_demography', '0');
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->order_by('priority', 'asc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('tests_questions');
		return $query->result();
	}
	
	public function get_test_answers_detail($test_id,$current_test_type, $auth_code){
		$this->db->where('test_id', $test_id);
		$this->db->where('test_type', $current_test_type);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_status', '1');
		$this->db->where('status', '0');
		$this->db->where('is_delete', '0');
		$this->db->group_by('question_id');
		$query = $this->db->get('test_answers');
		return $query->num_rows();
	}
	
	function answer_save(){
	
		$hidden_second = $this->input->post('hidden_second');
		$remeaning_second = array('session_remeaning_second'=>$hidden_second);
		$this->session->set_userdata($remeaning_second);

		$test_code = $this->input->post('h_test_code');
		$test_id = $this->input->post('h_test_id');
		$test_type = $this->input->post('h_current_test_type');
		$department_id = $this->input->post('h_department_id');
		$auth_code = $this->input->post('h_auth_code');
		$next_page_link = $this->input->post('next_page_link');
		$add_date = time();		
		
		if(isset($auth_code)&& $auth_code>0){	
			if(count($_POST['h_question_id'])>0){
				for($i=0;count($_POST['h_question_id'])>$i;$i++){
				
					$h_question_id = $_POST['h_question_id'][$i];

					$que_query = $this->db->get_where('tests_questions', array('question_id'=>$h_question_id));
					$que_result = $que_query->row();
					$correct_answer = $que_result->correct_answer;
					
					if(isset($_POST['field_name'.$h_question_id])&& $_POST['field_name'.$h_question_id]!=''){
						$answer = $_POST['field_name'.$h_question_id];
						
						if($correct_answer==$answer){
							$correct_answer_status = '1';
						}else{
							$correct_answer_status = '0';				
						}		
						
						$query = $this->db->get_where('test_answers', array('auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'test_type'=>$test_type));
						$num = $query->num_rows();
						if($num==0){
							$arr = array('test_id'=>$test_id, 'department_id'=>$department_id, 'test_type'=>$test_type, 
								'auth_code'=>$auth_code, 'question_id'=>$h_question_id, 'question_status'=>'1', 
								'answer'=>$answer, 'add_date'=>$add_date, 'correct_answer_status'=>$correct_answer_status);
							$this->db->insert('test_answers', $arr);
								
						}else{
							$arr = array('answer'=>$answer, 'correct_answer_status'=>$correct_answer_status);
							$this->db->where('test_type',$test_type);
							$this->db->where('auth_code',$auth_code);
							$this->db->where('question_id',$h_question_id);
							$this->db->update('test_answers',$arr);
						}		
					}
				}
			}
		}
		redirect($next_page_link);		
	}
	
	function update_test_finish_status($auth_code,$current_test_type){
	
		if($current_test_type==2){
			$data = array('post_finish_status'=>'1','post_finish_date'=>time());
		}else{
			$data = array('finish_status'=>'1','finish_date'=>time());
		}
		$this->db->where('auth_code', $auth_code);
		$this->db->update('tests_email', $data);
	}
	
	
	function get_test_total_score_according_to_criteria($test_id,$current_test_type,$criterion_number){
		$this->db->where('test_id', $test_id);
		if($current_test_type==2){
			$this->db->where('post_rate_your_self', $criterion_number);
		}else{
			$this->db->where('rate_your_self', $criterion_number);
		}
		//$this->db->where('finish_status', '1');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_email');
		return $num = $query->num_rows();
	}
	
	/*function get_test_total_score_according_to_criteria($test_id,$test_type,$highest,$lowest){
		$this->db->select('SUM(point_value) as point_value_n', FALSE);
		$this->db->from('test_answers');
		$this->db->join('tests_questions','tests_questions.question_id=test_answers.question_id');
		$this->db->where('test_type', $test_type);
		$this->db->where('question_status', '1');
		$this->db->where('test_answers.test_id', $test_id);
		$this->db->where('correct_answer_status', '1');
		$this->db->group_by('auth_code');
		$this->db->having('point_value_n<=',  $highest);
		$this->db->having('point_value_n>=',  $lowest);
		$query=$this->db->get();
		return $num = $query->num_rows();
	}*/ 
	
	function test_answers_result($test_id,$auth_code,$current_test_type){
		$this->db->select('SUM(point_value) as point_value_n', FALSE);
		$this->db->from('test_answers');
		$this->db->join('tests_questions','tests_questions.question_id=test_answers.question_id');
		$this->db->where('test_type', $current_test_type);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('test_answers.test_id', $test_id);
		$this->db->where('correct_answer_status', '1');
		$query=$this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$result = $query->row();
			if(isset($result->point_value_n) && $result->point_value_n!=''){
				return $result->point_value_n;
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	} 
	
	function test_auth_code_detail($auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('tests_email');
		return $query->row();
 	}
	
 	function startTestEntry(){
	
		$test_code = $this->input->post('h_test_code');
		$test_id = $this->input->post('h_test_id');
		$department_id = $this->input->post('h_department_id');
		$anonymousTest = $this->input->post('h_anonymousTest');
		$test_type = $this->input->post('h_current_test_type');
		
		if($anonymousTest==1){		
			$first_name = $this->input->post('txt_first_name');
			$last_name = $this->input->post('txt_last_name');
			$email = $this->input->post('txt_email');		
		}else{
			$first_name = '';
			$last_name = '';
			$email = $_SERVER['REMOTE_ADDR'];
		}
		$add_date = time();
		
		$this->db->where('email_to', $email);
		$queryTest = $this->db->get('tests_email');
		$numTest = $queryTest->num_rows();	
		if($numTest==0){
			if($test_type==2){
				return 'error||pre_test_first';
			}else{
				$this->db->insert('tests_email', array('test_type'=>$test_type, 'test_id'=>$test_id, 'department_id'=>$department_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email_to'=>$email,'email_subject'=>'', 'add_date'=>$add_date));
				$insert_id = $this->db->insert_id();
				$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
				$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
				$auth_code = $randomletter1.$insert_id.$randomletter2;
				$data = array('auth_code'=>$auth_code);
				$this->db->where('id', $insert_id);
				$this->db->update('tests_email', $data);
			}
		}else{
			$rowTest = $queryTest->row();
			$insert_id = $rowTest->id;
			$auth_code = $rowTest->auth_code;
		}
		
		if(isset($auth_code) && $auth_code>0){
		
 			$question_id_arr = $this->input->post('h_question_id');
			
			if(isset($question_id_arr) && $question_id_arr!='' && count($question_id_arr)>0){
			
				$h_question_type_arr = $this->input->post('h_question_type');
				
				for($i=0;$i<count($question_id_arr);$i++){
					$question_id = $question_id_arr[$i];
					$question_type = $h_question_type_arr[$i];
					$given_answer = $this->input->post('field_name'.$question_id);
					if(isset($given_answer) && $given_answer!=''){
						
						$this->db->where('test_id', $test_id);
						$this->db->where('auth_code', $auth_code);
						$this->db->where('question_id', $question_id);
						$this->db->where('question_status', '2');
						$this->db->where('status', '0');
						$this->db->where('is_delete', '0');
 						$query = $this->db->get('test_answers');
						$num_rows = $query->num_rows();
						if($num_rows==0){
						
							$question_answer_arr = array('department_id'=>$department_id,'test_id'=>$test_id, 'test_type'=>$test_type, 'auth_code'=>$auth_code, 'question_id'=>$question_id, 'question_type'=>$question_type, 'answer'=>$given_answer, 'question_status'=>'2', 'add_date'=>time());
							$this->db->insert('test_answers', $question_answer_arr);	
							
						}else{
							
							$question_answer_arr = array('answer'=>$given_answer);
							$this->db->where('test_id', $test_id);
							$this->db->where('auth_code', $auth_code);
							$this->db->where('question_id', $question_id);
							$this->db->where('question_status', '2');
							$this->db->update('test_answers',$question_answer_arr);
							
						}
					}
				}
				
			}
			
			$courses = $this->input->post('txt_courses');
 			if(isset($courses) && $courses!='' && count($courses)>0){
				  $given_answer = implode(',',$courses);
		 
					$question_type=0;
					$question_id=0;
					
					$this->db->where('test_id', $test_id);
					$this->db->where('auth_code', $auth_code);
					$this->db->where('question_status', '3');
					$this->db->where('status', '0');
					$this->db->where('is_delete', '0');
					$query = $this->db->get('test_answers');
					$num_rows = $query->num_rows();
					if($num_rows==0){
					
						$question_answer_arr = array('department_id'=>$department_id,'test_id'=>$test_id, 'test_type'=>$test_type, 'auth_code'=>$auth_code, 'question_id'=>$question_id, 'question_type'=>$question_type, 'answer'=>$given_answer, 'question_status'=>'3', 'add_date'=>time());
						
						$this->db->insert('test_answers', $question_answer_arr);	
					
					}else{
					
						$question_answer_arr = array('answer'=>$given_answer);
						$this->db->where('test_id', $test_id);
						$this->db->where('auth_code', $auth_code);
						$this->db->where('question_status', '3');
						$this->db->update('test_answers',$question_answer_arr);
					}
				 
 			}
			
		}
		
		//redirect(base_url().'test/questions/'.$test_code.'/'.$auth_code);
		return 'success||'.$auth_code;
		
	}

	
}
?>