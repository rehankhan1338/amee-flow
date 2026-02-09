<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {
 	 
	public function __construct(){ 
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id'));
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		//$this->data['configuration_details'] = $this->Cms_mdl->get_configuration_details();
		$this->data['top_title'] = $this->config->item('product_name'); 
		$this->load->model('Backend/Tickets_mdl');
		$this->data['active_class'] = 'tickets_menu';
		$this->data['title'] = 'Contact Support';
		$this->data['universityId'] = $this->config->item('cv_university_id');
		//$this->data['nofitication_details'] = getNotificationsDetails_ch($this->data['universityId'],'0',$this->session->userdata('dept_id'));
		$activity_name = 'support_tickets';
		time_tracking_management_ch($activity_name); 		
 	}
	
	public function index(){
		$this->data['page_title'] = '';
		$university_id = $this->data['universityId'];
		$this->data['my_tickets_listing']=$this->Tickets_mdl->my_tickets_listing($university_id,$this->session->userdata('dept_id'));
		//echo '<pre>'; print_r($this->data['supplier_users_data']);die;
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/tickets/listing',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);  			
	}
	
	public function update_status(){
		if(isset($_GET['id']) && $_GET['id']!='' && isset($_GET['ticket_status']) && $_GET['ticket_status']!=''){
			$this->Tickets_mdl->update_status_ticket($_GET['id'],$_GET['ticket_status']);
		}  			
	}
	
	public function conversations(){
		$university_id = $this->data['universityId'];		
		$unique_ticket_id = $this->uri->segment(3);
		if(isset($unique_ticket_id) && $unique_ticket_id!=''){
 			
			$this->data['ticket_details'] = $this->Tickets_mdl->my_ticket_details($unique_ticket_id);
			$ticket_id = $this->data['ticket_details']->id;
			if(isset($_GET['u']) && $_GET['u']!='' && $_GET['u']>0){$this->Tickets_mdl->update_user_view_status($ticket_id);}
			
			$this->form_validation->set_rules('problem_message','Message','required');		
			if($this->form_validation->run() == FALSE){
 				$this->data['page_title'] = ''; 	
 				$this->data['ticket_conversations_data'] = $this->Tickets_mdl->my_ticket_conversation_data($ticket_id);
				
				$this->load->view('Frontend/includes/header',$this->data);
				$this->load->view('Frontend/tickets/conversations',$this->data);
				$this->load->view('Frontend/includes/footer',$this->data);
			
			}else{
				$GenFromDeptName = $this->data['dept_session_details']->department_name;
				$GenFromDeptEmail = $this->data['dept_session_details']->email;
				$this->Tickets_mdl->comment_entry('0',$this->session->userdata('dept_id'),$ticket_id,$university_id,$GenFromDeptName,$GenFromDeptEmail);
				redirect(base_url().'tickets/conversations/'.$unique_ticket_id);
			}
					
		}else{
			redirect(base_url().'tickets');
		}		
	}
	
	public function generate(){	
		//echo '<pre>'; print_r($this->data['dept_session_details']);		echo $this->data['dept_session_details']->first_name;die;	
		$this->form_validation->set_rules('type_of_support','type_of_support','required');		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title'] = 'Contact Support';		// <small>- please leave feedback or suggestions.</small>
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/tickets/generate',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data);		
		}else{
			//$RandomString = $this->generateRandomString();		
			//$this->Tickets_mdl->generate_ticket('0',$this->session->userdata('dept_id'),$RandomString);
			//redirect(base_url().'tickets');
		}			
	}
	
	public function generate_ticket(){
		$university_id = $this->data['universityId'];
		$GenFromDeptName = $this->data['dept_session_details']->department_name;
		$GenFromDeptEmail = $this->data['dept_session_details']->email;
		$RandomString = $this->generateRandomString();
		echo $this->Tickets_mdl->generate_ticket('0',$university_id,$this->session->userdata('dept_id'),$RandomString,$GenFromDeptName,$GenFromDeptEmail);
	}
	
	public function generateRandomString($length = 5) {
		$characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return 'AMEE'.$randomString;
	}
	
	public function delete(){		
		$id = $this->uri->segment(3);
		$unique_ticket_id = $this->uri->segment(4);
		if(isset($id) && $id!=''){
			$this->Tickets_mdl->delete_ticket($id,$unique_ticket_id);
		}
		redirect(base_url().'tickets');
	}
	
}