<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_mdl extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
	}	
	
	public function get_department_notification_list($department_id,$university_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$where = "FIND_IN_SET(".$university_id.",sendTo) and isDeleted=0";
		$amee_web->where($where);
		$amee_web->limit(10);  
		$amee_web->order_by('notificationId', 'desc');
		$query = $amee_web->get('notifications');
		return $query->result_array();
	}
	
	//////////////////////// Notification //////////////////////////////////////
	
	/*public function reset_notifications(){
	
		$update_data=array("reset_status" =>'1');
		$this->db->where('reset_status', '0');
		$this->db->update('department_notifications',$update_data);
		$this->session->set_flashdata('success', 'Notification reset successfully!');
	}
	
	public function delete_notification($id){
		  
		$query = $this->db->delete('department_notifications', array('id' => $id));
  		$this->session->set_flashdata('success', str_msg9); 
		
	}
	 
	public function send_notification_to_department(){
	
		$university_id = $this->config->item('cv_university_id');
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id', $university_id);
		$query_university = $amee_web->get('university');
		$university_details = $query_university->row();
		$university_name = $university_details->university_name;
		$contact_first_name = $university_details->first_name;
		$contact_last_name = $university_details->last_name;
 		$admin_name = $university_details->first_name.' '.$university_details->last_name;
		
		$query_email_templates = $this->db->get_where('email_templates', array('purpose' =>'Notification Send'));
		$email_templates = $query_email_templates->row();
		$email_subject = $email_templates->subject;
		$email_message = $email_templates->message;
		$email_status = $email_templates->status;
 
 		$department_profile_link=base_url().'department/notifications';
		$id = explode(',',$_GET['id']);
		$message = $_GET['message'];
		$notification_type = $_GET['notification_type'];
		$send_date = strtotime(date('Y-m-d'));
		
		$send_time = time(); 
		$userid = $this->session->userdata('userid');
		
 		for($i=0;$i<count($id);$i++){
			
			$department_id = $id[$i];
			
			$this->db->where('id', $department_id);
			$query = $this->db->get('departments');
			$row = $query->row();
			$to = $row->email;
			$first_name = ucfirst($row->first_name);
			
			$insert_data=array("department_id"=>$department_id,"message"=>$message,"notification_type"=>$notification_type,"send_from_admin_id"=>$userid,"send_date"=>$send_date,"send_time"=>$send_time);
			$this->db->insert('department_notifications',$insert_data);
			
			if($email_status==1){
	 
				$email_message1=str_replace('{name}',$first_name,$email_message);
				$email_message1=str_replace('{notification_message}',$message,$email_message1);
				$email_message1=str_replace('{department_link}',$department_profile_link,$email_message1);
				$email_message1=str_replace('{admin_name}',$admin_name,$email_message1);
				$email_message1=str_replace('{college_name}',$university_name,$email_message1);
				send_mail($to,$email_message1,$first_name,'info',$email_subject);
			}
			
			$this->session->set_flashdata('success', 'Notification sent successfully!');
 		} 
	}
	
	public function get_last_notification_sent_details($department_id){
 		$this->db->where('department_id', $department_id);
		$this->db->where('reset_status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('department_notifications');
		return $query->row();
	}
	
	public function get_unread_stauts_notification($department_id){
		$query = $this->db->get_where('department_notifications', array('department_id'=>$department_id,'status'=>'0'));
		return $count=$query->num_rows();
	}
	
	public function get_all_notification_count_of_department($department_id){
		$query = $this->db->get_where('department_notifications', array('department_id'=>$department_id,'reset_status'=>'0'));
		return $count=$query->num_rows();
	}
	
	public function get_department_notification_list($department_id,$call_by){
		if($call_by=='department'){
			$update_data=array("status" =>'1');
			$this->db->where('department_id', $department_id);
			$this->db->update('department_notifications',$update_data);
		}
		
 		$this->db->where('department_id', $department_id);
		$this->db->where('reset_status', '0');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('department_notifications');
		return $query->result();
	}*/
}