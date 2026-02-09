<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['sessionDetailsArr'] = chkSystemAdminLoggedIn($this->session->userdata('AFSESS_UNIADMINID'));		
		$this->data['success_msg'] = $this->session->flashdata('success');
		$this->data['error_msg'] = $this->session->flashdata('error');
		$this->load->model('Backend/Tickets_mdl');
		$this->data['active_class'] = 'support-menu';
		$this->data['title'] = 'Contact Support';
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
		$this->data['createdBy'] = 2;
		$this->data['createdById'] = $uniAdminId;
		$this->data['ticketSecBaseUrl'] = base_url().$this->config->item('system_directory_name');
		$this->data['msg_by'] = 0;
 	}
	
	public function index(){
		$uniAdminId = $this->data['sessionDetailsArr']['uniAdminId'];
			
		$this->data['pageTitle'] = 'Contact Support';
		$this->data['active_page_menu']='1'; 
		$this->data['my_tickets_listing']=$this->Tickets_mdl->my_tickets_listing($this->data['createdById'],$this->data['createdBy']);
		//echo '<pre>'; print_r($this->data['supplier_users_data']);die;
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('Frontend/tickets/listing',$this->data);
		$this->load->view('Backend/includes/footer',$this->data); 			
	}	
	
	public function generate(){
		$this->data['pageTitle'] = 'Contact Support <small>- please leave feedback or suggestions.</small>';		
		$this->load->view('system-admin/includes/header',$this->data);
		$this->load->view('Frontend/tickets/generate',$this->data);
		$this->load->view('Backend/includes/footer',$this->data);			
	}
	
	public function conversations(){		
		$unique_ticket_id = $this->uri->segment(4);
		if(isset($unique_ticket_id) && $unique_ticket_id!=''){
 			
			$this->data['ticket_details'] = $this->Tickets_mdl->my_ticket_details($unique_ticket_id);
			$ticket_id = $this->data['ticket_details']->id;
			if(isset($_GET['u']) && $_GET['u']!='' && $_GET['u']>0){$this->Tickets_mdl->update_user_view_status($ticket_id);}
			
				$this->data['pageTitle'] = 'Contact Support'; 	
				$this->data['ticket_conversations_data'] = $this->Tickets_mdl->my_ticket_conversation_data($ticket_id);
				$this->data['active_page_menu']='1'; 
				$this->load->view('system-admin/includes/header',$this->data);
				$this->load->view('Frontend/tickets/conversations',$this->data);
				$this->load->view('Backend/includes/footer',$this->data);
					
		}else{
			redirect($this->data['ticketSecBaseUrl'].'tickets');
		}		
	}
	
	// public function create_suggestion(){		
	// 	$this->data['active_page_menu']='2'; 
	// 	$this->data['pageTitle'] = 'Welcome to our suggestion box! <br><small>We use your feedback to improve our services for Bravo users like you. </small>';		
	// 	$this->load->view('system-admin/includes/header',$this->data);
	// 	$this->load->view('Frontend/tickets/create_your_suggestion',$this->data);
	// 	$this->load->view('Backend/includes/footer',$this->data);	
	// }
	
	// public function sendSuggestion(){	
	// 	echo $this->Tickets_mdl->sendSuggestion();
	// }
	
}