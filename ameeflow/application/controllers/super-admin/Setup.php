<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
 	 
	function __construct(){
 		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='System Setting | Administrator Panel';
		$this->data['active_class']='master_menu';
		$last_segment = $this->uri->segment(3);
		$this->data['last_segment']=$last_segment;
		if($last_segment=='wards'){
			$this->data['section_status']=2;
			$this->data['section_status_slug']='wards';
			$this->data['section_status_label']='Ward';
		}else if($last_segment=='zones'){
			$this->data['section_status']=1;
			$this->data['section_status_slug']='zones';
			$this->data['section_status_label']='Zone';
		}else if($last_segment=='addresses'){
			$this->data['section_status']=3;
			$this->data['section_status_slug']='addresses';
			$this->data['section_status_label']='Address';
		}else if($last_segment=='brands'){
			$this->data['section_status']=4;
			$this->data['section_status_slug']='brands';
			$this->data['section_status_label']='Brand';
		}   
  	}
	
	public function listing(){	
 		$this->data['page_title']=ucwords($this->data['section_status_slug']);
		$this->data['setup_masters_details']=$this->Setup_mdl->setup_masters_details($this->data['section_status']);
		if($this->data['last_segment']=='wards'){
			$this->data['fetchZonesArr']=$this->Setup_mdl->fetchZonesArr();
		}
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/setup/list',$this->data);
		$this->load->view('Backend/includes/footer');
 	}
	
	public function edit(){
 		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
 		$this->form_validation->set_rules('txt_name','Name','required');	 
 		if($this->form_validation->run() == FALSE){ 
 			$this->data['page_title']=ucwords($this->data['section_status_slug']).' : : Edit';
			$this->data['setup_masters_details'] = $this->Setup_mdl->setup_masters_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/setup/edit',$this->data);
			$this->load->view('Backend/includes/footer');
 		}else{
 			$this->Setup_mdl->edit_setup_masters($id,$this->data['section_status'],$this->data['section_status_label'],$this->data['section_status_slug']);
			redirect(base_url().$this->config->item('admin_directory_name').'setup/listing/'.strtolower($this->data['section_status_slug']));
		}
  	}
	
	public function delete(){
 		$id = $this->uri->segment('5');
		$this->Setup_mdl->delete_setup_masters($id,$this->data['section_status_label']);
		redirect(base_url().$this->config->item('admin_directory_name').'setup/listing/'.strtolower($this->data['section_status_slug']));
	}
	
	public function add(){
 		$this->form_validation->set_rules('txt_name','Name','required');	 
 		if($this->form_validation->run() == FALSE){ 
 			$this->data['page_title']=ucwords($this->data['section_status_slug']).' : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/setup/add',$this->data);
			$this->load->view('Backend/includes/footer');
 		}else{
 			$this->Setup_mdl->add_setup_masters($this->data['section_status'],$this->data['section_status_label'],$this->data['section_status_slug']);
			redirect(base_url().$this->config->item('admin_directory_name').'setup/listing/'.strtolower($this->data['section_status_slug']));
		}
 	}
} 