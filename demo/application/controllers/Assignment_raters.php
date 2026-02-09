<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_raters extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
 	}  
	
	public function index(){
		$assingment_code = $this->uri->segment(2);
		$auth_code = $this->uri->segment(3);
		if(!isset($auth_code) && $auth_code==''){
			redirect(base_url().'assingment/error/not_available');	
		}
		$this->data['auth_code'] = $auth_code;
		$this->data['assingment_code'] = $assingment_code;
		$this->data['assingment_detail'] = $this->Assignment_raters_mdl->assingment_rater_detail_by_code($assingment_code);
		$assingment_id = $this->data['assingment_detail']->id; 
		
		$this->data['rater_details'] = $this->Assignment_raters_mdl->get_raters_details($auth_code);
		$this->data['assingment_user_listing'] = $this->Assignment_raters_mdl->assingment_user_listing($assingment_id);
		
		$this->load->view('Frontend/assignment_raters_panel/include/header',$this->data);
		$this->load->view('Frontend/assignment_raters_panel/index',$this->data);
		$this->load->view('Frontend/assignment_raters_panel/include/footer',$this->data);
	}
	
	public function rating(){
		$assingment_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'assingment/error/not_available');	
		}
		$this->data['auth_code'] = $auth_code;
		$this->data['assingment_code'] = $assingment_code;
		$this->data['assingment_detail'] = $this->Assignment_raters_mdl->assingment_rater_detail_by_code($assingment_code);
		$assingment_id = $this->data['assingment_detail']->id; 
		$this->data['assingment_id'] = $assingment_id;
		$user_auth_code = $this->uri->segment(5);
		$this->data['user_auth_code'] = $user_auth_code;
		
		$this->data['assingment_user_listing'] = $this->Assignment_raters_mdl->assingment_user_listing($assingment_id);
		$this->data['assignments_user_upload_instruction'] = $this->Assignment_raters_mdl->assignments_user_upload_instruction($user_auth_code,$assingment_id);
		
		$this->data['rater_details'] = $this->Assignment_raters_mdl->get_raters_details($auth_code);
		$this->data['rater_feedback_details'] = $this->Assignment_raters_mdl->get_raters_feedback_details($assingment_id,$auth_code,$user_auth_code);
		
		$this->load->view('Frontend/assignment_raters_panel/include/header',$this->data);
		$this->load->view('Frontend/assignment_raters_panel/rating',$this->data);
		$this->load->view('Frontend/assignment_raters_panel/include/footer',$this->data);
	}
	
	public function save_participant_feedback(){
		$this->Assignment_raters_mdl->save_participant_feedback();
	}
	
	public function save_assingment_raters_name(){
		$this->Assignment_raters_mdl->save_assingment_raters_name();
	}
	
	public function error(){	
		$error_type = $this->uri->segment(3);
		if($error_type=='deadline_over'){
			$this->load->view('Frontend/assignment_raters_panel/error_page/deadline_over');
		}
	}
	
}	