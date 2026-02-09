<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments_mdl extends CI_Model {
	
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
	
	public function sendmail($id){			
		$university_id = $this->config->item('cv_university_id');
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $university_id);
		$query_university = $amee_web->get('university');
		$university_details = $query_university->row();
		$university_name = $university_details->university_name;
		$contact_first_name = $university_details->first_name;
		$contact_last_name = $university_details->last_name;
 		$admin_name = $university_details->first_name.' '.$university_details->last_name;		
		
		$this->db->where('id', $id);
		$query = $this->db->get('departments');
		$row = $query->row();
		$to = $row->email;
		//$to = 'tns.ankit@gmail.com';
		$first_name = ucfirst($row->first_name);
		$user_id = '<b>'.$row->user_name.'</b>';
		$password = '<b>'.$row->password_view.'</b>';
		
		/*$query_admin_login = $this->db->get_where('admin_login', array('id' =>$this->session->userdata('userid')));
		$fetch_admin_login =  $query_admin_login->row();
		$admin_name = $fetch_admin_login->first_name.' '.$fetch_admin_login->last_name;*/
		 
		$this->db->select('*');
		$this->db->where('purpose', 'Department Credentials Send');
		$query1 = $this->db->get('email_templates');
		$fetch_email_templates = $query1->row();
		$subject = $fetch_email_templates->subject;
		$message = $fetch_email_templates->message;
		$status_email = $fetch_email_templates->status;
		$login_link = base_url(); 
		if($status_email==1){
		
			$tmp_img_path=base_url().'assets/backend/images/amee.png';
			$message_image = "<img src='".$tmp_img_path."'>";
			
			$message = str_replace('{logo}',$message_image,$message);
			$message = str_replace('{name}',$first_name,$message);
			$message = str_replace('{link}',$login_link,$message); 
			$message = str_replace('{user_id}',$user_id,$message);
			$message = str_replace('{password}',$password,$message);
			$message = str_replace('{admin_name}',$admin_name,$message);
 			$message = str_replace('{college_name}',$university_name,$message);
			send_mail($to,$message,$first_name,'no_reply',$subject);
			//$this->session->set_flashdata('success', str_msg19); 
		}
		
		$this->session->set_flashdata('success', 'Mail has been sent successfully!');  
		redirect('admin/departments');
	}
	
	public function department_pslos_undergraduate($department_id){
		$this->db->where('department_id', $department_id);
		$this->db->where('pslos_status', '0');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result();
	}	
	
	public function department_pslos_graduate($department_id){
		$this->db->where('department_id', $department_id);
		$this->db->where('pslos_status', '1');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('department_pslos');
		return $query->result();
	}
	
	public function department_courses_result_undergraduate($dept_id){
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '0');
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}		
	
	public function department_courses_result_graduate($dept_id){
  		$this->db->where('department_id', $dept_id);
  		$this->db->where('course_status', '1');
		$this->db->order_by('course_number', 'asc');
		$query = $this->db->get('department_courses');
		return $query->result();
	}	
	
	public function departments_details(){
 		$this->db->where('is_delete', '1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('departments');
		return $query->result();
	}
	
	public function get_feedback_listing($department_id){
 		$this->db->where('department_id', $department_id);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('department_feedbacks');
		return $query->result();
	}
	
	public function feedback_save(){
	 	$department_id = trim($this->input->post('h_department_id')); 
		$feedback = trim($this->input->post('feedback_txt'));
		$insert_data=array('department_id'=>$department_id, 'feedback'=>$feedback, 'add_date'=>time());
 		$this->db->insert('department_feedbacks',$insert_data);
		$this->session->set_flashdata('success', 'Feedback addedd successfully!'); 
		redirect('admin/snapshot/display/'.$department_id);
	}
	
	public function get_department_checklist_detail($department_id){
 		$this->db->where('department_id', $department_id);
		$query = $this->db->get('department_checklist_detail');
		return $query->row();
	}
	
	public function departments_detail_row($id){
 		$this->db->where('id', $id);
		$query = $this->db->get('departments');
		return $query->row();
	}	
	
	public function add_departments(){
	 	$departments_name = trim($this->input->post('department_name')); 
	 	$department_type = $this->input->post('department_type');
	 	$first_name = ucfirst($this->input->post('first_name'));
	 	$last_name = $this->input->post('last_name');
	 	$email = $this->input->post('email');
	 	$user_name = $this->input->post('user_name');
	 	$password = $this->input->post('new_password');
		$add_date = strtotime(date('Y-m-d H:i:s'));
		
		$this->db->where('user_name', $user_name);
		$query = $this->db->get('departments');
		$num_row = $query->num_rows();
		if($num_row==0){
			$insert_data=array('department_name'=>$departments_name, 'department_type'=>$department_type,'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'user_name'=>$user_name, 'password'=>md5($password), 'password_view'=>$password, 'add_date'=>$add_date);
			$this->db->insert('departments',$insert_data);
			$id = $this->db->insert_id();
			
			$deptEncryptId = md5($id).$id;
			$this->db->where('id',$id);
			$this->db->update('departments', array("deptEncryptId"=>$deptEncryptId));
			
			$this->session->set_flashdata('success', 'Added Successfully!'); 
			redirect('admin/departments');
		}else{
			$session_data = array('department_name'=>$departments_name, 'department_type'=>$department_type,'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'user_name'=>$user_name);
			$this->session->set_flashdata($session_data);				
			$this->session->set_flashdata('error', 'sorry, User Name already exist'); 
			redirect('admin/departments/add');
		}		
	}	
	
	public function edit_departments($id){
	 	$departments_name = trim($this->input->post('department_name'));
	 	$department_type = $this->input->post('department_type'); 
	 	$first_name = ucfirst($this->input->post('first_name'));
	 	$last_name = $this->input->post('last_name');
	 	$email = $this->input->post('email');
	 	$user_name = $this->input->post('user_name');
	 	$password = $this->input->post('password'); 
	 	$status = $this->input->post('status'); 
		$add_date = strtotime(date('Y-m-d H:i:s'));
		
		$this->db->where('user_name', $user_name);
		$this->db->where('id!=', $id);
		$query = $this->db->get('departments');
		$num_row = $query->num_rows();
		
		if($num_row==0){
		
			if(isset($password)&& $password==''){
				$update_data = array('department_name'=>$departments_name, 'department_type'=>$department_type,'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email,'user_name'=>$user_name, 'status'=>$status, 'add_date'=>$add_date);
			}else{
				$update_data=array('department_name'=>$departments_name, 'department_type'=>$department_type, 'first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'user_name'=>$user_name, 'password'=>md5($password), 'password_view'=>$password, 'status'=>$status);
			}
		
			$this->db->where('id',$id); 
			$this->db->update('departments',$update_data);
			$this->session->set_flashdata('success', 'Updated Successfully!'); 
			redirect('admin/departments');
			
		}else{
			$this->session->set_flashdata('error', 'sorry, User Name already exist'); 
			redirect('admin/departments/edit/'.$id);
		}	
	}
	
	
	public function delete_departments($id){
		$delete_date = strtotime(date('Y-m-d H:i:s'));
		$update_data = array('is_delete'=>'0', 'delete_date'=>$delete_date);
		
		$this->db->where('id',$id); 
 		$this->db->update('departments',$update_data);
		//$query = $this->db->delete('departments', array('id'=>$id));
  		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
	public function department_reports_fulldetail($action_status){
 		$this->db->where('action_status', $action_status);
		$this->db->order_by('add_date', 'asc');
		$query = $this->db->get('department_reports');
		return $query->result();
	}
	
	public function get_submitted_analysis_reports_of_dept(){
		$this->db->select('da.*, dept.department_name');
		$this->db->from('department_analysis as da');
		$this->db->where('da.submittedSts', '1');
		$this->db->join('departments as dept', 'dept.id = da.department_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
		
}