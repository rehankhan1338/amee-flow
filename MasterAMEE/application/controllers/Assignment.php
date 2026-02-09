<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']='Create'; 
 	} 
	
	public function preview(){
		$this->data['preview_title'] = 'Assignment Preview';
		$assignment_code = $this->uri->segment(3);
		$this->data['assignment_code'] = $assignment_code;
		$this->data['previewLnk'] = base_url().'assignment/'.$assignment_code.'?previewSts=1';
		$this->load->view('Frontend/preview',$this->data);
	} 
	
	public function index(){
		$assingment_code = $this->uri->segment(2);
		/*$auth_code = $this->uri->segment(3);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'assingment/error/not_available');	
		}
		$this->data['auth_code'] = $auth_code;*/
		$this->data['assingment_detail'] = $this->Assignment_mdl->assingment_detail_by_code($assingment_code);
		$assingment_id = $this->data['assingment_detail']->id;
		//$this->Assignment_mdl->check_already_take_assingment($assingment_id,$auth_code);
		
		$this->load->view('Frontend/assignment_panel/include/header',$this->data);
		$this->load->view('Frontend/assignment_panel/index',$this->data);
		$this->load->view('Frontend/assignment_panel/include/footer',$this->data); 
 	}
	
	public function startAssignmentEntry(){
		if(isset($_GET['previewSts']) && $_GET['previewSts']==1){
			echo 'success||0';
		}else{
			$assignment_code = $this->input->post('h_assignment_code');
			$cookie_prefix = $this->config->item('cookie_prefix');
			$expire = time() + (3600*24*180);
			
			if(isset($_COOKIE[$cookie_prefix.'assignment_authcode_'.$assignment_code]) && $_COOKIE[$cookie_prefix.'assignment_authcode_'.$assignment_code]!=''){
				$chkAuthCode = $_COOKIE[$cookie_prefix.'assignment_authcode_'.$assignment_code];
			}else{
				$chkAuthCode = '';
			}
			
			$res = $this->Assignment_mdl->startAssignmentEntry($chkAuthCode);
			$resArr = explode('||',$res);
			setcookie($cookie_prefix."assignment_".$assignment_code, $assignment_code, $expire , '/');
			setcookie($cookie_prefix."assignment_authcode_".$assignment_code, $resArr[1], $expire , '/');
			echo $res;
		}
			
 		/*if(isset($_COOKIE[$cookie_prefix.'assignment_'.$assignment_code]) && $_COOKIE[$cookie_prefix.'assignment_'.$assignment_code]!=''){
			echo 'error||Sorry, you already taken this assignment.';
		}else{
			
			$res = $this->Assignment_mdl->startAssignmentEntry();
			$resArr = explode('||',$res);
			setcookie($cookie_prefix."assignment_".$assignment_code, $assignment_code, $expire , '/');
			setcookie($cookie_prefix."assignment_authcode_".$assignment_code, $resArr[1], $expire , '/');
			echo $res;
		}*/
		//echo $this->Assignment_mdl->startAssignmentEntry();
	}
	
	public function questions(){	
		$assingment_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'assingment/error/not_available');	
		}				
		$this->data['auth_code'] = $auth_code;	
		$this->data['assingment_detail'] = $this->Assignment_mdl->assingment_detail_by_code($assingment_code);
		$assingment_id = $this->data['assingment_detail']->id;
		$this->Assignment_mdl->check_already_take_assingment($assingment_id,$auth_code);
		
		$this->data['assingment_questions_detail'] = $this->Assignment_mdl->assingment_questions_detail($assingment_id);
		$this->data['assingment_courses_detail'] = $this->Assignment_mdl->assingment_courses_detail($assingment_id);
		$this->data['assingment_rubric_criterion_detail'] = $this->Assignment_mdl->assingment_rubric_criterion_detail($assingment_id);
		$this->data['assingment_auth_code_detail'] = $this->Assignment_mdl->assingment_auth_code_detail($auth_code);
		
		$this->Assignment_mdl->update_assingment_start_date($assingment_id,$auth_code);
		
		$this->load->view('Frontend/assignment_panel/include/header',$this->data);
		$this->load->view('Frontend/assignment_panel/question',$this->data);
		$this->load->view('Frontend/assignment_panel/include/footer',$this->data); 		
	}
	
	public function answer_save(){
		//echo '<pre>';print_r($_POST);die;
		$this->Assignment_mdl->answer_save();
	}
	
	public function self_rating_save(){
		$this->Assignment_mdl->self_rating_save();
	}
	
	public function apply_finish_status(){
		if(isset($_GET['status'])&& $_GET['status']!=='' && isset($_GET['assingment_id'])&& $_GET['assingment_id']!=='' && isset($_GET['auth_code'])&& $_GET['auth_code']!==''){
			$status = $_GET['status'];
			$assingment_id = $_GET['assingment_id'];
			$auth_code = $_GET['auth_code'];
			$assignment_code = $_GET['assignment_code'];
 			$this->Assignment_mdl->apply_finish_status($status,$assingment_id,$auth_code);
 			if($status==0){
				redirect(base_url().'assignment/questions/'.$assignment_code.'/'.$auth_code);
			}else{							
				redirect(base_url().'assignment/thankyou/'.$assignment_code.'/'.$auth_code);
			}
		}				
	}
	
	public function error(){	
		$error_type = $this->uri->segment(3);
		if($error_type=='notavailable'){
			$this->load->view('Frontend/assignment_panel/error_page/notavailable');
		}
		if($error_type=='deadline_over'){
			$this->load->view('Frontend/assignment_panel/error_page/deadline_over');
		}
		if($error_type=='not_available'){
			$this->load->view('Frontend/assignment_panel/error_page/not_available');
		}
		if($error_type=='already_taken'){
			$this->load->view('Frontend/assignment_panel/error_page/already_taken');
		}
		if($error_type=='deactive'){
			$this->load->view('Frontend/assignment_panel/error_page/deactive');
		}
	}
	
 	public function thankyou(){
 		$assingment_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		if(!isset($auth_code) && $auth_code==''){
			redirect(base_url().'assingment/error/not_available');	
		}				
		$this->data['auth_code'] = $auth_code;	
		$this->data['assingment_detail'] = $this->Assignment_mdl->assingment_detail_by_code($assingment_code);
		$this->data['assingment_auth_code_detail'] = $this->Assignment_mdl->assingment_auth_code_detail($auth_code);
		
		$this->load->view('Frontend/assignment_panel/include/header',$this->data);
		$this->load->view('Frontend/assignment_panel/thankyou',$this->data);
		$this->load->view('Frontend/assignment_panel/include/footer',$this->data); 		
	}
	
	public function document_save(){
		$this->Assignment_mdl->document_save();	
	}
	
	
	
}