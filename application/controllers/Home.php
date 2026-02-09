<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error'); 
	 
		$this->data['ameeFlowLnk'] = 'https://www.assessmentmadeeasy.com/ameeflow/signin';
		$this->data['bravoLnk'] = 'https://www.bravofolio.com/';
 	 
 	}
	
	public function index(){
		$this->data['title']='AMEE - Assessment Made Easy Everyday';
		$this->load->view('Frontend/home/header',$this->data);
		$this->load->view('Frontend/home/view',$this->data);
		$this->load->view('Frontend/home/footer',$this->data);
	}

	public function pricing(){
		$this->data['title']='AMEE Flow Pricing Calculator';
		$this->load->view('Frontend/home/header',$this->data);
		$this->load->view('Frontend/home/calculator',$this->data);
		$this->load->view('Frontend/home/footer',$this->data);
	}
	
	public function about_us(){
 		$this->load->view('Frontend/includes/top_header',$this->data);
		$this->load->view('Frontend/pages/about_us',$this->data);
		$this->load->view('Frontend/includes/bottom_footer',$this->data);
	}
	
	public function accreditation(){
		$this->data['accreditation_list'] = $this->Cms_mdl->accreditation_list(); 
		$this->load->view('Frontend/includes/top_header',$this->data);
		$this->load->view('Frontend/pages/accreditation',$this->data);
		$this->load->view('Frontend/includes/bottom_footer',$this->data);
	}
	
	public function leadership_team(){
		$this->load->view('Frontend/includes/top_header',$this->data);
		$this->load->view('Frontend/pages/leadership_team',$this->data);
		$this->load->view('Frontend/includes/bottom_footer',$this->data);
	}
	
	public function terms_conditions(){
		$this->load->view('Frontend/includes/top_header',$this->data);
		$this->load->view('Frontend/pages/terms_conditions',$this->data);
		$this->load->view('Frontend/includes/bottom_footer',$this->data);
	}
	
	public function product_updates(){
		$this->data['product_updates_list'] = $this->Cms_mdl->product_updates_list(); 
		$this->load->view('Frontend/includes/top_header',$this->data);
		$this->load->view('Frontend/pages/product_updates',$this->data);
		$this->load->view('Frontend/includes/bottom_footer',$this->data);
	}
	
	 
} 