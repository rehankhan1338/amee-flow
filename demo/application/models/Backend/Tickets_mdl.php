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
	
	public function update_admin_view_status($id){ 
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id',$id);
		$amee_web->update('tickets', array("unread_admin_status"=>'0'));
	}
	
	public function admin_tickets_listing($admin_type,$role_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		
		$amee_web->select('reg.first_name, reg.last_name, unique_ticket_id, id, tickets.department_id, msg_by, unread_admin_status, unread_user_status, tickets.last_modification_date, generated_time, conversation_cnt, ticket_status, type_of_support, send_message_to');
		$amee_web->from('tickets');
		$amee_web->join('registration as reg', 'reg.department_id = tickets.department_id');
		if(isset($admin_type) && $admin_type!='super_admin' && isset($role_id) && $role_id!='' && $role_id>0){
			$amee_web->where('tickets.send_message_to',$role_id);
		}
		$amee_web->where('tickets.deleted_status','0');
		$amee_web->order_by('tickets.id', 'desc');
		$query = $amee_web->get();
		return $query->result();
	} 
	
	public function generate_ticket($msg_by,$university_id,$department_id,$RandomString,$GenFromDeptName,$GenFromDeptEmail){
		
		$amee_web = $this->load->database('amee_web', TRUE);
 		$type_of_support = $this->input->post('type_of_support');		
		$message = trim($this->input->post('fs_message'));
		$send_message_to = $this->input->post('fs_send_message_to');
		//echo 'error||';echo '---';$ticket_id=1;
		$ip_address=$_SERVER['REMOTE_ADDR'];			
		$generated_date = strtotime(date('Y-m-d'));
		$generated_time = time();
		
		$data_arr=array("msg_by"=>$msg_by,"university_id"=>$university_id,"department_id"=>$department_id,"type_of_support"=>$type_of_support,"send_message_to"=>$send_message_to,"generated_date"=>$generated_date,"generated_time"=>$generated_time,"last_modification_date"=>$generated_time);
		$amee_web->insert('tickets',$data_arr);
		$id = $amee_web->insert_id();
		
 		$ticket_id=$RandomString.$id;
		$amee_web->where('id',$id);
		$amee_web->update('tickets', array("unique_ticket_id"=>$ticket_id));
		
		$amee_web->insert('tickets_conversations', array("ticket_id"=>$id,"msg_by"=>$msg_by,"university_id"=>$university_id,"department_id"=>$department_id,"problem_msg"=>$message,"msg_date"=>$generated_date,"msg_time"=>$generated_time));
		
			$university_name=$this->config->item('project_name_page_first');
			$product_name=$this->config->item('product_name');
 		
			$multiple_emails = array();	
			if($send_message_to==2){
				$multiple_emails[] = $this->config->item('tech_support_email_address');
			}else{
				$this->db->where('id', '1');
				$qryAdmin = $this->db->get('admin_login'); 
				$rowAdmin = $qryAdmin->row();
				$multiple_emails[] = $rowAdmin->email.'||'.$rowAdmin->first_name;
			}
			
			if(count($multiple_emails)>0){
				$multiple_recipients = implode(',',$multiple_emails);
				$subject = 'Customer support for - '.$product_name;
				$email_message = '<p><strong>'.$GenFromDeptName.'</strong> Department has '.$this->config->item('support_types_array_config')[$type_of_support]['name'].' in '.$university_name.'. Their email is '.$GenFromDeptEmail.'.</p><p><h4>Ticket Id - '.$ticket_id.'</h4></p>'.$message.'<p>Thanks<br />Team '.$university_name.'</p>';
				send_mail_to_multiple($multiple_recipients,$email_message,'','info',$subject);		
			} 
			 
			
		$this->session->set_flashdata('success', 'Your ticket <strong>'.$ticket_id.'</strong> has been generated successfully. Someone will contact you shortly.');
		return 'success||';
	}
	
	public function my_tickets_listing($university_id,$department_id){	
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('deleted_status','0'); 
		$amee_web->where('university_id', $university_id);
		$amee_web->where('department_id', $department_id);	
		$amee_web->order_by('id', 'desc'); 
		$query = $amee_web->get('tickets'); 
		return $query->result();
	}
	
	public function my_ticket_details($unique_ticket_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('unique_ticket_id', $unique_ticket_id);
		$query = $amee_web->get('tickets'); 
		return $query->row();
	}
	
	public function update_user_view_status($id){ 
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('id',$id);
		$amee_web->update('tickets', array("unread_user_status"=>'0'));
	}
	
	public function my_ticket_conversation_data($ticket_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$amee_web->where('deleted_status','0'); 
		$amee_web->where('ticket_id', $ticket_id);	
		$amee_web->order_by('conversation_id', 'asc'); 
		$query = $amee_web->get('tickets_conversations'); 
		return $query->result();
	}
	
	public function comment_entry($msg_by,$department_id,$id,$university_id,$GenFromDeptName,$GenFromDeptEmail){
		$amee_web = $this->load->database('amee_web', TRUE);
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
		$amee_web->where('id',$id);
		$amee_web->update('tickets', $update_1); 
		
		$msg_data_arr=array("ticket_id"=>$id,"msg_by"=>$msg_by,"university_id"=>$university_id,"department_id"=>$department_id,"problem_msg"=>$problem_msg,"msg_date"=>$generated_date,"msg_time"=>$generated_time,"last_modification_date"=>$generated_time);
		$amee_web->insert('tickets_conversations',$msg_data_arr);
		
			$send_message_to = $this->input->post('h_send_message_to');
			$type_of_support = $this->input->post('h_type_of_support');
			$ticket_id = $this->input->post('h_unique_ticket_id');
			$university_name=$this->config->item('project_name_page_first');
			$product_name=$this->config->item('product_name');
 		
			$multiple_emails = array();	
			if($send_message_to==2){
				$multiple_emails[] = $this->config->item('tech_support_email_address');
			}else{
				$this->db->where('id', '1');
				$qryAdmin = $this->db->get('admin_login'); 
				$rowAdmin = $qryAdmin->row();
				$multiple_emails[] = $rowAdmin->email.'||'.$rowAdmin->first_name;
			}
			
			if(count($multiple_emails)>0){
				$multiple_recipients = implode(',',$multiple_emails);
				$subject = 'Customer support reply for - '.$product_name;
				$email_message = '<p><strong>'.$GenFromDeptName.'</strong> Department has '.$this->config->item('support_types_array_config')[$type_of_support]['name'].' in '.$university_name.'. Their email is '.$GenFromDeptEmail.'.</p><p><h4>Ticket Id - '.$ticket_id.'</h4></p>'.$problem_msg.'<p>Thanks<br />Team '.$university_name.'</p>';
				send_mail_to_multiple($multiple_recipients,$email_message,'','info',$subject);		
			} 
			 
			 
		$this->session->set_flashdata('success', 'Your message has been sent successfully!');
	}
	
	public function update_status_ticket($id,$ticket_status){
		$amee_web = $this->load->database('amee_web', TRUE);
		$last_modification_date = time(); 
		$amee_web->where('id',$id);
		$amee_web->update('tickets', array("ticket_status"=>$ticket_status,"last_modification_date"=>$last_modification_date)); 
	}
	
	public function delete_ticket($id,$unique_ticket_id){
		$amee_web = $this->load->database('amee_web', TRUE);
		$last_modification_date = time(); 
		$amee_web->where('id',$id);
		$amee_web->update('tickets', array("deleted_status"=>'1',"last_modification_date"=>$last_modification_date)); 
		$this->session->set_flashdata('success', 'Your ticket <strong>'.$unique_ticket_id.'</strong> has been deleted successfully!');
	}
	
}