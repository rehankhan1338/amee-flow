<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assignments_rubrics_mdl extends CI_Model {
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
	
	function get_rater_rating_count($highest,$lowest,$assignment_id,$department_id){
	
	
	}
	
	function get_raters_users_of_assignment($assignment_id,$rater_auth_code){
		
		$user_auth_code=array();
		$this->db->where('assingment_id', $assignment_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('status', '0');
 		$this->db->group_by('user_auth_code');
		$query = $this->db->get('assingment_raters_ratings');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$result = $query->result();
			foreach($result as $result_details){ 
				$user_auth_code[]=$result_details->user_auth_code;
			} 			
		}
		return $user_auth_code;
	}
	
	function get_total_rating_of_raters($category_id,$assignment_id,$rater_auth_code,$user_auth_code){
		$this->db->where('assingment_id', $assignment_id);
		$this->db->where('category_id', $category_id);
		$this->db->where('rater_auth_code', $rater_auth_code);
		$this->db->where('user_auth_code', $user_auth_code);
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_raters_ratings');
		$num_rows = $query->num_rows();
		if($num_rows>0){
			$result = $query->row();
			return $result->rating_score;
		}else{
			return $num_rows;
		}
	}
	
	function get_total_active_observation($assignment_id){
		$subdomain_name = $this->db->dbprefix;
		$this->db->where('assingment_id', $assignment_id);
		$this->db->where('department_status', '0');
		$where=' auth_code in(select user_auth_code from '.$subdomain_name.'assingment_raters_ratings where status="0")';
		$this->db->where($where);
		$query = $this->db->get('assingment_email');
		return $query->num_rows();
	}
	
	function get_self_report_poll_count($criterion_id,$assingment_id,$department_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $department_id);
		$this->db->where('finish_status', '1');
		$this->db->where('is_deleted', '0');
		$this->db->where('rate_your_self', $criterion_id);
		$query = $this->db->get('assingment_email');
		return $query->num_rows();
	}
	
	function update_assignment_status_btn($status,$id){
		$dept_id=$this->session->userdata('dept_id');
		$arr = array('status'=>$status);
		$this->db->where('id', $id);
		$this->db->update('assignments',$arr);
		redirect(base_url().'department/create/assignments_rubrics/manage?ar_id='.$id.'&dept_id='.$dept_id);		
	}
	
	public function update_display_raters_page($change_to,$id){
		$this->db->where('id', $id);
		$query = $this->db->get('assingment_email');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$arr = array('department_status'=>$change_to);
 			$this->db->where('id', $id);
 			$this->db->update('assingment_email',$arr);
		}
		return $change_to;
	}	
	
	public function get_all_assingment_authcode_textbox_answer_listing($assingment_id,$question_id,$auth_code){
		$this->db->where('assignment_id', $assingment_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assingment_question_answer');
		$num_rows = $query->num_rows();
		if($num_rows>0){		
			$row = $query->row();
			return $row->given_answer;
		}	
	}
	
	public function get_all_assingment_authcode_listing($assingment_id){
 		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('is_deleted', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('assingment_email');
		return $query->result();
 	}
	
	public function get_assigment_choics_of_multiple_type_question($question_id){
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assignment_question_choices');
		return $query->result();	
	}	
	
	public function get_choice_assingment_result_count_by_choice_id($answer_id,$question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('given_answer',$answer_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_question_answer');
		return $query->num_rows();	
	}
	
	public function get_all_choice_assignment_result_count_by_question_id($question_id){
		$this->db->where('question_id',$question_id);
		$this->db->where('is_delete', '0');
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_question_answer');
		return $query->num_rows();	
	}
	
	function save_email($assignment_code){
			 
		$assingment_id = $this->input->post('h_assingment_id');
		$h_dept_id = $this->input->post('h_dept_id');
		$menu_id = $this->input->post('h_menu');
		
		$email_to_old = $this->input->post('email_to');
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');
 		
		if($menu_id==2){
			$data = array('assignment_send_message'=>$email_message);
		}else{
			$data = array('assignment_rater_send_message'=>$email_message); 
		}		
		$this->db->where('id', $assingment_id);
		$this->db->update('assignments', $data);
				
		$add_date = time();
		$explode_to = explode(',', $email_to_old);
			
		for($i=0; $i<count($explode_to); $i++){
			if(isset($explode_to[$i]) && $explode_to[$i]!=''){
				$email_to = strtolower(trim($explode_to[$i]));
				$insert_id = 0;
				if($menu_id==3){
				
					$this->db->where('assingment_id', $assingment_id);
					$this->db->where('department_id', $h_dept_id);
					$this->db->where('email_to', $email_to);
					$this->db->where('is_deleted', '0');
					$query = $this->db->get('assingment_raters_email');
					$num_rows = $query->num_rows();
					if($num_rows==0){
						$arr = array('assingment_id'=>$assingment_id, 'department_id'=>$h_dept_id, 'email_to'=>$email_to, 'email_subject'=>$email_subject, 'add_date'=>$add_date);
						$this->db->insert('assingment_raters_email', $arr);
						$insert_id = $this->db->insert_id();
					}					
					
				}else{
				
					/*$this->db->where('assingment_id', $assingment_id);
					$this->db->where('department_id', $h_dept_id);
					$this->db->where('email_to', $email_to);
					$this->db->where('is_deleted', '0');
					$query = $this->db->get('assingment_email');
					$num_rows = $query->num_rows();
					if($num_rows==0){
						$arr = array('assingment_id'=>$assingment_id, 'department_id'=>$h_dept_id, 'email_to'=>$email_to, 'email_subject'=>$email_subject, 'add_date'=>$add_date);
						$this->db->insert('assingment_email', $arr);
						$insert_id = $this->db->insert_id();
					}*/	
				}
				
				$this->db->where('email', $email_to);
				$query_amee_id = $this->db->get('email_ameeid');
				$num_rows_amee_id = $query_amee_id->num_rows();
				
				if($num_rows_amee_id==0){			
					
					$amee_id_arr = array('email'=>$email_to, 'added_from'=>'2', 'add_date'=>$add_date);
					$this->db->insert('email_ameeid', $amee_id_arr);	
					$amee_auto_id = $this->db->insert_id();
					
					$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
					$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
					$amee_id =  $randomletter1.$amee_auto_id.'6'.$randomletter2;
					
					$arr_amee_id1 = array('amee_id'=>$amee_id);
					$this->db->where('id', $amee_auto_id);
					$this->db->update('email_ameeid', $arr_amee_id1);	
					
				}
				 
				if($num_rows==0){
					$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
					$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
					$email_code =  $randomletter1.$insert_id.$randomletter2;
				}else{
					$row = $query->row();
					$email_code = $row->auth_code;
					$insert_id = $row->id;
				}
				
				 //echo $insert_id.'---'.$email_code;die;
				 
				$dept_session_details = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
				$department_name = $dept_session_details->department_name;
					
				$message=str_replace('{auth_code}',$email_code,$email_message);
				$message= str_replace('{department_name}',$department_name,$message);
				$data = array('auth_code'=>$email_code);
				
				if($menu_id==3){
					$this->db->where('id', $insert_id);
					$this->db->update('assingment_raters_email', $data);
				}
				send_mail($email_to,$message,'','info',$email_subject);
				
				if($menu_id==2){
					$this->session->set_flashdata('success', 'Assignment link sent to '.count($explode_to).' email addresses.');	
				}else{
					$this->session->set_flashdata('success', 'Assignment Answer link sent to '.count($explode_to).' email addresses.');	
				}
			}
		}
		
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=7&ar_id='.$assingment_id.'&dept_id='.$h_dept_id.'&menu='.$menu_id);	
	}	
	
	public function assingment_fulldetails($assingment_id){
 		$this->db->where('id', $assingment_id);
		$query = $this->db->get('assignments');
		return $query->row();
	}	
	
	public function department_assignments_rubrics_listing(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('department_id', $dept_id);
		$where = ' status in (0,3)';
		$this->db->where($where); 
		$query = $this->db->get('assignments');
		return $query->result();
 	}
	
	public function assignments_rubrics_listing(){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignments');
		return $query->result();
 	} 	

 	public function assignments_rubrics_row($ar_id, $dept_id){
		$this->db->where('id', $ar_id);
		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('assignments');
		return $query->row();
 	} 

	public function set_assignment($dept_id,$ar_id){	
		$assignment_title = $this->input->post('assignment_title');
		$assignment_type = $this->input->post('assignment_type');
		$anonymousAssignment = $this->input->post('anonymousAssignment');
		 		
		if($ar_id==0){
		 	$add_date = time();
			$arr = array('department_id'=>$dept_id, 'assignment_title'=>$assignment_title, 'assignment_type'=>$assignment_type, 'anonymousAssignment'=>$anonymousAssignment, 'add_date'=>$add_date);
			$this->db->insert('assignments',$arr);
			$ar_id = $this->db->insert_id();
			$randomletter1 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$randomletter2 = substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$assignment_code = $randomletter1.$ar_id.$randomletter2;
			
			$arr_1 = array('assignment_code'=>$assignment_code);
			$this->db->where('id', $ar_id);
			$this->db->update('assignments', $arr_1);
			$this->session->set_flashdata('success', 'Save and update successfully!');
			redirect(base_url().'department/create/assignments_rubrics');
		}else{
			$assignment_status = $this->input->post('assignment_status');
			$arr = array('assignment_title'=>$assignment_title, 'assignment_type'=>$assignment_type, 'anonymousAssignment'=>$anonymousAssignment, 'status'=>$assignment_status);
 			$this->db->where('id', $ar_id);
 			$this->db->where('department_id', $dept_id);
 			$this->db->update('assignments',$arr);
			$this->session->set_flashdata('success', 'Save and update successfully!');	
			redirect(base_url().'department/create/assignments_rubrics/manage?ar_id='.$ar_id.'&dept_id='.$dept_id);		
		}
	} 
	
	public function delete_prepare_document(){
		$id = $_GET['id'];
		$upload_type = $_GET['upload_type'];
		$this->db->where('id',$id); 
		$this->db->delete('assignments_upload_instruction');
		$this->session->set_flashdata('success', 'Document has been deleted successfully!');	
	}

	public function archive_delete_analysis_review(){
		$arr_id = $_GET['arr'];
		$status = $_GET['status'];
		
		$explode_arr = explode(',', $arr_id);
		for($i=0; $i<count($explode_arr); $i++){
			$delete_id = $explode_arr[$i];
			
			if($status==2){
				$dept_id=$this->session->userdata('dept_id');
				
				$this->db->where('id',$delete_id); 
				$this->db->where('department_id',$dept_id);
				$query = $this->db->delete('assignments');	
				
				$tables = array('assignments_rubrics_builder', 'assignments_rubrics_builder_heading', 'assignments_upload_instruction');
				$this->db->where('assignment_id', $delete_id);
				$this->db->where('department_id', $dept_id);
				$this->db->delete($tables);
				
				$tables_another = array('assignment_courses', 'assignment_questions', 'assignment_question_choices');
				$this->db->where('ar_id', $delete_id);
				$this->db->where('department_id', $dept_id);
				$this->db->delete($tables_another);
				
				$this->db->where('assingment_id',$delete_id);
				$query = $this->db->delete('assingment_raters_feedback');
				
				$this->db->where('assingment_id',$delete_id);
				$query = $this->db->delete('assingment_raters_ratings');
				
				$tables_another1 = array('assingment_email', 'assingment_raters_email');				
				$this->db->where('assingment_id',$delete_id);
				$this->db->where('department_id',$dept_id); 
				$query = $this->db->delete($tables_another1);					
				
				$this->db->where('assignment_id',$delete_id); 
				$query = $this->db->delete('assignments_user_upload_instruction');
				
				$this->db->where('assignment_id',$delete_id); 
				$query = $this->db->delete('assingment_question_answer');
 
			}else{
			
 				$arr = array('status'=>$status);
				$this->db->where('id', $delete_id);
				$this->db->update('assignments',$arr);
				
			}
		}

		if($status==1){
			$this->session->set_flashdata('success', 'Archive successfully!');
		}else{
			$this->session->set_flashdata('success', 'Deleted successfully!');
		}
  	}
	
	public function delete_course($id, $assingment_id){
		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('id',$id); 
		$query = $this->db->delete('assignment_courses');
		
		$this->db->where('assignment_id', $assingment_id);
		$this->db->where('question_status', '2');
		$this->db->where(' FIND_IN_SET('.$id.', given_answer)');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('assingment_question_answer');
		$num_rows = $query->num_rows();
 		if($num_rows>0){
			$result = $query->result();
			foreach($result as $result_details){
				$main_id=$result_details->id;
				$courses_arr = explode(',',$result_details->given_answer);
 				if (($key = array_search($id, $courses_arr)) !== false) {
					unset($courses_arr[$key]);
				}
				if(count($courses_arr)>0){
					$course_update = implode(',',$courses_arr);
					$course_update_arr = array('given_answer'=>$course_update);
					$this->db->where('id',$main_id); 
					$query = $this->db->update('assingment_question_answer', $course_update_arr);					
				}else{
					$this->db->where('id',$main_id); 
					$query = $this->db->delete('assingment_question_answer');
				}								 
			}
		}	 

  		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=3&ar_id='.$assingment_id.'&dept_id='.$dept_id);	
	}

  	function assignments_rubrics_course_detail($ar_id){
		$dept_id = $this->session->userdata('dept_id');
 		$this->db->where('ar_id', $ar_id);
 		$this->db->where('department_id', $dept_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignment_courses');
		return $query->result();
	}

	public function add_course(){
		$dept_id = $this->session->userdata('dept_id');
		$ar_id = $this->input->post('ar_id');
		$course_enrolled = $this->input->post('course_enrolled_1');
		$course_i = $this->input->post('course_i_1');
		$course_type = $this->input->post('course_type_1');
		$pslo_number = $this->input->post('pslo_number_1');
		$add_more_count = $this->input->post('add_more_count');
		$add_date = strtotime(date('Y-m-d'));
		$year = date('Y');
		$edit_core_function_count = $this->input->post('edit_course_count');
		if(isset($edit_core_function_count) && $edit_core_function_count!=''){
			if(count($edit_core_function_count)>0){
				for($i=0;$i<count($edit_core_function_count);$i++){
					$edit_core_func_id = $edit_core_function_count[$i];
					$course_enrolled_edit = $this->input->post('course_enrolled_edit_'.$edit_core_func_id);
					$course_i_edit = $this->input->post('course_i_edit_'.$edit_core_func_id);
					$course_type_edit = $this->input->post('course_type_edit_'.$edit_core_func_id);
					$pslo_number_edit = $this->input->post('pslo_number_edit_'.$edit_core_func_id);
	
					$arr_upate = array('course_enrolled'=>$course_enrolled_edit, 'course_i'=>$course_i_edit,'course_type'=>$course_type_edit, 'pslo_number'=>$pslo_number_edit);
					$this->db->where('id', $edit_core_func_id);
					$this->db->update('assignment_courses',$arr_upate);
				}
			}
		}

		if(isset($course_enrolled) && $course_enrolled!='' && isset($course_i) && $course_i!='' && isset($course_type) && $course_type!='' && isset($pslo_number) && $pslo_number!=''){
			$tests_course_arr = array('department_id'=>$dept_id, 'ar_id'=>$ar_id,'course_enrolled'=>$course_enrolled, 'course_i'=>$course_i, 'course_type'=>$course_type, 'pslo_number'=>$pslo_number, 'add_date'=>$add_date, 'year'=>$year);
			$this->db->insert('assignment_courses', $tests_course_arr);
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
						$tests_course_arr = array('department_id'=>$dept_id, 'ar_id'=>$ar_id, 'course_enrolled'=>$course_enrolled_add, 'course_i'=>$course_i_add,'course_type'=>$course_type_add, 'pslo_number'=>$pslo_number_add, 'add_date'=>$add_date, 'year'=>$year);
						$this->db->insert('assignment_courses', $tests_course_arr);
					}
				}
			}	
		}	
  		$this->session->set_flashdata('success', 'Save successfully!');
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=3&ar_id='.$ar_id.'&dept_id='.$dept_id);
	}

 	
 	public function add_deadline(){	
		$ar_id = $this->input->post('hidden_ar_id');
		$dept_id = $this->input->post('hidden_dept_id');
		$start_date = strtotime($this->input->post('start_date')); 
		$end_date = strtotime($this->input->post('end_date'));		

		$open_rating = strtotime($this->input->post('open_rating'));
		$close_rating = strtotime($this->input->post('close_rating'));
		$time_rubric = $this->input->post('time_rubric');
		if(isset($_POST['minutes_enable'])&& $_POST['minutes_enable']=='0'){
			$minutes_enable = '0';
		}else{
			$minutes_enable = '1';
		}			

		$arr = array('start_date'=>$start_date, 'end_date'=>$end_date,'open_rating'=>$open_rating,
			'close_rating'=>$close_rating,'minutes_enable'=>$minutes_enable,'time_rubric'=>$time_rubric);
 		$this->db->where('id',$ar_id); 
		$query = $this->db->update('assignments', $arr);
  		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/assignments_rubrics/manage?tab=5&ar_id='.$ar_id.'&dept_id='.$dept_id);
	}  

	public function manage_rubric_builder(){
		$assignment_id = $this->input->post('h_ar_id');
		$dept_id = $this->session->userdata('dept_id');
		$h_Categories_count = $this->input->post('h_Categories_count');
		$h_scale_point_count = $this->input->post('h_scale_point_count');
		$add_date = time();	

		for($j=1;$j<=$h_Categories_count;$j++){
			$category_name = $this->input->post('category_row_'.$j);
			$score_field = $this->input->post('score_field_matrix_row_'.$j);
			$rubric_arr = array('assignment_id'=>$assignment_id, 'department_id'=>$dept_id, 
				'category_name'=>$category_name, 'score_field'=>$score_field, 'add_date'=>$add_date);
			$this->db->insert('assignments_rubrics_builder',$rubric_arr);
			$insert_rubric_id = $this->db->insert_id();			

			for($i=1;$i<=$h_scale_point_count;$i++){
				if($j==1){
					$range_name_column = $this->input->post('range_name_column_'.$i);
					$oprf_column = $this->input->post('oprf_column_'.$i);
					$oprf_column_sec = $this->input->post('oprf_column_sec_'.$i);
					$heading_arr = array('assignment_id'=>$assignment_id, 'department_id'=>$dept_id, 'column_no'=>$i, 'range_name_column'=>$range_name_column, 'oprf_column'=>$oprf_column, 'oprf_column_sec'=>$oprf_column_sec);
					$this->db->insert('assignments_rubrics_builder_heading',$heading_arr);
					$inserted_heading_id = $this->db->insert_id();
				}		

				$option = $this->input->post('option_row_'.$j.'_column_'.$i);	
				$arr = array('column_no'=>$i, 'rubric_id'=>$insert_rubric_id, 'option_name'=>$option);
				$this->db->insert('assignments_rubrics_builder_option',$arr);
			}
		}  		
		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/assignments_rubrics/manage?tab=6&ar_id='.$assignment_id.'&dept_id='.$dept_id);
	}
	
	public function get_self_rating_fulldetails($id){
		$this->db->where('id', $id);
		$query = $this->db->get('assignments_rubrics_builder_heading');
		return $query->row();
	}

	public function manage_rubric_criterion(){
		$assignment_id = $this->input->post('hidden_ar_id');
		$dept_id = $this->session->userdata('dept_id');
		$h_scale_point_count = $this->input->post('h_scale_point_count');
		$heading_id_arr = $this->input->post('h_heading_id');
		$add_date = time();
  	 	$h_heading_available_arr = $this->input->post('h_heading_available');
    		 
		for($i=1;$i<=$h_scale_point_count;$i++){
			$range_name_column = $this->input->post('range_name_column_'.$i);
			$oprf_column = $this->input->post('oprf_column_'.$i);
			$oprf_column_sec = $this->input->post('oprf_column_sec_'.$i);			

			if(isset($h_heading_available_arr[$i-1]) && $h_heading_available_arr[$i-1]!=''){
				$heading_id = $h_heading_available_arr[$i-1];
				$heading_arr = array('range_name_column'=>$range_name_column, 'oprf_column'=>$oprf_column, 
					'oprf_column_sec'=>$oprf_column_sec);
				$this->db->where('id',$heading_id); 
				$query = $this->db->update('assignments_rubrics_criterion', $heading_arr);	
			}else{
				$heading_arr = array('assignment_id'=>$assignment_id, 'department_id'=>$dept_id, 
					'column_no'=>$i, 'range_name_column'=>$range_name_column, 'oprf_column'=>$oprf_column, 
					'oprf_column_sec'=>$oprf_column_sec);
				$this->db->insert('assignments_rubrics_criterion',$heading_arr);	
			}	
		}		

		if(isset($heading_id_arr) && $heading_id_arr!='' && count($heading_id_arr)>0){
			if(count($h_heading_available_arr)==0){
				$h_heading_available_arr = array();
			}
			$delete_arr_result=array_diff($heading_id_arr,$h_heading_available_arr);

			if(count($delete_arr_result)>0){

				$delete_ruric_crea = implode(',',$delete_arr_result);
				$where = ' id in ('.$delete_ruric_crea.')';
				$this->db->where($where); 
				$this->db->delete('assignments_rubrics_criterion');	
			}
		}
		$this->session->set_flashdata('success', 'Save successfully!');
  		redirect(base_url().'department/create/assignments_rubrics/manage?tab=7&ar_id='.$assignment_id.'&dept_id='.$dept_id);

	}

	public function update_rubric_status($status, $assignment_id){

		$dept_id = $this->session->userdata('dept_id');	

		$arr = array('rubric_status'=>$status);

 		$this->db->where('id',$assignment_id); 

		$query = $this->db->update('assignments', $arr);

		$this->session->set_flashdata('success', 'Update successfully!');

  		redirect(base_url().'department/create/assignments_rubrics/manage?tab=6&ar_id='.$assignment_id.'&dept_id='.$dept_id);

	}



	public function update_rubric_builder(){

		$assignment_id = $this->input->post('h_ar_id');

		$dept_id = $this->session->userdata('dept_id');

		$category_row_arr = $this->input->post('h_category_row');		

		$heading_id_arr = $this->input->post('h_heading_id');

		$h_Categories_count = $this->input->post('h_Categories_count');

		$h_scale_point_count = $this->input->post('h_scale_point_count');

		$add_date = time();



		for($j=1;$j<=$h_Categories_count;$j++){

			$rubric_id = $category_row_arr[$j-1];

			$category_name = $this->input->post('category_row_'.$j);

			$score_field = $this->input->post('score_field_matrix_row_'.$j);		



			if($rubric_id==0){

				$rubric_arr = array('assignment_id'=>$assignment_id, 'department_id'=>$dept_id, 

					'category_name'=>$category_name, 'score_field'=>$score_field, 'add_date'=>$add_date);

				$this->db->insert('assignments_rubrics_builder',$rubric_arr);

				$insert_rubric_id = $this->db->insert_id();

			}else{

				$insert_rubric_id = $rubric_id;

				$rubric_arr = array('category_name'=>$category_name, 'score_field'=>$score_field);

				$this->db->where('rubric_id',$rubric_id); 

				$this->db->update('assignments_rubrics_builder', $rubric_arr);

			}			



			for($i=1;$i<=$h_scale_point_count;$i++){

				if($j==1){

					$heading_id = $heading_id_arr[$i-1];

					$range_name_column = $this->input->post('range_name_column_'.$i);

					$oprf_column = $this->input->post('oprf_column_'.$i);	
					
					$oprf_column_sec = $this->input->post('oprf_column_sec_'.$i);			



					if($heading_id==0){

						$heading_arr = array('assignment_id'=>$assignment_id, 'department_id'=>$dept_id, 

							'column_no'=>$i, 'range_name_column'=>$range_name_column, 'oprf_column'=>$oprf_column, 'oprf_column_sec'=>$oprf_column_sec);

						$this->db->insert('assignments_rubrics_builder_heading',$heading_arr);

						$inserted_heading_id = $this->db->insert_id();

					

					}else{

						$inserted_heading_id = $heading_id;

						$heading_arr = array('range_name_column'=>$range_name_column, 'oprf_column'=>$oprf_column, 'oprf_column_sec'=>$oprf_column_sec);

						$this->db->where('id',$heading_id); 

						$this->db->update('assignments_rubrics_builder_heading', $heading_arr);

					}

				}					



				$option = $this->input->post('option_row_'.$j.'_column_'.$i);



				$this->db->where('rubric_id', $insert_rubric_id);

				$this->db->where('column_no', $i);

				$query_1 = $this->db->get('assignments_rubrics_builder_option');

				$num_rows_1 = $query_1->num_rows();

				

				if($num_rows_1==0){		

					$arr = array('column_no'=>$i, 'rubric_id'=>$insert_rubric_id, 'option_name'=>$option);

					$this->db->insert('assignments_rubrics_builder_option',$arr);



				}else{

					$arr = array('option_name'=>$option);

					$this->db->where('rubric_id', $insert_rubric_id);

					$this->db->where('column_no', $i); 

					$this->db->update('assignments_rubrics_builder_option', $arr);

				}	

			}		

		}  		

		$this->session->set_flashdata('success', 'Save and updated successfully!');

  		redirect(base_url().'department/create/assignments_rubrics/manage?tab=6&ar_id='.$assignment_id.'&dept_id='.$dept_id);

	}


//===----- Demograpic Questions -----===//
	function assignments_rubrics_questions_detail($ar_id){
		$dept_id = $this->session->userdata('dept_id');
		$this->db->where('department_id', $dept_id);
		$this->db->where('ar_id', $ar_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('assignment_questions');
 		return $query->result();	
	}

	function get_master_question_type_rubric_h(){
		$this->db->where('status', '0');
		$this->db->where('choice_rubric', '1');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('survey_master_question_types');
		return $query->result();
	}	 

	function question_save($ar_id,$dept_id){
		$question_title = $this->input->post('rubric_question_title');
		$question_type = $this->input->post('hidden_question_type');
		$point_value = $this->input->post('point_value');
		$creation_date = strtotime(date('Y-m-d'));
		
		$rubrics_questions_arr = array('department_id'=>$dept_id, 'ar_id'=>$ar_id, 
			'question_title'=>$question_title, 'question_type'=>$question_type, 
			'creation_date'=>$creation_date, 'point_value'=>$point_value);
		$this->db->insert('assignment_questions', $rubrics_questions_arr);
		$question_id=$this->db->insert_id();	 

		//if(isset($question_type) && ($question_type==1)){
			$is_required = $this->input->post('validation_status');
			$required_message = $this->input->post('validation_error_message');
			$validation_arr = array('is_required'=>$is_required, 'required_message'=>$required_message);
			$this->db->where('question_id', $question_id);
			$this->db->update('assignment_questions',$validation_arr);
	//	}

		if(isset($question_type) && $question_type==1){
			$hidden_choice_count = $this->input->post('hidden_choice_count');
			$answer_radio = $this->input->post('answer_radio');
			for($i=1;$i<=$hidden_choice_count;$i++){
				$choices = $this->input->post('choice_'.$i);
				$rubrics_question_answers_arr = array('department_id'=>$dept_id, 'ar_id'=>$ar_id, 
					'question_id'=>$question_id, 'answer_choice'=>$choices);
				$this->db->insert('assignment_question_choices', $rubrics_question_answers_arr);
				$answer_id=$this->db->insert_id();			

				if($answer_radio==$i){
					$ans_arr = array('correct_answer'=>$answer_id);
					$this->db->where('question_id', $question_id);
					$this->db->update('assignment_questions',$ans_arr);
				}
		  	}
		}		
		$this->session->set_flashdata('success', 'Question added successfully!');
	}
	
	
	public function set_order_questions(){	
		$list_order = $_POST['list_order']; 
		// convert the string list to an array
		$list = explode(',' , $list_order);
		$i = 1 ;
		foreach($list as $id){
			$arr =array('priority'=>$i);
			$this->db->where('question_id', $id);
			$this->db->update('assignment_questions',$arr);
			
		$i++;}
	}
	
	function get_assignments_rubrics_question_details($ar_id,$question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('ar_id', $ar_id);
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assignment_questions');
		return $query->row();
	} 
	
	function get_assignments_rubrics_questions_fulldetails($question_id){
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->where('question_id', $question_id);
		$query = $this->db->get('assignment_questions');
		return $query->row();
	}
	
	function update_question_entry(){
		$dept_id=$this->session->userdata('dept_id');
		$question_id = $this->input->post('h_question_id');
		$question_type = $this->input->post('h_question_type');
		$assignment_id = $this->input->post('h_ar_id');	
		$question_title = $this->input->post('assignment_question_title');				
		$is_required = $this->input->post('validation_status');				
		$required_message = $this->input->post('validation_error_message');				
			
		$questions_arr = array('question_title'=>$question_title,'is_required'=>$is_required,'required_message'=>$required_message);
		$this->db->where('question_id', $question_id);
		$this->db->update('assignment_questions',$questions_arr);	
				
		if($question_type==1){			
			$answer_choice_arr = $this->input->post('answer_choice_id');
			//$count =  count($answer_choice_arr);
			if(isset($answer_choice_arr) && $answer_choice_arr!=''){
				for($i=0;$i<count($answer_choice_arr);$i++){
					$answer_id = $answer_choice_arr[$i];
					$answer_choice = $this->input->post('choice_'.$answer_id);
					$arr = array('answer_choice'=>$answer_choice);
					$this->db->where('answer_id', $answer_id);
					$this->db->update('assignment_question_choices',$arr);
				}
			}
			
			$newchoice_arr = $this->input->post('newchoice');
			if(isset($newchoice_arr) && $newchoice_arr!=''){
				for($j=0;$j<count($newchoice_arr);$j++){
					$newchoice = $newchoice_arr[$j];
					if(isset($newchoice) && $newchoice!=''){				
						$surveys_questions_answer_arr = array('department_id'=>$dept_id, 'ar_id'=>$assignment_id, 
						'question_id'=>$question_id, 'answer_choice'=>$newchoice);
						$this->db->insert('assignment_question_choices', $surveys_questions_answer_arr);			
					}
				}
			}			 
		}
		$this->session->set_flashdata('success', 'Question updated successfully!');
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=2&ar_id='.$assignment_id.'&dept_id='.$dept_id);
	}	
	
	function delete_question_choice($answer_id,$question_id,$question_type){
		if($question_type==1){
		
			$this->db->where('answer_id', $answer_id);
			$query = $this->db->delete('assignment_question_choices');
			
			$this->db->where('given_answer', $answer_id);
			$this->db->where('question_type', $question_type);
			$this->db->where('question_id', $question_id);
			$query = $this->db->delete('assingment_question_answer');
			
		}			
  		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/assignments_rubrics/question/edit/'.$question_id);
	}
	
	function delete_assignments_rubrics_question($question_id,$ar_id){	
 		$dept_id=$this->session->userdata('dept_id');	
 		$this->db->delete('assignment_questions', array('question_id'=>$question_id,'ar_id'=>$ar_id));
 		$this->db->delete('assignment_question_choices', array('question_id'=>$question_id,'ar_id'=>$ar_id));
		$this->db->delete('assingment_question_answer', array('question_id'=>$question_id,'assignment_id'=>$ar_id));
 		
		/*$arr = array('is_deleted'=>'1','priority'=>'0');
		$this->db->where('question_id', $question_id);
		$this->db->update('assignment_questions',$arr);
		
		$arr = array('is_delete'=>'1');
		$this->db->where('question_id', $question_id);
		$this->db->where('assignment_id', $ar_id);
		$this->db->update('assingment_question_answer',$arr);*/		
			
		$this->db->where('ar_id', $ar_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('status', '0');
		$this->db->order_by('priority', 'asc');
		$query_get_priority = $this->db->get('assignment_questions');
		$priority_count = $query_get_priority->num_rows();
		if($priority_count>0){			 
			$get_priority = $query_get_priority->result();
			$i=1;foreach($get_priority as $get_priority_details){
			
				$p_question_id = $get_priority_details->question_id;
				$priority_set = $i;
				$arr_p = array('priority'=>$i);
				//print_r($arr_p);
				$this->db->where('question_id', $p_question_id);
				$this->db->update('assignment_questions',$arr_p);			
			$i++;}
		}		
		$this->session->set_flashdata('success', 'Deleted successfully!');
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=2&ar_id='.$ar_id.'&dept_id='.$dept_id);
	}
	
	function get_assingment_documents($assignment_id,$upload_type){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('upload_type', $upload_type);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('assignments_upload_instruction');
		return $query->result();
 	}	

	function save_instructions($dept_id,$ar_id){
		$instructions = $this->input->post('txt_instructions');
		$arr = array('instructions'=>$instructions);
		$this->db->where('id', $ar_id);
		$this->db->where('department_id', $dept_id); 
		$this->db->update('assignments', $arr);
		$this->session->set_flashdata('success', 'Save and updated successfully!');
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=4&ar_id='.$ar_id.'&dept_id='.$dept_id);
	}

	function document_save($dept_id){
 		$assignment_id = $this->input->post('h_assignment_id');
		$document_title = $this->input->post('document_title');
 		$upload_type = $this->input->post('upload_instruction_type');	

		if($upload_type=='youtube_video_link'){
			$txt_youtube_link = $this->input->post('txt_youtube_link');
			$document_save_arr = array('department_id'=>$dept_id, 'assignment_id'=>$assignment_id, 'document_title'=>$document_title, 'upload_type'=>$upload_type, 'file_name'=>$txt_youtube_link, 'file_type'=>$upload_type, 'add_date'=>time());
			$this->db->insert('assignments_upload_instruction', $document_save_arr);				

		}else{
 			if(isset($_FILES['upload_inst']['name']) && $_FILES['upload_inst']['name']!='' ){
 				$file_ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['upload_inst']['name']);
				$file_name=time().'.'.$file_ext;
				/*$file_size =$_FILES['upload_inst']['size'];
				$file_tmp =$_FILES['upload_inst']['tmp_name'];
				$file_type=$_FILES['upload_inst']['type'];*/ 					

				$expensions= array("docx","pdf","xlsx","doc","docx","pptx","ppt","csv","txt","jpg","png","gif","jpeg","mp3","mp4","avi");	
				if(in_array($file_ext, $expensions)){
					$config['file_name'] =$file_name;
					$config['upload_path'] = './assets/upload/assignment/';
					$config['allowed_types'] = '*';
					$this->load->library('upload');
					$this->upload->initialize($config);
					$this->upload->do_upload('upload_inst');				

					if($file_ext=='jpg' || $file_ext=='png' || $file_ext=='jpeg'){
						$config1 = array(
						'source_image'      => './assets/upload/assignment/'.$file_name,
						'new_image'         => './assets/upload/assignment/thumbnails/'.$file_name,
						'maintain_ratio'    => true,
						'width'             => 350,
						'height'            => 240
						);
						//here is the second thumbnail, notice the call for the initialize() function again
						$this->load->library('image_lib',$config1);
						$this->image_lib->initialize($config1);
						$this->image_lib->resize();
					}					 

					$document_save_arr = array('department_id'=>$dept_id, 'assignment_id'=>$assignment_id, 'document_title'=>$document_title, 'upload_type'=>$upload_type, 'file_name'=>$file_name, 'file_type'=>$file_ext, 'add_date'=>time());
					$this->db->insert('assignments_upload_instruction', $document_save_arr);

 				}else{
					 $this->session->set_flashdata('error', 'Sorry, Try again image format are not true!');					}
 			}
		}
		redirect(base_url().'department/create/assignments_rubrics/manage?tab=4&ar_id='.$assignment_id.'&dept_id='.$dept_id);
	}



//===== ----- Assignments_rubrics_results ----- =====//	
	
	function get_assignemnt_student_raters_rating_by_rubric_creiterion($assignment_id,$bigger,$smaller){
		$subdomain_name = $this->db->dbprefix;
 		$this->db->where('assingment_id', $assignment_id);
		$this->db->where('ratus_over_rating >=', $smaller);
		$this->db->where('ratus_over_rating <=', $bigger);
		$this->db->where('is_deleted', '0');
		$this->db->where('finish_status', '1');
		$this->db->where('department_status', '0');
		$where=' auth_code in(select user_auth_code from '.$subdomain_name.'assingment_raters_ratings where status="0")';
		$this->db->where($where);
 		$query = $this->db->get('assingment_email');
		return $query->num_rows();
	}
	
	function get_assignments_complete_incomplete_user_result($assingment_id,$dept_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('start_date !=', '0');		
 		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_email');
		return $query->result();
	}
	
	function get_assignments_user_result($assingment_id,$dept_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $dept_id);
 		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_email');
		return $query->result();
	}
	
	function get_assignments_valid_user_result($assingment_id,$dept_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('finish_status', '1');
 		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_email');
		return $query->result();
	}
	
	function get_assignments_invalid_user_result($assingment_id,$dept_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('department_id', $dept_id);
		$this->db->where('is_deleted', '0');
		$this->db->where('start_date !=', '0');	
		$this->db->where('finish_status', '0');
 		$this->db->order_by('id', 'asc');
		$this->db->group_by('auth_code');
		$query = $this->db->get('assingment_email');
		return $query->result();
	}

}



?>