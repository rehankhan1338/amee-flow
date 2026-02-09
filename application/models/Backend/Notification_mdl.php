<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_mdl extends CI_Model {
	
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
	
	public function university_data(){	
		$this->db->select('id, university_name');
		$this->db->where('status', '1');
		$this->db->where('is_delete', '1');
		$this->db->order_by('university_name', 'asc');
		$query = $this->db->get('university');
		return $query->result_array();		
	}
	
	public function delete_notifications($notificationId){		
		$this->db->where('notificationId',$notificationId); 
 		$this->db->update('notifications', array("isDeleted"=>'1'));		
  		$this->session->set_flashdata('success', 'Notification has been deleted successfully!'); 		
	}
	
	public function notifications_details(){	
		$this->db->where('isDeleted', '0');
		$this->db->order_by('notificationId', 'desc');
		$query = $this->db->get('notifications');
		return $query->result();		
	}
	
	public function notifications_fulldetails($notificationId){	
 		$this->db->where('notificationId', $notificationId);
		$query = $this->db->get('notifications');
		return $query->row();		
	}
	
	public function add_notifications(){
 	 	$notiTitle = trim($this->input->post('notiTitle')); 
		$msgBody = $this->input->post('msgBody');
		$sendTo = '';
		$uniIds = $this->input->post('uniIds');
		if(isset($uniIds) && $uniIds!='' && count($uniIds)>0){
			$sendTo = implode(',',$uniIds);
		}
 		$this->db->insert('notifications', array("title"=>$notiTitle, "messageBody"=>$msgBody, "sendTo"=>$sendTo, "createTime"=>time()));
		$this->session->set_flashdata('success', 'Notification has been created successfully!');		
	}
	
	public function edit_notifications($notificationId){	 
	 	$notiTitle = trim($this->input->post('notiTitle')); 
		$msgBody = $this->input->post('msgBody');	
		$sendTo = '';
		$uniIds = $this->input->post('uniIds');
		if(isset($uniIds) && $uniIds!='' && count($uniIds)>0){
			$sendTo = implode(',',$uniIds);
		}
		$this->db->where('notificationId',$notificationId); 
 		$this->db->update('notifications', array("title"=>$notiTitle, "messageBody"=>$msgBody, "sendTo"=>$sendTo));			
		$this->session->set_flashdata('success', 'Notification has been updated successfully!');	
	}	
}