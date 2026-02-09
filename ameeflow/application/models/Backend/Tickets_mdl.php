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

	public function getStudentName($id){	
		$this->db->select('fullName');
		$this->db->where('userId',$id); 
		$query = $this->db->get('users'); 
		$row = $query->row();
		return $row->fullName;
	}

	public function getFacultyName($id){	
		$this->db->select('facultyName');
		$this->db->where('facultyId',$id); 
		$query = $this->db->get('faculty'); 
		$row = $query->row();
		return $row->facultyName;
	}
	
	public function getSuggestionsArr(){	
		$this->db->select('suggestionId, satisfiedOptionId');
		$this->db->where('deletedSts','0'); 
		$query = $this->db->get('suggestions'); 
		return $query->result_array();
	}
	
	public function getSuggestionsList(){	
		$this->db->select('s.*, u.fullName, u.email');
		$this->db->from('suggestions as s');
 		$this->db->where('s.deletedSts', '0');
		$this->db->order_by('s.suggestionId', 'desc');
		$this->db->join('users as u', 'u.userId = s.registration_id', 'INNER');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function sendSuggestion(){
 		$userId = $this->input->post('hRegId');
		$givenSuggestionMsg = $this->input->post('givenSuggestion');
		$satisfiedOptionId = $this->input->post('satisfiedOption');
		$contactMeSts = $this->input->post('contactMeSts');
		$createdOn = time();
		$this->db->insert('suggestions', array("userId"=>$userId,"givenSuggestionMsg"=>$givenSuggestionMsg,"satisfiedOptionId"=>$satisfiedOptionId,"contactMeSts"=>$contactMeSts,"createdOn"=>$createdOn));
		return 'success';	
	}
	
	public function delete_suggestion($id){ 
		$this->db->where('suggestionId',$id);
		$this->db->update('suggestions', array("deletedSts"=>'1'));
		$this->session->set_flashdata('success', 'Deleted successfully!');
	}
	
	public function update_admin_view_status($id){ 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("unread_admin_status"=>'0'));
	}
	
	public function admin_tickets_listing($admin_type,$role_id){
		// $this->db->select('unique_ticket_id, id, tickets.createdById, tickets.createdBy, msg_by, unread_admin_status, unread_user_status, tickets.last_modification_date, generated_time, conversation_cnt, ticket_status, type_of_support, send_message_to');
		// $this->db->from('tickets');
		// $this->db->join('users as u', 'u.userId = tickets.createdById');
		/*if(isset($admin_type) && $admin_type!='super_admin' && isset($role_id) && $role_id!='' && $role_id>0){
			$this->db->where('tickets.send_message_to',$role_id);
		}*/
		$this->db->where('deleted_status','0');
		$this->db->order_by('unread_admin_status, id', 'desc');
		$query = $this->db->get('tickets');
		return $query->result();
	} 

	public function openTickets(){
		$this->db->where('deleted_status','0');
		$this->db->where('ticket_status','0');
		$query = $this->db->get('tickets');
		return $query->num_rows();
	} 

	public function closedTickets(){
		$this->db->where('deleted_status','0');
		$this->db->where('ticket_status','1');
		$query = $this->db->get('tickets');
		return $query->num_rows();
	} 

	public function generateTicketRandomString($length = 5) {
		$characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function generate_ticket(){
		$ticketSecBaseUrl = $this->input->post('ticketSecBaseUrl');
		$msg_by = $this->input->post('msg_by');
		$createdBy = $this->input->post('createdBy');		
		$createdById = trim($this->input->post('createdById'));
		$RandomString = $this->generateTicketRandomString();

		$type_of_support = $this->input->post('type_of_support');		
		$message = trim($this->input->post('ticketMsgContent'));
		//$send_message_to = $this->input->post('fs_send_message_to');
		$send_message_to = 0;
		$ip_address=$_SERVER['REMOTE_ADDR'];			
		$generated_date = strtotime(date('Y-m-d'));
		$generated_time = time();
		
		$data_arr=array("msg_by"=>$msg_by,"createdBy"=>$createdBy,"createdById"=>$createdById,"type_of_support"=>$type_of_support,"send_message_to"=>$send_message_to,"generated_date"=>$generated_date,"generated_time"=>$generated_time,"last_modification_date"=>$generated_date);
		$this->db->insert('tickets',$data_arr);
		$id = $this->db->insert_id();
		
 		$ticket_id=$RandomString.$id;
		$update_ticket_id = array("unique_ticket_id"=>$ticket_id);
		$this->db->where('id',$id);
		$this->db->update('tickets',$update_ticket_id);
		
		$msg_data_arr=array("ticket_id"=>$id,"msg_by"=>$msg_by,"createdById"=>$createdById,"problem_msg"=>$message,"msg_date"=>$generated_date,"msg_time"=>$generated_time);
		$this->db->insert('tickets_conversations',$msg_data_arr);
		$product_name=$this->config->item('product_name');
		
		$adminEmailArr = explode('||',$this->config->item('admin_email_sent_to'));			
		$subject = 'Customer support for - '.$product_name;
		if($createdBy==1){
			$this->db->where('userId',$createdById);
			$qryUser = $this->db->get('users');
			$uDetails = $qryUser->row_array();
			$tName = $uDetails['userName'];
			$tEmail = $uDetails['userEmail'];
			$reLnk = base_url().'tickets';
		}else{
			$this->db->where('uniAdminId',$createdById);
			$qryUser = $this->db->get('university_admins');
			$uDetails = $qryUser->row_array();
			$tName = $uDetails['fullName'];
			$tEmail = $uDetails['email'];
			$reLnk = base_url().$this->config->item('system_directory_name').'tickets';
		}
		$email_message = '<p><strong>'.$tName.'</strong> has '.$this->config->item('support_types_array_config')[$type_of_support]['name'].' in '.$product_name.'. Their email is '.$tEmail.'.</p><p><h4>Ticket Id - '.$ticket_id.'</h4></p>'.$message.'<p>Thanks<br />Team '.$product_name.'</p>';
		send_mail($adminEmailArr[0],$email_message,$adminEmailArr[1],'info',$subject);	
			
		$this->db->where('id', 13);
		$etQry = $this->db->get('email_templates');
		$etDetails = $etQry->row();
		$subject = $etDetails->subject;	
		// $subject = str_replace('{ticketId}',$ticket_id,$etDetails->subject);
		$message = str_replace('{name}',$tName,$etDetails->message);
		$message = str_replace('{link}',$reLnk,$message);
		send_mail($tEmail,$message,$tName,'info',$subject); 
		
		$this->session->set_flashdata('success', 'Your ticket <strong>'.$ticket_id.'</strong> has been generated successfully. Someone will contact you shortly.');
		return 'success||'.$ticketSecBaseUrl.'tickets';
	}
	
	public function my_tickets_listing($createdById,$createdBy){	
		$this->db->where('deleted_status','0'); 
		$this->db->where('createdById', $createdById);	
		$this->db->where('createdBy', $createdBy);
		$this->db->order_by('id', 'desc'); 
		$query = $this->db->get('tickets'); 
		return $query->result();
	}
	
	public function my_ticket_details($unique_ticket_id){
		$this->db->where('unique_ticket_id', $unique_ticket_id);
		$query = $this->db->get('tickets'); 
		return $query->row();
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
	
	public function comment_entry(){
		$msg_by = $this->input->post('msg_by');
		$id = $this->input->post('h_ticketId');
		$unique_ticket_id = $this->input->post('h_ticketUniqueId');
		$createdById = $this->input->post('createdById');
		$ticketSecBaseUrl = $this->input->post('ticketSecBaseUrl');

		$problem_msg = $this->input->post('conMsgContent');
		$ip_address = $_SERVER['REMOTE_ADDR'];			
		$generated_date = strtotime(date('Y-m-d'));
		$generated_time = time(); 
		
		$conversation_cnt = $this->input->post('h_conversation_cnt')+1; 
		if($msg_by==0){
			$update_1 = array("unread_admin_status"=>'1',"conversation_cnt"=>$conversation_cnt,"last_modification_date"=>$generated_date);
		}else{
			$update_1 = array("unread_user_status"=>'1',"unread_admin_status"=>'0',"conversation_cnt"=>$conversation_cnt,"last_modification_date"=>$generated_date);
		}
		$this->db->where('id',$id);
		$this->db->update('tickets', $update_1); 
		
		$msg_data_arr=array("ticket_id"=>$id,"msg_by"=>$msg_by,"createdById"=>$createdById,"problem_msg"=>$problem_msg,"msg_date"=>$generated_date,"msg_time"=>$generated_time);
		$this->db->insert('tickets_conversations',$msg_data_arr);
		
		if($msg_by==1){

			$createdBy = $this->input->post('createdBy');
			if($createdBy==1){
				$this->db->select('userName, userEmail');
				$this->db->where('userId', $createdById);
				$query = $this->db->get('users'); 
				$rdata = $query->row();
				$tName = $rdata->userName;
				$tEmail = $rdata->userEmail;
			}else{
				$this->db->select('fullName, email');
				$this->db->where('uniAdminId', $createdById);
				$query = $this->db->get('university_admins'); 
				$rdata = $query->row();
				$tName = $rdata->fullName;
				$tEmail = $rdata->email;
			}
		
			$product_name=$this->config->item('product_name');			
 			$subject = 'Reply from customer support of - '.$product_name;
			$email_message = '<p>Hi '.$tName.'</p><p><h4>Ticket Id - '.$unique_ticket_id.'</h4></p>'.$problem_msg.'<p>Thanks<br />Team '.$product_name.'</p>';
			send_mail($tEmail,$email_message,$tName,'info',$subject);	
		}
		
		$this->session->set_flashdata('success', 'Your message has been sent successfully!');
		return 'success||'.$ticketSecBaseUrl.'tickets/conversations/'.$unique_ticket_id;
	}
	
	public function update_status_ticket($id,$ticket_status){
		$last_modification_date = strtotime(date('Y-m-d')); 
		$this->db->where('id',$id);
		$this->db->update('tickets', array("ticket_status"=>$ticket_status,"last_modification_date"=>$last_modification_date)); 		

		if(isset($_GET['callFrom']) && $_GET['callFrom']!='' && $_GET['callFrom']=='admin'){
			$this->db->where('id',$id);
			$this->db->update('tickets', array("unread_admin_status"=>'0')); 		
		}
	}
	
	public function delete_ticket($utId){
		$last_modification_date = strtotime(date('Y-m-d')); 
		$this->db->where('unique_ticket_id',$utId);
		$this->db->update('tickets', array("deleted_status"=>'1',"last_modification_date"=>$last_modification_date)); 
		$this->session->set_flashdata('success', 'Your ticket <strong>'.$utId.'</strong> has been deleted successfully!');
	}
	
}