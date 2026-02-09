<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Notifications | Administrator Panel';
		$this->data['active_class']='notifications_menu';   
		$this->load->model('Backend/Notification_mdl');
		$this->data['university_data'] = $this->Notification_mdl->university_data();
 	}
	
	public function index(){		
		$this->data['page_title']='Notifications';
		$this->data['notifications_details']=$this->Notification_mdl->notifications_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/notifications/list',$this->data);
		$this->load->view('Backend/includes/footer');			
	}
	
	public function edit(){		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);		
		$this->form_validation->set_rules('notiTitle','Title','required');				
		if($this->form_validation->run() == FALSE){ 		
			$this->data['page_title']='Notification : : Edit';
			$this->data['notifications_details'] = $this->Notification_mdl->notifications_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/notifications/edit',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{		
			$this->Notification_mdl->edit_notifications($id);
			redirect('admin/notifications');
		}			
 	}
	
	public function delete(){		
		$this->Notification_mdl->delete_notifications($_GET['id']);
		redirect('admin/notifications');
	}
	
	public function add(){		
		$this->form_validation->set_rules('notiTitle','Title','required');		
		if($this->form_validation->run() == FALSE){ 					
			$this->data['page_title']='Notification : : Create'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/notifications/add',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{		
			$this->Notification_mdl->add_notifications();
			redirect('admin/notifications');
		}			
	}
	
	public function ajax_message(){
		$this->data['notifications_details'] = $this->Notification_mdl->notifications_fulldetails($_GET['id']);
		$this->load->view('Backend/notifications/ajax_message',$this->data);
	}
} 