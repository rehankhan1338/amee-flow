<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_form extends CI_Controller {
 	 
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
		$this->data['preview_title'] = 'Test Preview';
		$test_code = $this->uri->segment(3);
		$this->data['test_code'] = $test_code;
		$this->data['previewLnk'] = base_url().'test/'.$test_code.'?previewSts=1';
		//$this->data['survey_detail'] = $this->Survey_form_mdl->survey_detail_by_code($survey_code);
		$this->load->view('Frontend/preview',$this->data);
	}
	
	public function index(){
		$test_code = $this->uri->segment(2);
		/*$auth_code = $this->uri->segment(3);		
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'test/error/not_available');	
		}
 	 	$this->data['auth_code'] = $auth_code;*/
		
		$this->data['test_detail'] = $this->Test_form_mdl->test_detail_by_code($test_code);
		$testId = $this->data['test_detail']->test_id;
		$current_test_type = $this->data['test_detail']->current_test_type;
		$department_id = $this->data['test_detail']->department_id;
		//$this->Test_form_mdl->check_already_take_test($test_id,$current_test_type,$auth_code);
		$this->data['question_bar'] = '0';
		 
		$this->data['dempgraphy_questions_detail'] = $this->Tests_mdl->tests_questions_detail_by_dept($testId,'1',$department_id);
		//echo '<pre>'; print_r($this->data['dempgraphy_questions_detail']);die;
		$this->data['test_courses_detail'] = $this->Test_form_mdl->test_courses_detail($testId);
		//$this->data['test_auth_code_detail'] = $this->Test_form_mdl->test_auth_code_detail($auth_code);
		
		$this->load->view('Frontend/test_panel/include/header',$this->data);
		$this->load->view('Frontend/test_panel/index',$this->data);
		$this->load->view('Frontend/test_panel/include/footer',$this->data); 
		 			
	}
	
	public function startTestEntry(){
		if(isset($_GET['previewSts']) && $_GET['previewSts']==1){
			echo 'success||0';
		}else{
			$test_code = $this->input->post('h_test_code');
			$test_type = $this->input->post('h_current_test_type');
			$cookie_prefix = $this->config->item('cookie_prefix');
			$expire = time() + (3600*24*60);
			if(isset($_COOKIE[$cookie_prefix.'amee_test_'.$test_code.'_type_'.$test_type]) && $_COOKIE[$cookie_prefix.'amee_test_'.$test_code.'_type_'.$test_type]!=''){
				echo 'error||Sorry, you already taken this test.---'.$_COOKIE[$cookie_prefix.'amee_test_'.$test_code.'_type_'.$test_type];
			}else{
				setcookie($cookie_prefix."amee_test_".$test_code.'_type_'.$test_type, $test_code, $expire , '/');
				echo $this->Test_form_mdl->startTestEntry();			 
			}
		}
	}

	public function questions(){ 
		$test_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		if(!isset($auth_code)&& $auth_code==''){
			redirect(base_url().'test/error/not_available');	
		}
 	 	$this->data['auth_code'] = $auth_code;
		$this->data['test_code'] = $test_code;	
		$this->data['test_detail'] = $this->Test_form_mdl->test_detail_by_code($test_code);
		$test_id = $this->data['test_detail']->test_id;
		$current_test_type = $this->data['test_detail']->current_test_type;
		$this->Test_form_mdl->check_already_take_test($test_id,$current_test_type,$auth_code);
		$this->data['question_bar'] = '1';
 		$per_page = $this->data['test_detail']->question_per_page;
		$total_row = $this->Test_form_mdl->tests_questions_num_rows($test_id);
		$this->data['total_row'] = $total_row;	
		
		if($this->uri->segment(5)){
			$page = ($this->uri->segment(5));
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
			$this->data['next_page_link'] = base_url() ."test/questions/".$test_code.'/'.$auth_code.'/'.$next_page;
		}else{
			$this->data['next_page_link'] = base_url() ."test/result/".$test_code.'/'.$auth_code;
		}
		
		$this->Test_form_mdl->update_test_start_date($test_id,$auth_code,$current_test_type);
		 		
		$this->data['test_questions_detail'] = $this->Test_form_mdl->test_questions_detail($test_id, $per_page, $page);
		$this->load->view('Frontend/test_panel/include/header',$this->data);
		$this->load->view('Frontend/test_panel/question',$this->data);
		$this->load->view('Frontend/test_panel/include/footer',$this->data); 		
	}
	
	
	
	public function answer_save(){ $this->Test_form_mdl->answer_save();	}	
	
	public function result(){
	
		$test_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
 		$this->data['auth_code'] = $auth_code;
  		$this->data['test_detail'] = $this->Test_form_mdl->test_detail_by_code($test_code);
 		$test_id = $this->data['test_detail']->test_id;
		$this->data['test_id'] = $test_id;
 		$current_test_type = $this->data['test_detail']->current_test_type;
		
		$this->data['test_answers_result'] = $this->Test_form_mdl->test_answers_result($test_id,$auth_code,$current_test_type);
		$this->Test_form_mdl->update_test_finish_status($auth_code,$current_test_type);
		
		$this->data['criterion_detail'] = $this->Tests_mdl->get_test_criteion_details($test_id);
		$this->data['test_auth_code_detail'] = $this->Tests_mdl->test_auth_code_detail($auth_code);
		 
		$this->load->view('Frontend/test_panel/include/header',$this->data);
		$this->load->view('Frontend/test_panel/result',$this->data);
		$this->load->view('Frontend/test_panel/include/footer',$this->data); 	
	}
	
	public function self_rating_save(){
		$this->Test_form_mdl->self_rating_save();
	}
	
	public function error(){	
		$error_type = $this->uri->segment(3);
		if($error_type=='testnotavailable'){
			$this->load->view('Frontend/test_panel/error_page/testnotavailable');
		}
		if($error_type=='test_deadline_over'){
			$this->load->view('Frontend/test_panel/error_page/test_deadline_over');
		}
		if($error_type=='not_available'){
			$this->load->view('Frontend/test_panel/error_page/not_available');
		}
		if($error_type=='already_taken'){
			$this->load->view('Frontend/test_panel/error_page/already_taken');
		}
		if($error_type=='test_deactive'){
			$this->load->view('Frontend/test_panel/error_page/test_deactive');
		}
	}
	
	/*public function thankyou(){
		$test_code = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);
		//$this->Survey_form_mdl->update_survey_finish_status($auth_code);	
		$this->data['test_detail'] = $this->Test_form_mdl->test_detail_by_code($test_code);
		$this->load->view('Frontend/survey_panel/include/header',$this->data);
		$this->load->view('Frontend/survey_panel/thankyou');
		$this->load->view('Frontend/survey_panel/include/footer',$this->data); 		
	}*/	
	
}