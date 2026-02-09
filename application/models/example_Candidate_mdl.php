<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_mdl extends CI_Model {
	
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
	
	////////////////////////////////////////////// Teaching Interest ///////////////////////////////////////////
	
	public function manage_courses_teach(){
	
		$course_id = implode(',',$this->input->post('course_id'));
		$candidate_id = $this->session->userdata('candidate_id');
		
		$query = $this->db->get_where('candidate_courses_teach', array('candidate_id'=>$candidate_id));
		$count=$query->num_rows();
		if($count==0){
		
 			$insert_data=array(
				"course_id"=>$course_id,
				"candidate_id"=>$candidate_id);
				
			$this->db->insert('candidate_courses_teach',$insert_data);
		}else{
		
			$update_data=array("course_id" =>$course_id);
			$this->db->where('candidate_id',$candidate_id);
			$this->db->update('candidate_courses_teach',$update_data); 
		
		}
		
 	}
 	
	public function approve_candidate_coures(){
	
		$approved_course_id = implode(',',$this->input->post('course_id'));
		$candidate_id = $this->input->post('hidden_candidate_id');
		
		$update_data=array("approved_course_id" =>$approved_course_id);
		$this->db->where('candidate_id',$candidate_id);
		$this->db->update('candidate_courses_teach',$update_data);
		$this->session->set_flashdata('success', approve_candidate_coures_msg); 
		redirect("teaching_pool/app_material_teach_interest?id=".$candidate_id."&tab_id=5");
 		
 	}
	
	public function candidate_courses_teach($candidate_id){
	
		$this->db->where('candidate_id', $candidate_id); 
		$query = $this->db->get('candidate_courses_teach');
		return $query->row();
	}
	
	////////////////////////////  Application Materials ///////////////////////////////////////////////////
	
	public function candidate_application_material_list($candidate_id,$application_materials_doc_status){
	
		$this->db->where('candidate_id', $candidate_id); 
		$this->db->where('application_materials_doc_status', $application_materials_doc_status); 
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('candidate_application_material');
		return $query->result();
	}
	
	public function add_application_material($candidate_id,$application_materials_doc_status){
   		
		if(isset($_FILES['upload_doc']['name']) && $_FILES['upload_doc']['name']!=''){
			
			if($_FILES['upload_doc']['error']==0){
			
				$ext=preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['upload_doc']['name']);
				$upload_doc=time().'.'.$ext;
				
				$config['file_name'] =$upload_doc;
				$config['upload_path'] = './assets/application_materials/';
				$config['allowed_types'] = 'pdf|doc|docx|pptx|xlsx|xls|csv|txt|ppt';
				$this->load->library('upload');
				$this->upload->initialize($config);
				$this->upload->do_upload('upload_doc');
				
				$errors = $this->upload->display_errors('<span>', '</span>');
				if(isset($errors) && $errors!=''){
					 $this->session->set_flashdata('error', $errors);
					 $this->session->set_flashdata('success', ''); 
				}else{
				
					$title = trim($this->input->post('title'));
					$icon_id = trim($this->input->post('icon_id'));
					$add_date = strtotime(date('Y-m-d'));
					
					$insert_data=array(
						"title"=>$title,
						"file_name"=>$upload_doc,
						"icon_id"=>$icon_id,
						"application_materials_doc_status"=>$application_materials_doc_status,
						"candidate_id"=>$candidate_id,
						"add_date"=>$add_date);
					
					$this->db->insert('candidate_application_material',$insert_data); 
					$this->session->set_flashdata('success', doc_added);
					
				} 
			}
		}
 		
	}
	
	public function delete_application_materials($id){
	 
		$ids = explode(',',$id);
		for($i=0;$i<count($ids);$i++){
		
			$document_id = $ids[$i];
			$query = $this->db->get_where('candidate_application_material', array('id'=>$document_id));
			$documents = $query->row();
			$file_name = $documents->file_name; 
			$path = dirname(dirname(__DIR__)).'/assets/application_materials/'.$file_name;
			unlink($path);
			
			$query = $this->db->delete('candidate_application_material', array('id' => $document_id));
  			$this->session->set_flashdata('success', doc_delete); 
		
		}
		
	}
 	 
	 //////////////////////// Notification //////////////////////////////////////
	
	public function notification_details($candidate_id){
	
		$this->db->where('candidate_id', $candidate_id); 
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('candidate_notification');
		return $query->result();
	}
	
	public function delete_notification($id){
		  
		$query = $this->db->delete('candidate_notification', array('id' => $id));
  		$this->session->set_flashdata('success', str_msg9); 
		
	}
	
	public function candidate_panel_unread_notification_count(){
	
		$faculty_id = $this->session->userdata('candidate_id');
		$query = $this->db->get_where('candidate_notification', array('candidate_id'=>$candidate_id,'status'=>'0'));
		return $count=$query->num_rows();
	}
	
	/////////////////////////////////////  Candidate //////////////////////////////////////////////////
 
	public function send_notification_to_candidate(){
	
		$id = explode(',',$_GET['id']);
		$message = $_GET['message'];
		$send_date = strtotime(date('Y-m-d'));
		for($i=0;$i<count($id);$i++){
			
			$candidate_id = $id[$i];
			$insert_data=array("candidate_id"=>$candidate_id,"message"=>$message,"send_date"=>$send_date);
			$this->db->insert('candidate_notification',$insert_data);
			$this->session->set_flashdata('success', sent_notification);
 		} 
	}
	
	public function delete_candidate_profile(){
	
		$id = explode(',',$_GET['id']);
		for($i=0;$i<count($id);$i++){
			
			$candidate_id = $id[$i];
			$this->db->where('candidate_id',$candidate_id);
			$query = $this->db->delete('candidates');
			
			$this->db->where('candidate_id',$candidate_id);
			$query = $this->db->delete('candidate_job_apply');
			
			$this->db->where('candidate_id',$candidate_id);
			$query = $this->db->delete('candidate_notification');
 		} 
	}
	
	 /*public function send_password_link_to_candidate($username,$department_name,$university_name){
	
		$id = explode(',',$_GET['id']); 
		for($i=0;$i<count($id);$i++){
			
			$candidate_id = $id[$i]; 
			$query = $this->db->get_where('candidates', array('candidate_id' =>$candidate_id));
			$row = $query->row();
			$name = $row->first_name;
			$email = $row->email;
			$login_password = $row->password_show;
			$encrpt_email = $row->email_md5;
			
			//$email = 'tns.ankit@gmail.com';
			
  			$this->db->select('*');
			$this->db->where('purpose', 'Send Candidate Login Link');
			$query1 = $this->db->get('email_templates');
			$fetch_email_templates = $query1->row();
			
			$subject = $fetch_email_templates->subject;
			$message = $fetch_email_templates->message;
			$status_email = $fetch_email_templates->status;
			
			if($status_email==1){
 			  
 				$candidate_login_url = base_url().'candidate/';
				
				$message = str_replace('{candidate_name}',$name,$message);
				$message = str_replace('{candidate_login_url}',$candidate_login_url,$message);
				$message = str_replace('{username}',$username,$message);
				$message = str_replace('{login_email}',$email,$message);
				$message = str_replace('{login_password}',$login_password,$message);
				$message = str_replace('{name_of_department}',$department_name,$message);
				$message = str_replace('{name_of_university}',$university_name,$message);
				
				send_mail($email,$message,$name,'info',$subject);
			
			} 
			 
 		} 
	}*/
	
	public function applied_job_candidate_list($candidate_id){
	   
		$this->db->where('candidate_id', $candidate_id); 
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('candidate_job_apply');
		return $query->result();
	}
	
	 public function candidate_list(){
	   
		$this->db->order_by('candidate_id', 'asc');
		$query = $this->db->get('candidates');
		return $query->result();
	}
	
	public function candidates_full_details($id){
	  
		$this->db->where('candidate_id', $id); 
		$query = $this->db->get('candidates');
		return $query->row();
	}
	
	 public function check_candidate_signin($job_id){
	 	
		$email = trim($this->input->post('email'));
		$password = md5($this->input->post('pass'));
		$query = $this->db->get_where('candidates', array('email' =>$email,'password' =>$password));
		$count=$query->num_rows();
		if($count==0){
			$this->session->set_flashdata('error', str_msg3);
			redirect('job/signin/'.$job_id);
		}else{
			 $row=$query->row();
			 $candidate_id=$row->candidate_id;
			 $this->candidate_job_apply($job_id,$candidate_id); 
		} 
	 
	 }
	 
	 public function candidate_job_apply($job_id,$candidate_id){
		$query = $this->db->get_where('candidate_job_apply', array('job_id' =>$job_id,'candidate_id' =>$candidate_id));
		$count=$query->num_rows();
		if($count==0){
			$insert_data=array(
				"job_id"=>$job_id,
				"candidate_id"=>$candidate_id,
 				"apply_date"=>time());
				
			$this->db->insert('candidate_job_apply',$insert_data);
		}else{
			
			$this->session->set_flashdata('error', 'sorry, you have already applied for this position!');
			redirect('apply/'.$job_id);
		}
	 }
	 
	 public function add_candidate_from_link($job_id){
	 
	 	$email = trim($this->input->post('email'));
		$encrpt_email = md5($email);
		$query = $this->db->get_where('candidates', array('email' =>$email));
		$count=$query->num_rows();
		if($count==0){
			
			$last_name = trim($this->input->post('last_name'));
			$first_name = trim($this->input->post('first_name'));  
			$password = $this->input->post('confirm_password'); 
			
  			$insert_data=array(
				"last_name"=>$last_name,
				"first_name"=>$first_name,
				"email"=>$email,
				"email_md5"=>$encrpt_email,
				"password"=>md5($password),
				"password_show"=>$password,
 				"add_date"=>time());
				
			$this->db->insert('candidates',$insert_data);
			$candidate_id = $this->db->insert_id();
			$this->candidate_job_apply($job_id,$candidate_id); 
		
		}else{
		
			$this->session->set_flashdata('error', candidate_error);
			redirect('apply/'.$job_id);
		}
		
		
		/*$this->db->select('*');
		$this->db->where('purpose', 'Send Candidate Login Link');
		$query1 = $this->db->get('email_templates');
		$fetch_email_templates = $query1->row();
		
		$subject = $fetch_email_templates->subject;
		$message = $fetch_email_templates->message;
		$status_email = $fetch_email_templates->status;
		
		if($status_email==1){
		  
			$candidate_login_url = base_url().'candidate/';
			
			$message = str_replace('{candidate_name}',$name,$message);
			$message = str_replace('{candidate_login_url}',$candidate_login_url,$message);
			$message = str_replace('{username}',$username,$message);
			$message = str_replace('{login_email}',$email,$message);
			$message = str_replace('{login_password}',$login_password,$message);
			$message = str_replace('{name_of_department}',$department_name,$message);
			$message = str_replace('{name_of_university}',$university_name,$message);
			
			send_mail($email,$message,$name,'info',$subject);
		
		}*/
		
	 }
	
	 
	
}