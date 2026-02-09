<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_form extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();  
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='create_menu';
		$this->data['title']=''; 
		$this->data['page_title']='';
		$this->data['action_menu']='';
		$this->load->library('pagination');
	}
	
	public function preview(){
		$this->data['preview_title'] = 'Survey Preview';
		$survey_code = $this->uri->segment(4);
		$this->data['survey_code'] = $survey_code;
		$this->data['previewLnk'] = base_url().'survey/form/'.$survey_code.'?previewSts=1';
		//$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$this->load->view('Frontend/preview',$this->data);
	}
	
	public function index(){
		$survey_code = $this->uri->segment(3);
		/*$chkSeg = $this->uri->segment(3);
		if($chkSeg=='preview'){
			$survey_code = $this->uri->segment(4);
			$this->data['previewSts'] = 1;
		}else{
			$survey_code = $chkSeg;
			$this->data['previewSts'] = 0;
		}*/
		
		$survey_detail = $this->Survey_form_mdl->survey_detail_by_code($survey_code);		
		if(isset($survey_detail->survey_id) && $survey_detail->survey_id!=''){
		
			$this->data['survey_detail'] = $survey_detail;
			/*$survey_id = $this->data['survey_detail']->survey_id;
			$this->Survey_form_mdl->check_already_take_survey($survey_id,$auth_code);
			$is_introduction_msg = $this->data['survey_detail']->is_introduction_msg;
			if($is_introduction_msg==1){
				redirect(base_url().'survey/form/questions/'.$survey_code.'/'.$auth_code);
			}*/
			$this->data['question_bar'] = '0';
			$this->load->view('Frontend/survey_panel/include/header',$this->data);
			$this->load->view('Frontend/survey_panel/index',$this->data);
			$this->load->view('Frontend/survey_panel/include/footer',$this->data);
		}else{		 			
			redirect(base_url().'survey/error/surveynotavailable');	
		}
	}
	
	public function start_survey_entry(){		 
		 if(isset($_GET['previewSts']) && $_GET['previewSts']==1){
			echo 'success||0';
		}else{
			$survey_code = $this->input->post('h_survey_code');
			$cookie_prefix = $this->config->item('cookie_prefix');
			$expire = time() + (3600*24*60);
			if(isset($_COOKIE[$cookie_prefix.'survey_'.$survey_code]) && $_COOKIE[$cookie_prefix.'survey_'.$survey_code]!=''){
				echo 'error||Sorry, you already taken this survey.';
			}else{
				setcookie($cookie_prefix."survey_".$survey_code, $survey_code, $expire , '/');
				echo $this->Survey_form_mdl->start_survey_entry();
			}
		} 
	}
	
	
	/*public function index(){
		$survey_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'survey/error/not_available');	
		}
		$this->data['auth_code'] = $auth_code;
		$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$survey_id = $this->data['survey_detail']->survey_id;
		$this->Survey_form_mdl->check_already_take_survey($survey_id,$auth_code);
		$is_introduction_msg = $this->data['survey_detail']->is_introduction_msg;
 		if($is_introduction_msg==1){
			redirect(base_url().'survey/form/questions/'.$survey_code.'/'.$auth_code);
		}
		$this->data['question_bar'] = '0';
		$this->load->view('Frontend/survey_panel/include/header',$this->data);
		$this->load->view('Frontend/survey_panel/index',$this->data);
		$this->load->view('Frontend/survey_panel/include/footer',$this->data); 			
	}*/
	
	public function questions(){
		$survey_code = $this->uri->segment(4);
		$auth_code = $this->uri->segment(5);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'survey/error/not_available');	
		}				
		$this->data['auth_code'] = $auth_code;	
		$this->data['question_bar'] = '1';	
		$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$survey_id = $this->data['survey_detail']->survey_id;
		$per_page = $this->data['survey_detail']->question_per_page;
 		
		$this->Survey_form_mdl->check_already_take_survey($survey_id,$auth_code);
 		$total_row = $this->Survey_form_mdl->surveys_questions_num_rows($survey_id);
		$this->data['total_row'] = $total_row;	
		
		if($this->uri->segment(6)){
			$page = ($this->uri->segment(6));
			$offset = ($page-1)*$per_page;
			$this->data['current_page'] = $offset+1;	
		}else{ 
			$page = 1;
			$this->data['current_page'] = 1;	
		}	
			
		$pagination_pages = $total_row/$per_page;
		if($page< $pagination_pages){
			$next_page =  $page+1 ;
		}else{ $next_page = 'finish';}
		
		if(isset($next_page)&& $next_page!='finish'){
			$this->data['next_page_link'] = base_url() ."survey/form/questions/".$survey_code.'/'.$auth_code.'/'.$next_page;
		}else{
			$this->data['next_page_link'] = base_url() ."survey/finish/".$survey_code.'/'.$auth_code;
			//$this->data['next_page_link'] = base_url() ."survey/complete/".$survey_code.'/'.$auth_code;
		}
		 		
		$this->data['surveys_questions_detail'] = $this->Survey_form_mdl->surveys_questions_detail($survey_id, $per_page, $page);
		$this->load->view('Frontend/survey_panel/include/header',$this->data);
		$this->load->view('Frontend/survey_panel/question',$this->data);
		$this->load->view('Frontend/survey_panel/include/footer',$this->data); 		
	}
	
	
	public function answer_save(){ $this->Survey_form_mdl->answer_save(); }	
	
	public function finish(){		
		$survey_code = $this->uri->segment(3);	
		$auth_code = $this->uri->segment(4);
		$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$survey_id = $this->data['survey_detail']->survey_id;
		$this->data['question_bar'] = '1';
		$this->data['survey_code'] = $survey_code;
		$this->data['survey_id'] = $survey_id;
		$this->data['auth_code'] = $auth_code;
		//$this->Survey_form_mdl->check_already_take_survey($survey_id,$auth_code);
		$this->Survey_form_mdl->update_survey_finish_status($auth_code);
		$this->load->view('Frontend/survey_panel/include/header',$this->data);
		$this->load->view('Frontend/survey_panel/finish',$this->data);
		$this->load->view('Frontend/survey_panel/include/footer',$this->data); 
	}
	
	public function sweepstakes_entry(){ $this->Survey_form_mdl->sweepstakes_entry(); }	
	
	public function error(){	
		$error_type = $this->uri->segment(3);
		if($error_type=='surveynotavailable'){
			$this->load->view('Frontend/survey_panel/error_page/surveynotavailable');
		}
		if($error_type=='survey_deadline_over'){
			$this->load->view('Frontend/survey_panel/error_page/survey_deadline_over');
		}
		if($error_type=='not_available'){
			$this->load->view('Frontend/survey_panel/error_page/not_available');
		}
		if($error_type=='already_taken'){
			$this->load->view('Frontend/survey_panel/error_page/already_taken');
		}
		if($error_type=='survey_deactive'){
			$this->load->view('Frontend/survey_panel/error_page/survey_deactive');
		}
	}
	
	public function thankyou(){
		$survey_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		$this->Survey_form_mdl->update_survey_finish_status($auth_code);	
		$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$this->load->view('Frontend/survey_panel/include/header',$this->data);
		$this->load->view('Frontend/survey_panel/thankyou');
		$this->load->view('Frontend/survey_panel/include/footer',$this->data); 		
	}	
		

}