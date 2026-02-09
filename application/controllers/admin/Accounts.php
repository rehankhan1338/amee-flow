<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='University/College/Program Accounts | Administrator Panel';
		$this->data['active_class']='university_menu';   
 	}	
	
	public function index(){		
		$this->data['page_title']='University/College/Program Accounts';
		$this->data['university_details']=$this->Accounts_mdl->university_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/university/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
	
	public function add(){
		$this->form_validation->set_rules('university_name','Accounts Name','required');	 
		$this->form_validation->set_rules('subdomain_name','Subdomain Name','required');
		$this->form_validation->set_rules('first_name','First Name','required'); 
		$this->form_validation->set_rules('last_name','Larst Name','required'); 
		$this->form_validation->set_rules('email','Email Id','trim|required|valid_email|xss_clean'); 
		$this->form_validation->set_rules('phone','Phone','required'); 
		$this->form_validation->set_rules('address','Address','required'); 
		$this->form_validation->set_rules('state','State','required'); 
		$this->form_validation->set_rules('city','City','required'); 
		$this->form_validation->set_rules('zip_code','Zip Code','required');
		//$this->form_validation->set_rules('popup_message','Popup Message','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='University/College/Program Account : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/university/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Accounts_mdl->add_university();
		}
	}
	
	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('university_name','Accounts Name','required');	 
		$this->form_validation->set_rules('first_name','First Name','required'); 
		$this->form_validation->set_rules('last_name','Larst Name','required'); 
		$this->form_validation->set_rules('email','Email Id','trim|required|valid_email|xss_clean'); 
		$this->form_validation->set_rules('phone','Phone','required'); 
		$this->form_validation->set_rules('address','Address','required'); 
		$this->form_validation->set_rules('state','State','required'); 
		$this->form_validation->set_rules('city','City','required'); 
		$this->form_validation->set_rules('zip_code','Zip Code','required');
		$this->form_validation->set_rules('popup_message','Popup Message','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='University/College/Program Account : : Edit';
			$this->data['university_details'] = $this->Accounts_mdl->university_detail_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/university/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Accounts_mdl->edit_university($id);
		}
 	}
	
	
	public function delete(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/accounts');
		}
		$this->Accounts_mdl->delete_university($_GET['id']);
		redirect('admin/accounts');
	}	
	
	public function sendmail(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/accounts');
		}
		$this->Accounts_mdl->sendmail($_GET['id']);
		redirect('admin/accounts');
	}
	
	
} 