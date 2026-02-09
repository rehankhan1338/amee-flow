<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assignment_mdl extends CI_Model {
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
	
	function startAssignmentEntry($chkAuthCode){
		$assignment_code = $this->input->post('h_assignment_code');
		$assingment_id = $this->input->post('h_assignment_id');
		$department_id = $this->input->post('h_department_id');
		$anonymousAssignment = $this->input->post('h_anonymousAssignment');
				
		if($anonymousAssignment==1){		
			$first_name = $this->input->post('txt_first_name');
			$last_name = $this->input->post('txt_last_name');
			$email = $this->input->post('txt_email');		
		}else{
			$first_name = '';
			$last_name = '';
			$email = $_SERVER['REMOTE_ADDR'];		
		}
		$add_date = time();
		$auth_code = 0;
 		
		if(isset($chkAuthCode) && $chkAuthCode!=''){			
			$auth_code = $chkAuthCode;
			$this->db->where('auth_code', $chkAuthCode);
			$query = $this->db->get('assingment_email');
			$num = $query->num_rows();			
		}else{			
			$num = 0;		 			
		} 
		  
		 if($num==0){		
			$this->db->insert('assingment_email', array('assingment_id'=>$assingment_id, 'department_id'=>$department_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email_to'=>$email,'email_subject'=>'', 'add_date'=>$add_date));
			$insert_id = $this->db->insert_id();
			$randomletter1 = substr(str_shuffle("1234567890"), 0, 2);
			$randomletter2 = substr(str_shuffle("1234567890"), 0, 2);
			$auth_code =  $randomletter1.$insert_id.$randomletter2;
			$data = array('auth_code'=>$auth_code);
			$this->db->where('id', $insert_id);
			$this->db->update('assingment_email', $data);
		} 	
		return 'success||'.$auth_code;
		
	}
	
	function document_save(){
 		$assignment_id = $this->input->post('h_assignment_id');
		$assignment_code = $this->input->post('h_assignment_code');
		$auth_code = $this->input->post('h_auth_code');		
		
		if(isset($auth_code) && $auth_code>0){
		
			$document_title = $this->input->post('document_title');
			$upload_type = $this->input->post('upload_instruction_type');	
	
			if($upload_type=='youtube_video_link' || $upload_type=='textbox'){
			
				$txt_youtube_link = $this->input->post('txt_youtube_link');
				$document_save_arr = array('auth_code'=>$auth_code, 'assignment_id'=>$assignment_id, 'document_title'=>$document_title, 'upload_type'=>$upload_type, 'file_name'=>$txt_youtube_link, 'file_type'=>$upload_type, 'add_date'=>time());
				$this->db->insert('assignments_user_upload_instruction', $document_save_arr);				
	
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
	
						$document_save_arr = array('auth_code'=>$auth_code, 'assignment_id'=>$assignment_id, 'document_title'=>$document_title, 'upload_type'=>$upload_type, 'file_name'=>$file_name, 'file_type'=>$file_ext, 'add_date'=>time());
						$this->db->insert('assignments_user_upload_instruction', $document_save_arr);
	
					}else{
						 $this->session->set_flashdata('error', 'Sorry, Try again image format are not true!');					}
				}
			}
		
		}
		redirect(base_url().'assignment/questions/'.$assignment_code.'/'.$auth_code);
	}	
	
	function get_raters_fulldetails_by_rater_id($rater_id){
		$this->db->where('id', $rater_id);
		$query = $this->db->get('assingment_raters_email');
		return $query->row();
 	}
	
	function get_courses_assingment_answers_detail_by_course_id($assignment_id,$course_id,$auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('assignment_id', $assignment_id);
		$where = ' FIND_IN_SET('.$course_id.', given_answer)';
		$this->db->where($where); 
		$this->db->where('question_status', '2');
		$query = $this->db->get('assingment_question_answer');
		return $num = $query->num_rows();
		/*if($num>0){
			$row = $query->row();
			return $row->given_answer;
		}*/
	}
	 	
 	function assingment_auth_code_detail($auth_code){
		$this->db->where('auth_code', $auth_code);
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('assingment_email');
		return $query->row();
 	}
	
 	function assingment_detail_by_code($assignment_code){
		$this->db->where('assignment_code', $assignment_code);
		$query = $this->db->get('assignments');
		$num = $query->num_rows();
		if($num==0){
			redirect(base_url().'assingment/error/notavailable');
		}else{
			$row = $query->row();
			$assingment_status = $row->status;
			if($assingment_status==0){
			
				$assingment_start_date = $row->start_date;
				$assingment_end_date = $row->end_date;
				$current_time=time();
				if($current_time>=$assingment_start_date && $current_time<=$assingment_end_date){
					return $row;
				}else{
					redirect(base_url().'assingment/error/deadline_over');
				}	
			
			}else{
				redirect(base_url().'assingment/error/deactive');
			}		
			
		}
	}
	 
	function update_assingment_start_date($assingment_id,$auth_code){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('start_date!=', '0');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('assingment_email');
		$num = $query->num_rows();
		if($num==0){
			$arr = array('start_date'=>time());
			$this->db->where('auth_code', $auth_code);
			$this->db->where('is_deleted', '0');
			$this->db->where('assingment_id', $assingment_id);
			$this->db->update('assingment_email',$arr); 
		}
 	} 
	
	function get_all_courses_assignment_result_count_by_couses_id($assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('question_status', '2');
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_question_answer');
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
	
	function get_courses_assingment_result_count_by_couses_id($course_id,$assignment_id){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('given_answer', $course_id);
		//$this->db->where(' FIND_IN_SET('.$course_id.', given_answer)');
		$this->db->where('question_status', '2');
		$this->db->where('status', '0');
		$query = $this->db->get('assingment_question_answer');
		return $query->num_rows();
	}
	
	function check_already_take_assingment($assingment_id,$auth_code){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('auth_code', $auth_code);
		$this->db->where('finish_status', '1');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('assingment_email');
		$num = $query->num_rows();
		if($num>0){
			redirect(base_url().'assingment/error/already_taken');
		}
	}  
	
	function assingment_questions_detail($assingment_id){
		$this->db->where('ar_id', $assingment_id);
		$this->db->where('status', '0');
		$this->db->where('is_deleted', '0');
		$this->db->order_by('priority', 'asc');
		$query = $this->db->get('assignment_questions');
		return $query->result();
	}
	
	function get_rater_reliability_listing($assingment_id){
		$this->db->where('assingment_id', $assingment_id);
		$this->db->where('rater_name!=', '');
		$this->db->where('is_deleted', '0');
		$query = $this->db->get('assingment_raters_email');
		$num_row = $query->num_rows();
		if($num_row>0){
			$result = $query->result();
			$i=1;foreach($result as $details){
				if(isset($details->id) && $details->id!='' && $details->id!=0){
 					$ids[] = $details->id.'|'.$i;
				$i++;}
			}
			return $ids;
		}
 	}
	
	function get_courses_assginment_listing_result($assingment_id){
		$this->db->where('ar_id', $assingment_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignment_courses');
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
	
	function assingment_courses_detail($assingment_id){
		$this->db->where('ar_id', $assingment_id);
		$this->db->where('status', '0');
		$query = $this->db->get('assignment_courses');
		return $query->result();
 	}
	
	function assgingment_courses_fulldetails($id){
		$this->db->where('id', $id);
		$query = $this->db->get('assignment_courses');
		return $query->row();
 	}
	
	function assingment_rubric_builder_category_list($assingment_id){
		$this->db->where('assignment_id', $assingment_id);
		$this->db->where('status', '0');
		$this->db->order_by('rubric_id', 'asc');
		$query = $this->db->get('assignments_rubrics_builder');
		return $query->result();
	}
	
	function assingment_rubric_criterion_detail($assingment_id){
		$this->db->where('assignment_id', $assingment_id);
		$this->db->order_by('column_no', 'asc');
		$query = $this->db->get('assignments_rubrics_builder_heading');
		return $query->result();
	}
	
	function self_rating_save(){
	
		$assignment_code = $this->input->post('h_assignment_code');
		$assignment_id = $this->input->post('h_assignment_id');
		$auth_code = $this->input->post('h_auth_code');
		
		if(isset($auth_code) && $auth_code>0){
		
			if(isset($assignment_code) && $assignment_code!='' && isset($auth_code) && $auth_code!=''){
			
				$rate_your_self = $this->input->post('txt_rate_your_self'); 
				
				$arr = array('rate_your_self'=>$rate_your_self);
				$this->db->where('auth_code',$auth_code);
				$this->db->where('assingment_id',$assignment_id);
				$this->db->update('assingment_email',$arr);
				
			}
			
		}
		
		redirect(base_url().'assignment/questions/'.$assignment_code.'/'.$auth_code);
	}
	
	function answer_save(){		
	
		$assignment_code = $this->input->post('h_assignment_code');
		$assignment_id = $this->input->post('h_assignment_id');
		$department_id = $this->input->post('h_department_id');
		$auth_code = $this->input->post('h_auth_code');
		
		if(isset($auth_code) && $auth_code>0){
		
			if(isset($assignment_code) && $assignment_code!='' && isset($auth_code) && $auth_code!=''){			
				$first_name = $this->input->post('txt_first_name');
				$last_name = $this->input->post('txt_last_name');				
				$arr = array('first_name'=>$first_name,'last_name'=>$last_name);
				$this->db->where('auth_code',$auth_code);
				$this->db->where('assingment_id',$assignment_id);
				$this->db->where('department_id',$department_id);
				$this->db->update('assingment_email',$arr);				
			}
						
			$question_id_arr = $this->input->post('h_question_id');
			
			if(count($question_id_arr)>0){
			
				$h_question_type_arr = $this->input->post('h_question_type');
				
				for($i=0;$i<count($question_id_arr);$i++){
					$question_id = $question_id_arr[$i];
					$question_type = $h_question_type_arr[$i];
					$given_answer = $this->input->post('field_name'.$question_id);
					if(isset($given_answer) && $given_answer!=''){
						
						$this->db->where('assignment_id', $assignment_id);
						$this->db->where('auth_code', $auth_code);
						$this->db->where('question_id', $question_id);
						$this->db->where('question_status', '1');
						$this->db->where('status', '0');
						$this->db->where('is_delete', '0');
 						$query = $this->db->get('assingment_question_answer');
						$num_rows = $query->num_rows();
						if($num_rows==0){
						
							$question_answer_arr = array('assignment_id'=>$assignment_id, 'auth_code'=>$auth_code, 'question_id'=>$question_id, 'question_type'=>$question_type, 'given_answer'=>$given_answer, 'question_status'=>'1', 'add_date'=>time());
							$this->db->insert('assingment_question_answer', $question_answer_arr);	
							
						}else{
							
							$question_answer_arr = array('given_answer'=>$given_answer);
							$this->db->where('assignment_id', $assignment_id);
							$this->db->where('auth_code', $auth_code);
							$this->db->where('question_id', $question_id);
							$this->db->where('question_status', '1');
							$this->db->update('assingment_question_answer',$question_answer_arr);
							
						}
					}
				}
				
			}
			
			$courses = $this->input->post('txt_courses');
			/*$h_courses_id = $this->input->post('h_courses_id');
			if(count($h_courses_id)>0){
				if(count($courses)==0){
					$courses = array();
				}
				$delete_arr_result=array_diff($h_courses_id,$courses);
 				if(count($delete_arr_result)>0){
	
					$delete_ruric_crea = implode(',',$delete_arr_result);
					$this->db->where('assignment_id', $assignment_id);
					$this->db->where('auth_code', $auth_code);
					$this->db->where('question_status', '2');
					$where = ' given_answer in ('.$delete_ruric_crea.')';
					$this->db->where($where); 
					$this->db->delete('assingment_question_answer');	
				}
			}*/
			
			if(count($courses)>0){
				  $given_answer = implode(',',$courses);
			 	//for($j=0;$j<count($courses);$j++){
					//$given_answer = $courses[$j];
					$question_type=0;
					$question_id=0;
					
					    $this->db->where('assignment_id', $assignment_id);
						$this->db->where('auth_code', $auth_code);
						$this->db->where('question_status', '2');
						$this->db->where('status', '0');
						$this->db->where('is_delete', '0');
						$query = $this->db->get('assingment_question_answer');
						$num_rows = $query->num_rows();
						if($num_rows==0){
						
							$question_answer_arr = array('assignment_id'=>$assignment_id, 'auth_code'=>$auth_code, 'question_id'=>$question_id, 'question_type'=>$question_type, 'given_answer'=>$given_answer, 'question_status'=>'2', 'add_date'=>time());
							
							$this->db->insert('assingment_question_answer', $question_answer_arr);	
						
						}else{
							$question_answer_arr = array('given_answer'=>$given_answer);
							$this->db->where('assignment_id', $assignment_id);
							$this->db->where('auth_code', $auth_code);
							$this->db->where('question_status', '2');
							$this->db->update('assingment_question_answer',$question_answer_arr);
						}
				//}
 			}
			
		}
		
		redirect(base_url().'assignment/questions/'.$assignment_code.'/'.$auth_code);
		
	}
	
	
	
	function apply_finish_status($status,$assingment_id,$auth_code){	
		$arr = array('finish_status'=>$status,'finish_date'=>time());
		$this->db->where('auth_code',$auth_code);
		$this->db->where('assingment_id',$assingment_id);
		$this->db->update('assingment_email',$arr);	
	}
	
}
?>