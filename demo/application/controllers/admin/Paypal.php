<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');   
		 
 	}
	
	public function index(){
		
		$this->data['title']='Sub Admins | Administrator Panel';
		$this->data['active_class']='system_setting';
		$this->data['page_title']='Paypal';
		$this->data['paypal_details']=$this->Settings_mdl->paypal_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/settings/paypal/list',$this->data);
		$this->load->view('Backend/includes/footer');
			
	}
	
	public function edit(){
		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('showcase_paypal_id','Paypal IPN','required');
		$this->form_validation->set_rules('showcase_amount','Amount','required'); 	 
		
		if($this->form_validation->run() == FALSE){ 
		
			$this->data['title']='Sub Admins | Administrator Panel';
			$this->data['active_class']='system_setting';
			$this->data['page_title']='Paypal : : Edit';
			$this->data['showcase_paypal_setting'] = $this->Settings_mdl->paypal_full_details($id);
			 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/settings/paypal/edit',$this->data);
			$this->load->view('Backend/includes/footer');
		
		}else{
		
			$this->Settings_mdl->manage_paypal_setting($id);
			redirect('admin/paypal/edit/'.$id);
		}
			
 	}	
	
} 