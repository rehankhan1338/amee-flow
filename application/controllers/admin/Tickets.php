<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tickets extends CI_Controller {
 	 
	public function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['active_class']='tickets_menu';   
		$this->data['title']='Tickets';	
		$this->load->model('Backend/Tickets_mdl');
 	}
	
	public function index(){
		$this->data['page_title']='Contact Support : : Tickets';
		$this->data['my_tickets_listing']=$this->Tickets_mdl->admin_tickets_listing();
		//echo '<pre>'; print_r($this->data['my_tickets_listing']);die;
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/tickets/list',$this->data);
		$this->load->view('Backend/includes/footer',$this->data);  			
	}
	
	public function update_status(){
		if(isset($_GET['id']) && $_GET['id']!='' && isset($_GET['ticket_status']) && $_GET['ticket_status']!=''){
			$this->Tickets_mdl->update_status_ticket($_GET['id'],$_GET['ticket_status'],$_GET['deptFname'],$_GET['deptEmail'],$_GET['unique_ticket_id']);
		}  			
	}
	
	public function conversations(){		
		$unique_ticket_id = $this->uri->segment(4);
		if(isset($unique_ticket_id) && $unique_ticket_id!=''){
			$this->data['ticket_details'] = $this->Tickets_mdl->my_ticket_details($unique_ticket_id);
  			
			$ticket_id = $this->data['ticket_details']->id;
			$university_id = $this->data['ticket_details']->university_id;
			$department_id = $this->data['ticket_details']->department_id;
			$this->data['university_details'] = $this->Tickets_mdl->get_university_details($university_id);
			$this->data['department_details'] = $this->Tickets_mdl->get_department_details($department_id);
			//echo '<pre>'; print_r($this->data['department_details']);die;
			
			if(isset($_GET['u']) && $_GET['u']!='' && $_GET['u']>0){$this->Tickets_mdl->update_admin_view_status($ticket_id);}
				
			$this->form_validation->set_rules('problem_message','Message','required');		
			if($this->form_validation->run() == FALSE){
			
				$this->data['page_title']='Contact Support : : Conversations : : Ticket - '.$unique_ticket_id; 
 				$ticket_conversations_data = $this->Tickets_mdl->my_ticket_conversation_data($ticket_id);
				$this->data['ticket_conversations_data'] = $ticket_conversations_data;
				$this->data['supplier_users_data'] = array();			 
				$this->load->view('Backend/includes/header',$this->data);
				$this->load->view('Backend/tickets/conversations',$this->data);
				$this->load->view('Backend/includes/footer');	
			
			}else{
				$this->Tickets_mdl->comment_entry('1',$this->session->userdata('userid'),$ticket_id,$university_id);
				redirect(base_url().$this->config->item('admin_directory_name').'/tickets/conversations/'.$unique_ticket_id);
			}
				
		}else{
			redirect(base_url().$this->config->item('admin_directory_name').'/tickets');
		}		
	}
	
	public function generate(){		
		$this->form_validation->set_rules('problem_message','Message','required');		
		if($this->form_validation->run() == FALSE){ 
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/tickets/generate',$this->data);
			$this->load->view('Frontend/includes/footer');		
		}else{
			$RandomString = $this->generateRandomString();		
			$this->Tickets_mdl->generate_ticket('0',$this->session->userdata('me_sess_user_id'),$this->data['user_supplier_details']->supplier_id,$RandomString);
			redirect(base_url().$this->config->item('admin_directory_name').'/tickets');
		}			
	}
	
	public function generateRandomString($length = 5) {
		$characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return 'MST'.$randomString;
	}
	
}