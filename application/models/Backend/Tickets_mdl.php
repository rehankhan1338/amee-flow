<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_mdl extends CI_Model {
	
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
	
	public function admin_tickets_listing(){		
		$this->db->select('un.first_name, un.last_name, un.university_name, un.sbDatabase, un.sdTblPrefix, unique_ticket_id, un.id as university_id, tickets.id, tickets.department_id, msg_by, unread_admin_status, unread_user_status, tickets.last_modification_date, generated_time, conversation_cnt, ticket_status, type_of_support, send_message_to');
		$this->db->from('tickets');
		$this->db->join('university as un', 'un.id = tickets.university_id');
		/*if(isset($admin_type) && $admin_type!='super_admin' && isset($role_id) && $role_id!='' && $role_id>0){
			$this->db->where('tickets.send_message_to',$role_id);
		}*/
		$this->db->where('tickets.deleted_status','0');
		$this->db->order_by('tickets.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_department_details($department_id){
		$amee_pro = $this->load->database('amee_pro', TRUE); 
		$amee_pro->where('id', $department_id);	
		$query = $amee_pro->get('departments'); 
		return $query->row();
	}
	
	public function get_university_details($university_id){
  		$this->db->where('id', $university_id);
		$query = $this->db->get('university'); 
		return $query->row();
	}
	
	public function my_ticket_details($unique_ticket_id){		 
		$this->db->where('unique_ticket_id', $unique_ticket_id);
		$query = $this->db->get('tickets'); 
		return $query->row();
	}	
	
	public function update_admin_view_status($id){ 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("unread_admin_status"=>'0'));
	}	 
	
	
	public function update_user_view_status($id){ 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("unread_user_status"=>'0'));
	}
	
	public function my_ticket_conversation_data($ticket_id){
		$this->db->where('deleted_status','0'); 
		$this->db->where('ticket_id', $ticket_id);	
		$this->db->order_by('conversation_id', 'asc'); 
		$query = $this->db->get('tickets_conversations'); 
		return $query->result();
	}
	
	public function comment_entry($msg_by,$department_id,$id,$university_id){
		$problem_msg = $this->input->post('problem_message');
		$ip_address=$_SERVER['REMOTE_ADDR'];			
		$generated_date = strtotime(date('Y-m-d'));
		$generated_time = time(); 
		
		$conversation_cnt = $this->input->post('h_conversation_cnt')+1; 
		if($msg_by==0){
			$update_1 = array("unread_admin_status"=>'1',"conversation_cnt"=>$conversation_cnt,"last_modification_date"=>$generated_time);
		}else{
			$update_1 = array("unread_user_status"=>'1',"conversation_cnt"=>$conversation_cnt,"last_modification_date"=>$generated_time);
		}
		$this->db->where('id',$id);
		$this->db->update('tickets', $update_1); 
		
		$msg_data_arr=array("ticket_id"=>$id,"msg_by"=>$msg_by,"university_id"=>$university_id,"department_id"=>$department_id,"problem_msg"=>$problem_msg,"msg_date"=>$generated_date,"msg_time"=>$generated_time,"last_modification_date"=>$generated_time);
		$this->db->insert('tickets_conversations',$msg_data_arr);
		
			$sent_to_email = $this->input->post('h_sent_to_email');
			$sent_to_name = $this->input->post('h_sent_to_name');
			$ticket_id = $this->input->post('h_unique_ticket_id');
			
			$university_name=$this->config->item('project_name_page_first');
			$product_name=$this->config->item('project_name_page_first');
 			
			$multiple_emails = array();	
			$multiple_emails[] = $sent_to_email.'||'.$sent_to_name;
			
			if(count($multiple_emails)>0){
				$multiple_recipients = implode(',',$multiple_emails);
				$subject = $this->input->post('problem_subject');
				$email_message = '<h4>Ticket Id - '.$ticket_id.'</h4>'.$problem_msg.'<p>Thanks<br />Team '.$product_name.'</p>';
				send_mail_to_multiple($multiple_recipients,$email_message,'','info',$subject);		
			} 
			 
			 
		$this->session->set_flashdata('success', 'Your message has been sent successfully!');
	}
	
	public function update_status_ticket($id,$ticket_status,$deptFname,$deptEmail,$unique_ticket_id){
		$last_modification_date = time(); 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("ticket_status"=>$ticket_status,"last_modification_date"=>$last_modification_date)); 
		if($ticket_status==1){
 		  			
			$product_name=$this->config->item('project_name_page_first');
			$multiple_emails = array();	
			$multiple_emails[] = $deptEmail.'||'.$deptFname;
			
			if(count($multiple_emails)>0){
				$multiple_recipients = implode(',',$multiple_emails);
				$subject = 'Ticket Closed';
				$email_message = '<p>Hi '.$deptFname.',</p><h4>Ticket Id - '.$unique_ticket_id.'</h4><p>Your support ticket is closed and the problem has been resolved. Please contact us again if you have any problems.</p><p>Thanks<br />Team '.$product_name.'</p>';
				send_mail_to_multiple($multiple_recipients,$email_message,'','info',$subject);		
			} 
			
		}
	}
	
	public function delete_ticket($id,$unique_ticket_id){
		$last_modification_date = time(); 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("deleted_status"=>'1',"last_modification_date"=>$last_modification_date)); 
		$this->session->set_flashdata('success', 'Your ticket <strong>'.$unique_ticket_id.'</strong> has been deleted successfully!');
	}
	
}