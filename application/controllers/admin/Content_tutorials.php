<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_tutorials extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='University | Administrator Panel';
		$this->data['active_class']='content_tutorials_menu';   
 	}	
	
	public function heading(){	
		if(isset($_GET['as'])&& $_GET['as']=='1'){
			$this->data['page_title']='Content Tutorials : : Department Help';
		}else if(isset($_GET['as'])&& $_GET['as']=='2'){
			$this->data['page_title']='Content Tutorials : : Admin Help';
		}
		$this->data['content_tutorials_heading_details']=$this->Content_tutorials_mdl->content_tutorials_heading_details($_GET['as']);
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/content_tutorials/heading_list',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
	
	public function heading_add(){
		if(isset($_GET['as'])&& $_GET['as']=='1'){
			$this->data['page_title']='Content Tutorials : : Department Help : : Add';
		}else if(isset($_GET['as'])&& $_GET['as']=='2'){
			$this->data['page_title']='Content Tutorials : : Admin Help : : Add';
		}
		
		$this->form_validation->set_rules('heading','Heading','required');
				
		if($this->form_validation->run() == FALSE){ 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/content_tutorials/heading_add',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Content_tutorials_mdl->heading_add();
		}
	}	
		
	public function heading_edit(){
		if(isset($_GET['as'])&& $_GET['as']=='1' && isset($_GET['hid'])&& $_GET['hid']!=''){
			$this->data['page_title']='Content Tutorials : : Department Help : : Edit';
		}else if(isset($_GET['as'])&& $_GET['as']=='2' && isset($_GET['hid'])&& $_GET['hid']!=''){
			$this->data['page_title']='Content Tutorials : : Admin Help : : Edit';
		}else if(isset($_GET['hid'])&& $_GET['hid']==''){
			redirect('admin/content/tutorials/heading?as='.$_GET['as']);	
		}
		
		$this->form_validation->set_rules('heading','Heading','required');	 	
		
		if($this->form_validation->run() == FALSE){ 
			$this->data['content_tutorials_heading_rowdetails'] = $this->Content_tutorials_mdl->content_tutorials_heading_rowdetails($_GET['hid']);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/content_tutorials/heading_edit',$this->data);
			$this->load->view('Backend/includes/footer');
		}else{
			$this->Content_tutorials_mdl->heading_edit($_GET['hid']);
		}
 	}
 	
 	
 	public function heading_delete(){
		if(isset($_GET['id'])&& $_GET['id']=='' && isset($_GET['as'])&& $_GET['as']==''){
			redirect('admin/content/tutorials/heading');
		}
		$this->Content_tutorials_mdl->heading_delete($_GET['id'],$_GET['as']);
	}	

	
	public function index(){
		if(isset($_GET['as'])&& $_GET['as']=='1'){
			$this->data['page_title']='Content Tutorials : : Department Help'; 
		}else if(isset($_GET['as'])&& $_GET['as']=='2'){
			$this->data['page_title']='Content Tutorials : : Admin Help';
		}	
		
		if(isset($_GET['hid']) && $_GET['hid']!=''){
			$this->data['content_tutorials_sub_heading_details']=$this->Content_tutorials_mdl->content_tutorials_sub_heading_details($_GET['hid']);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/content_tutorials/list',$this->data);
			$this->load->view('Backend/includes/footer');			
		}
	}
		
	public function add(){
		if(isset($_GET['as'])&& $_GET['as']=='1'){
			$this->data['page_title']='Content Tutorials : : Department Help : : Add'; 
		}else if(isset($_GET['as'])&& $_GET['as']=='2'){
			$this->data['page_title']='Content Tutorials : : Admin Help : : Add';
		}
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/content_tutorials/add',$this->data);
		$this->load->view('Backend/includes/footer');
	}	
	
	public function add_sub_heading(){
		$this->Content_tutorials_mdl->add_sub_heading();
	}	
	
	public function edit(){
		if(isset($_GET['as'])&& $_GET['as']=='1'){
			$this->data['page_title']='Content Tutorials : : Department Help : : Edit'; 
		}else if(isset($_GET['as'])&& $_GET['as']=='2'){
			$this->data['page_title']='Content Tutorials : : Admin Help : : Edit';
		}
		
		if(isset($_GET['shid']) && $_GET['shid']!='' && isset($_GET['hid']) && $_GET['hid']!=''){			
			$this->data['content_tutorials_sub_heading_rowdetails'] = $this->Content_tutorials_mdl->content_tutorials_sub_heading_rowdetails($_GET['shid']);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/content_tutorials/edit',$this->data);
			$this->load->view('Backend/includes/footer');		
		}
 	}	
 	
 	public function update_sub_heading(){
		$this->Content_tutorials_mdl->update_sub_heading();
 	} 	
		
	public function delete(){
		if(isset($_GET['id'])&& $_GET['id']!='' && isset($_GET['hid'])&& $_GET['hid']!='' && isset($_GET['as'])&& $_GET['as']!=''){
			$this->Content_tutorials_mdl->delete_sub_heading($_GET['id'],$_GET['hid'],$_GET['as']);
		}
	}	
	
	public function sendmail(){
		if(isset($_GET['id'])&& $_GET['id']==''){
			redirect('admin/university');
		}
		$this->Content_tutorials_mdl->sendmail($_GET['id']);
		redirect('admin/university');
	}
	
	
} 