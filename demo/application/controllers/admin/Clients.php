<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Client Profile | Administrator Panel';
		$this->data['active_class']='client_profile_menu';   
 	}
	
	public function index(){		
		$this->data['page_title']='Client Profile';
		$this->data['client_profile_details']=$this->Client_profile_mdl->client_profile_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/client_profile/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function add(){	 
		$this->form_validation->set_rules('first_name','First Name','required'); 
		$this->form_validation->set_rules('last_name','Larst Name','required'); 
		$this->form_validation->set_rules('email','Email Id','trim|required|valid_email|xss_clean'); 
		$this->form_validation->set_rules('phone','Phone','required'); 
		$this->form_validation->set_rules('address','Address','required'); 
		$this->form_validation->set_rules('state','State','required'); 
		$this->form_validation->set_rules('city','City','required'); 
		$this->form_validation->set_rules('zip_code','Zip Code','required');
		$this->form_validation->set_rules('organization_name','Organization Name','required');
		$this->form_validation->set_rules('organization_type','Organization Type','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Client_profile : : Add'; 
			$this->data['master_organization_type'] = $this->Master_helper_mdl->master_organization_type();
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/client_profile/add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Client_profile_mdl->add_client_profile();
		}
	}
	
	public function edit(){
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('first_name','First Name','required'); 
		$this->form_validation->set_rules('last_name','Larst Name','required'); 
		$this->form_validation->set_rules('email','Email Id','trim|required|valid_email|xss_clean'); 
		$this->form_validation->set_rules('phone','Phone','required'); 
		$this->form_validation->set_rules('address','Address','required'); 
		$this->form_validation->set_rules('state','State','required'); 
		$this->form_validation->set_rules('city','City','required'); 
		$this->form_validation->set_rules('zip_code','Zip Code','required');
		$this->form_validation->set_rules('organization_name','Organization Name','required');
		$this->form_validation->set_rules('organization_type','Organization Type','required');
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['page_title']='Client_profile : : Edit';
			$this->data['master_organization_type'] = $this->Master_helper_mdl->master_organization_type();
			$this->data['client_profile_details'] = $this->Client_profile_mdl->client_profile_detail_row($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/client_profile/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Client_profile_mdl->edit_client_profile($id);
		}
 	}
 	
	public function delete(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/clients');
		}
		$this->Client_profile_mdl->delete_client_profile($_GET['id']);
		redirect('admin/clients');
	}
	
	
} 