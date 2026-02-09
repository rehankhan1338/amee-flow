<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coordinate_mdl extends CI_Model {
	
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
	
	public function import_data_courses($course_status){
	
		$error_message = '0';
		$dept_id = $this->session->userdata('dept_id');	
 		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('temp_import_table');
		$result = $query->result();
		foreach($result as $temp_import_table){
			
			$course_prefix = $temp_import_table->col_1;
			$course_number = $temp_import_table->col_2;
			$course_title = $temp_import_table->col_3;
			
			$this->db->where('course_status', $course_status);
			$this->db->where('department_id', $dept_id);
			$this->db->where('course_prefix', $course_prefix);
			$this->db->where('course_number', $course_number);
			$query = $this->db->get('department_courses');
			$num_rows = $query->num_rows();
			if($num_rows == 0 && isset($course_prefix) && $course_prefix!='' && isset($course_number) && $course_number!='' && isset($course_title) && $course_title!=''){				
				
				$insert_data=array('department_id'=>$dept_id, 'course_status'=>$course_status, 'course_prefix'=>$course_prefix, 'course_number'=>$course_number, 'course_title'=>$course_title,'add_date'=>time());
				$this->db->insert('department_courses',$insert_data);
								
			}else{				
				
				$error_message = '1';
 				if(empty($course_prefix)){
 					$error_reason = 'course prefix is required for '.$course_number;
 				}else if(empty($course_number)){
 					$error_reason = 'course number is required for '.$course_prefix;
 				}else if(empty($course_title)){
 					$error_reason = 'course title is required for '.$course_prefix.' '.$course_number;
 				}else{
 					$error_reason = $course_prefix.' '.$course_number.' is already exist!';
 				}				
 				$error_reason_data=array('department_id'=>$dept_id, 'error_reason'=>$error_reason);
				$this->db->insert('import_error_log',$error_reason_data);
				
			}			
			 		
		}
		
		if($error_message==1){ $this->session->set_flashdata('error', 'yes'); }	
		
		if($course_status==0){
			redirect('department/coordinate/action2');
		}else{
			redirect('department/coordinate/action2?tab_id=2');
		}	
		
	}
	
	public function get_import_error_log($department_id){
 		$this->db->where('department_id', $department_id);
		$query = $this->db->get('import_error_log');
		return $query->result();
	}
	
	public function get_allignment_matrix_courses_count($department_id,$matrix_options_id,$underg_grad_status){	
  		$dbprefix = trim($this->db->dbprefix);		
		$query = $this->db->query('select * from '.$dbprefix.'department_allignment_matrix where department_id="'.$department_id.'" and matrix_option_id="'.$matrix_options_id.'" and course_id in (select id from '.$dbprefix.'department_courses where course_status="'.$underg_grad_status.'")');
		return $query->num_rows();
	}
	
	public function get_core_competency_title($id){
  		$this->db->where('id', $id);
		$query = $this->db->get('master_core_competency');
		$row = $query->row();
		return $row->name;
	}
	
	public function get_pslos_core_competency($department_id,$pslos_id){
  		$this->db->where('department_id', $department_id);
  		$this->db->where('department_pslos_id', $pslos_id);
		$this->db->where('status', '0');
		$query = $this->db->get('department_assign_core_competency');
		return $query->row();
	}
	
	/*public function department_checklist_detail_row(){
 		//$this->db->order_by('id', 'desc');
 		$dept_id = $this->session->userdata('dept_id');	
 		$this->db->where('department_id', $dept_id);
		$query = $this->db->get('department_checklist_detail');
		return $query->row();
	}*/
	
	public function get_count_courses_for_underg_grad($department_id,$course_status){
  		$this->db->where('department_id', $department_id);
		$this->db->where('course_status', $course_status);
		$query = $this->db->get('department_courses');
		return $query->num_rows();
	}
	
	public function get_count_plsos_for_underg_grad($department_id,$pslos_status){
  		$this->db->where('department_id', $department_id);
		$this->db->where('pslos_status', $pslos_status);
		$query = $this->db->get('department_pslos');
		return $query->num_rows();
	}
	
	
	public function coordinate_save_action1(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$coordinate_action1_overview = $this->input->post('coordinate_action1_overview');
	 	
	 	$this->db->where('department_id', $dept_id);
	 	$query = $this->db->get('department_checklist_detail');
		$num = $query->num_rows();
		if($num==0){
			$insert_data=array('department_id'=>$dept_id, 'coordinate_action1_overview'=>$coordinate_action1_overview, 'add_date'=>time());
			$this->db->insert('department_checklist_detail',$insert_data);
		}else{
			$insert_data=array('coordinate_action1_overview'=>$coordinate_action1_overview);
			$this->db->where('department_id', $dept_id);
			$this->db->update('department_checklist_detail',$insert_data); 		
		}
	}	
	


//=====----- action2 -----=====//	
	
	public function department_courses_result_undergraduate(){
  		$dept_id = $this->session->userdata('dept_id');	
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '0');
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}		
	
	public function department_courses_result_graduate(){
  		$dept_id = $this->session->userdata('dept_id');	
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '1');
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}	
	
	public function department_programs_align_matrix(){
  		$dept_id = $this->session->userdata('dept_id');	
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '2');
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}
	
	public function department_courses_add(){
		$dept_id = $this->session->userdata('dept_id');		
	 	$course_number = $this->input->post('course_number');
	 	$course_prefix = $this->input->post('course_prefix');
	 	$course_status = $this->input->post('hcourse_add_status');
	 	$course_title = $this->input->post('add_course_title');

		$insert_data=array('department_id'=>$dept_id, 'course_status'=>$course_status, 'course_title'=>$course_title, 
			'course_number'=>$course_number, 'course_prefix'=>$course_prefix, 'add_date'=>time());
		$this->db->insert('department_courses',$insert_data);		
		$this->session->set_flashdata('success', 'Added Successfully!');	
		if($course_status==0){	
			redirect('department/coordinate/action2');
		}else if($course_status==1){	
			redirect('department/coordinate/action2?tab_id=2');
		}else{
			redirect('department/coordinate/action2?tab_id=3');
		}	
	}	
	
	public function edit_courses_ugrad_grad_entry(){	
		$course_title = $this->input->post('course_title');
	 	$course_status = $this->input->post('hcourse_edit_status');
	 	$course_number = $this->input->post('course_number');
	 	$course_prefix = $this->input->post('course_prefix');
		$id = $this->input->post('hupdate_id');
 		$arr = array('course_title'=>$course_title, 'course_number'=>$course_number, 'course_prefix'=>$course_prefix);
		$this->db->where('id', $id);
		$this->db->update('department_courses',$arr);
		$this->session->set_flashdata('success', 'Updated Successfully!');
		if($course_status==0){	
			redirect('department/coordinate/action2');
		}else if($course_status==1){	
			redirect('department/coordinate/action2?tab_id=2');
		}else{
			redirect('department/coordinate/action2?tab_id=3');
		}	 	
	}	
	
	
	public function delete_courses_ugrad_grad_entry($id){	
		$this->db->delete('department_courses',array('id'=>$id));
		$this->session->set_flashdata('success', 'Deleted Successfully!');	
		if(isset($_GET['status']) && $_GET['status']==0){	
			redirect('department/coordinate/action2');
		}else if(isset($_GET['status']) && $_GET['status']==1){
			redirect('department/coordinate/action2?tab_id=2');
		}else{
			redirect('department/coordinate/action2?tab_id=3');
		}
	}


	public function save_undergraduate_allignment_matrix(){	
		
		$dept_id = $this->session->userdata('dept_id');
		$upslos=$_POST['upslos'];
		for($i=0;$i<count($upslos);$i++){
			
			$pslos_id = $upslos[$i];
			$this->db->where('department_id', $dept_id);
			$this->db->where('course_status', '0');
			$this->db->order_by('id', 'desc');
			$query_department_courses = $this->db->get('department_courses');
			$courses = $query_department_courses->result();
			foreach($courses as $courses_details){
				
				$course_id = $courses_details->id;
				$matrix_option_id = $_POST[$pslos_id.'ucourses_'.$course_id];
				
				if(isset($matrix_option_id) && $matrix_option_id!=''){
				
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$query = $this->db->get('department_allignment_matrix');
					$num = $query->num_rows();
					if($num==0){
					
						$insert_data=array('department_id'=>$dept_id, 'pslos_id'=>$pslos_id, 'course_id'=>$course_id, 'matrix_option_id'=>$matrix_option_id, 'add_date'=>time());
						$this->db->insert('department_allignment_matrix',$insert_data);
						
					}else{
					
						$update_data=array('matrix_option_id'=>$matrix_option_id);
						$this->db->where('department_id', $dept_id);
						$this->db->where('pslos_id', $pslos_id);
						$this->db->where('course_id', $course_id);
						$this->db->update('department_allignment_matrix',$update_data);
								
					}
				
				}else{
					
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$this->db->delete('department_allignment_matrix');
					
				}				
				
			}//echo '<hr>';		
		}
		$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
 		$undergraduate_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$undergraduate_status_value);
		if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==1){
 			$this->Design_mdl->update_undergraduate_automatic_rotation_plan();
		}
		
		redirect('department/coordinate/action3');
		
	}
	
	public function save_graduate_allignment_matrix(){	
		
		$dept_id = $this->session->userdata('dept_id');
		$gpslos=$_POST['gpslos'];
		for($i=0;$i<count($gpslos);$i++){
			
			$pslos_id = $gpslos[$i];
			$this->db->where('department_id', $dept_id);
			$this->db->where('course_status', '1');
			$this->db->order_by('id', 'desc');
			$query_department_courses = $this->db->get('department_courses');
			$courses = $query_department_courses->result();
			foreach($courses as $courses_details){
				
				$course_id = $courses_details->id;
				$matrix_option_id = $_POST[$pslos_id.'gcourses_'.$course_id];
				
				if(isset($matrix_option_id) && $matrix_option_id!=''){
				
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$query = $this->db->get('department_allignment_matrix');
					$num = $query->num_rows();
					if($num==0){
					
						$insert_data=array('department_id'=>$dept_id, 'pslos_id'=>$pslos_id, 'course_id'=>$course_id, 'matrix_option_id'=>$matrix_option_id, 'add_date'=>time());
						$this->db->insert('department_allignment_matrix',$insert_data);
						
					}else{
					
						$update_data=array('matrix_option_id'=>$matrix_option_id);
						$this->db->where('department_id', $dept_id);
						$this->db->where('pslos_id', $pslos_id);
						$this->db->where('course_id', $course_id);
						$this->db->update('department_allignment_matrix',$update_data);
								
					}
				
				}else{
					
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$this->db->delete('department_allignment_matrix');
					
				}				
				
			}//echo '<hr>';		
		}
		
		$graduate_status_value = $this->config->item('con_graduate_status_value');
		$graduate_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$graduate_status_value);
		if(isset($graduate_rotation_plan_status) && $graduate_rotation_plan_status==1){
			$this->Design_mdl->update_graduate_automatic_rotation_plan();
		}
		redirect('department/coordinate/action3?tab_id=2');
		
	}
	
	public function save_program_allignment_matrix(){	
		
		$dept_id = $this->session->userdata('dept_id');
		$gpslos=$_POST['gpslos'];
		for($i=0;$i<count($gpslos);$i++){
			
			$pslos_id = $gpslos[$i];
			$this->db->where('department_id', $dept_id);
			$this->db->where('course_status', '2');
			$this->db->order_by('id', 'desc');
			$query_department_courses = $this->db->get('department_courses');
			$courses = $query_department_courses->result();
			foreach($courses as $courses_details){
				
				$course_id = $courses_details->id;
				$matrix_option_id = $_POST[$pslos_id.'gcourses_'.$course_id];
				
				if(isset($matrix_option_id) && $matrix_option_id!=''){
				
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$query = $this->db->get('department_allignment_matrix');
					$num = $query->num_rows();
					if($num==0){
					
						$insert_data=array('department_id'=>$dept_id, 'pslos_id'=>$pslos_id, 'course_id'=>$course_id, 'matrix_option_id'=>$matrix_option_id, 'add_date'=>time());
						$this->db->insert('department_allignment_matrix',$insert_data);
						
					}else{
					
						$update_data=array('matrix_option_id'=>$matrix_option_id);
						$this->db->where('department_id', $dept_id);
						$this->db->where('pslos_id', $pslos_id);
						$this->db->where('course_id', $course_id);
						$this->db->update('department_allignment_matrix',$update_data);
								
					}
				
				}else{
					
					$this->db->where('department_id', $dept_id);
					$this->db->where('pslos_id', $pslos_id);
					$this->db->where('course_id', $course_id);
					$this->db->delete('department_allignment_matrix');
					
				}				
				
			}//echo '<hr>';		
		}
		
		$program_status_value = $this->config->item('con_program_status_value');
		$program_rotation_plan_status = get_rotation_plan_status_h($this->session->userdata('dept_id'),$program_status_value);
		if(isset($program_rotation_plan_status) && $program_rotation_plan_status==1){
			$this->Design_mdl->update_program_automatic_rotation_plan();
		}
		redirect('department/coordinate/action3?tab_id=3');
		
	}
	
	
	public function get_count_allignment_matrix_option($department_id,$pslos_id,$course_id,$matrix_option_id){
		$this->db->where('department_id', $department_id);
		$this->db->where('pslos_id', $pslos_id);
		$this->db->where('course_id', $course_id);
		$this->db->where('matrix_option_id', $matrix_option_id);
		$query = $this->db->get('department_allignment_matrix');
		return $num = $query->num_rows();
	}
	
	
	public function get_colorcode_matrix_option($department_id,$pslos_id,$course_id){
	
		$this->db->where('department_id', $department_id);
		$this->db->where('pslos_id', $pslos_id);
		$this->db->where('course_id', $course_id);
		$query = $this->db->get('department_allignment_matrix');
		$num = $query->num_rows();
		if($num>0){
			$row = $query->row();
			$matrix_options_id=$row->matrix_option_id;
			$this->db->where('id', $matrix_options_id);
			$query = $this->db->get('master_matrix_options_colorcode');
			$row = $query->row();
			return $row->color_name;
		}		
		
	}
	
		
}